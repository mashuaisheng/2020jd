<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TestController extends Controller
{
	
    public function test(){
        $uri="https://devapi.qweather.com/v7/weather/now?location=101010700&key=90f307820b5745cf8ff8b928a5069eb4&gzip=n";
        $json_str=file_get_contents($uri);
        $data=json_decode($json_str);
        echo '<pre>';print_r($data);echo '</pre>';
    }
    public function test1(){
        $uri="https://devapi.qweather.com/v7/weather/now?location=101010700&key=90f307820b5745cf8ff8b928a5069eb4&gzip=n";
        // 创建一个新cURL资源
        $ch = curl_init();

        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //关闭HTTPS验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        // 抓取URL并把它传递给浏览器
        $json_str=curl_exec($ch);

        //捕获错误
        $err_no=curl_errno($ch);
        if($err_no){
            $err_msg =curl_error($ch);
            echo "错误信息：".$err_msg;
            die;
        }
        
        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);

        $data =json_decode($json_str,true);
        echo '<pre>';print_r($data);echo '</pre>';
    }

    public function guzzle(){
        $uri="https://devapi.qweather.com/v7/weather/now?location=101010700&key=90f307820b5745cf8ff8b928a5069eb4";
        $client=new Client();
        $res=$client->request('GET',$uri,['verify'=>false]);
        $body = $res->getBody();

        $data=json_decode($body,true);
        echo '<pre>';print_r($data);echo '</pre>';
    }

    public function guzzlepost(){
        $uri="https://devapi.qweather.com/v7/weather/now?location=101010700&key=90f307820b5745cf8ff8b928a5069eb4&gzip=n";
        $client=new Client();
        $res=$client->request('POST',$uri,[
                'form_params' => [
                    'field_name' => 'abc',
                    'other_field' => '123',
                    'nested_field' => [
                        'nested' => 'hello'
                    ],['verify'=>true]
                ]
            ]);
        $body = $res->getBody();

        $data=json_decode($body,true);
        echo '<pre>';print_r($data);echo '</pre>';
    }

    public function aaa($a=0,&$result=array()){
            $a++;
            if ($a<10) {
             $result[]=$a;
             test($a,$result);
            }
            echo $a;
            return $result;
            }

}
