<?php

namespace App\Http\Controllers\Index;
use GuzzleHttp\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use Cookie;
use App\Model\GithubUserModel;
use Illuminate\Support\Str;
use MongoDB\Driver\Session;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
	//注册
    public function reg(){
    	return view('index.register');
    }
    //用户进行注册
    public function regdo(request $request){
        $post=request()->except('_token');
        //表单验证
        $validate = $request->validate([
            'user_name'     => 'required | min:2',
            'email'    => 'required | email',
            'password'          => 'required | min:6 ',
            'password1'    => 'required | min:6 | same:password',
            'tel' => 'required |regex:/^\d{11}$/',
        ],[
        'user_name.required'=>'用户名不能为空',
        'user_name.min'=>'用户名最少为2位',
        'email.required'=>'邮箱不能为空',
        'email.email'=>'邮箱必须以@',
        'password.required'=>'密码不能为空',
        'password.min'=>'密码不能少于6位',
        'password1.required'=>'确认密码不能为空',
        'password1.min'=>'确认密码不能少于6位',
        'password1.same'=>'确认密码和密码不一致',
        'tel.required'=>'电话不能为空',
        'tel.regex'=>'电话必须为11位',
     ]);
        //密码加密
		$password = password_hash($request->post('password'),PASSWORD_DEFAULT);
    	//入库
    	$user=[
            'user_name' => $request->post('user_name'),
            'email'     => $request->post('email'),
            'password'  => $password,
    		'tel'=>$request->post('tel'),
    		'reg_time'=>time(),
    	];
        //添加入库
    	$res=Users::insertGetId($user);

        $active_code = Str::random(64);
        $redis_active_key = 'ss:index:active';
        $cc = Redis::zAdd($redis_active_key,$res,$active_code);
        $active_url = env('APP_URL').'/index/active?code='.$active_code;
        header("refresh:2;url=$active_url");//注册成功后跳转至邮箱验证
        echo $active_url;die;
        //注册成功跳转登录
    	if($res){
    		return redirect('/login');
    	}
        return redirect('/user/regist');
    }
    //激活用户
    public function active(Request  $request){
        $active_code = $request->get('code');
        echo "激活码：".$active_code;echo '</br>';
        $redis_active_key = 'ss:index:active';
        // echo ($redis_active_key);
        $uid = Redis::zScore($redis_active_key,$active_code);
        // echo $uid;
        if($uid){
            echo "user_id: ". $uid;echo '</br>';
            //激活用户
            Users::where(['user_id'=>$uid])->update(['is_validated'=>1]);
            echo "激活成功";
            //删除集合中的激活码
            Redis::zRem($redis_active_key,$active_code);
            header("refresh:3;url=/login");
        }else{
            echo "没有此用户";
            header("refresh:2;url=/register");
        }
    }

    //登录
    public function login(){
        $data = [
            'login_url' => 'https://github.com/login/oauth/authorize?client_id=f84162d2f8c36be252c9'
        ];
    	return view('index.login',$data);
    }

    //进行登录
    public function logindo(request $request){
    	$user_name=$request->input('user_name');//获取用户账号
        $password=$request->input('password');//获取用户密码
        $date['last_login'] = time();//获取当前时间
        $date["last_ip"] = ip2long($_SERVER['DB_HOST']);//获取ip

        //存入redis
        $key='jd_'.$user_name;
        $count=Redis::get($key);//检测用户是否已被锁定
        //判断密码错误次数
        if($count>=5)
        {
            Redis::expire($key,3600);
            echo "输入密码错误次数太多，用户已被锁定1小时，请稍后再试";
            die;
        }
        //使用邮箱、手机号、用户名进行登录
        $admin=Users::where(['user_name'=>$user_name])
            ->orWhere(['tel'=>$user_name])
            ->orWhere(['email'=>$user_name])
            ->first();

        //判断用户是否存在
        if(empty($user_name))
        {
            die("用户不存在");
        }
        
        $p=password_verify($password,$admin->password);//密码验证
        if(!$p)
        {
            //密码不正确  记录错误次数
            $count=Redis::incr($key);
            Redis::expire($key,600);            //10分钟
            echo "密码不正确!"."密码错误次数:".$count;die;
        }
        // 记录登录信息
        $key = 'login:time:'.$admin->user_id;
        Redis::rpush($key,time());

        //登录成功
        if($admin){
            $admins=Users::where("user_id",$admin->user_id)->update($date);
            session(['user_id'=>$admin['user_id'],'user_name'=>$admin['user_name']]);
            setcookie('user_id',$admin->user_id,time()+3600,'/');
            setcookie('user_name',$admin->user_name,time()+3600,'/');
            return redirect('/');
        }
    }

    //github登录
    public function githubLogin(Request $request)
    {
        // 接收code
        $code = $_GET['code'];
        //换取access_token
        $token = $this->getAccessToken($code);
        //获取用户信息
        $git_user = $this->getGithubUserInfo($token);
        //判断用户是否已存在，不存在则入库新用户
        $u = GithubUserModel::where(['guid'=>$git_user['id']])->first();
        if($u)          //存在
        {
            //登录逻辑
            $this->webLogin($u->uid);
        }else{          //不存在
            //在用户主表中创建新用户  获取 uid
            $new_user = [
                'user_name' => Str::random(10)              //生成随机用户名，用户有一次修改机会
            ];
            $uid = UserModel::insertGetId($new_user);
            // 在 github 用户表中记录新用户
            $info = [
                'uid'                   => $uid,       //作为本站新用户
                'guid'                  => $git_user['id'],         //github用户id
                'avatar'                =>  $git_user['avatar_url'],
                'github_url'            =>  $git_user['html_url'],
                'github_username'       =>  $git_user['name'],
                'github_email'          =>  $git_user['email'],
                'add_time'              =>  time()
            ];
            $guid = GithubUserModel::insertGetId($info);        //插入新纪录
            // TODO 登录逻辑
            $this->webLogin($uid);
        }
        //将 token 返回给客户端
        return redirect('/');       //登录成功 返回首页
    }
    /**
     * 根据code 换取 token
     */
    protected function getAccessToken($code)
    {
        $url = 'https://github.com/login/oauth/access_token';

        //post 接口  Guzzle or  curl
        $client = new Client();
        $response = $client->request('POST',$url,[
            'verify'    => false,
            'form_params'   => [
                'client_id'         => env('OAUTH_GITHUB_ID'),
                'client_secret'     => env('OAUTH_GITHUB_SEC'),
                'code'              => $code 
            ]
        ]);
        parse_str($response->getBody(),$str); // 返回字符串 access_token=59a8a45407f1c01126f98b5db256f078e54f6d18&scope=&token_type=bearer
        return $str['access_token'];
    }

    /**
     * 获取github个人信息
     * @param $token
     */
    protected function getGithubUserInfo($token)
    {
        $url = 'https://api.github.com/user';
        //GET 请求接口
        $client = new Client();
        $response = $client->request('GET',$url,[
            'verify'    => false,
            'headers'   => [
                'Authorization' => "token $token"
            ]
        ]);
        return json_decode($response->getBody(),true);
    }

    /**
     * WEB登录逻辑
     */
    protected function webLogin($uid)
    {

        //将登录信息保存至session uid 与 token写入 seesion
        session(['uid'=>$uid]);

    }

    //退出登录
    public function logout(){
        //清除session
        Cookie::queue(Cookie::forget('user_id'));
        Cookie::queue(Cookie::forget('user_name'));
        return redirect('/login');
    }

}

 