<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use Cookie;
use Illuminate\Support\Str;
use MongoDB\Driver\Session;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
	//注册
    public function reg(){
    	return view('index.register');
    }

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
    
    public function active(Request  $request)
    {
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
    	return view('index.login');
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
            setcookie('user_id',$admin->user_id,time()+3600,'/');
            setcookie('user_name',$admin->user_name,time()+3600,'/');
            return redirect('/');
        }

    }

    public function github(){
        
    }

    
    //退出登录
    public function logout(){
        //清除session
        Cookie::queue(Cookie::forget('user_id'));
        Cookie::queue(Cookie::forget('user_name'));
        return redirect('/login');
    }

}
