<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 打印函数
 */
function p($var){
    if($var===false){
        var_dump($var);
    }else{
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

/**
 *  API返回信息格式函数 ；失败：code=110，成功：code=200
 * @param string $code
 * @param string $message
 * @param array $data
 */
function apiResponse($code = '110', $message = '',$data = array()){
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json; charset=utf-8');
    $result = array(
        'code'=>$code,
        'message'=>$message,
        'data'=>$data,
        // 'nums'=>''.$nums
    );
    die(json_encode($result,JSON_UNESCAPED_UNICODE));
}

//获取ip地址
function get_ip(){
  if (isset($_SERVER)) {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $realip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
      $realip = $_SERVER['REMOTE_ADDR'];
    }
  } else {
    if (getenv("HTTP_X_FORWARDED_FOR")) {
      $realip = getenv( "HTTP_X_FORWARDED_FOR");
    } elseif (getenv("HTTP_CLIENT_IP")) {
      $realip = getenv("HTTP_CLIENT_IP");
    } else {
      $realip = getenv("REMOTE_ADDR");
    }
  }
  return $realip;
}

