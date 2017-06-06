<?php
/**
* 微信授权相关接口
*
*/
class wechat {

//高级功能-》开发者模式-》获取
private $app_id = 'wxcc3cbc204eb9b191';//公众号appid
private $app_secret = '76902a6ca89b6201aac32163f991a04b'; //公众号app_secret

 function __construct($appid, $appkey) {
        $this->app_id = $appid;
        $this->app_secret = $appkey;
    }

/**
* 获取微信授权链接
*
* @param string $redirect_uri 跳转地址
* @param mixed $state 参数
*/
public function getAuthorizeURL($redirect_uri,$state)
{
//$redirect_uri = urlencode($this->redirect_uri);
return "https://open.weixin.qq.com/connect/qrconnect?appid={$this->app_id}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
}
/**
* 获取授权token
*
* @param string $code 通过get_authorize_url获取到的code
*/
public function getAccessToken($code)
{
$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_secret}&code={$code}&grant_type=authorization_code";
$token_data = $this->http($token_url);


if($token_data[0] == 200)
{
return json_decode($token_data[1], TRUE);
}

return FALSE;
}


/**
* 获取授权后的微信用户信息
*
* @param string $access_token
* @param string $open_id
*/
public function getUserInfo($access_token,$open_id)
{
if($access_token && $open_id)
{
$info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
$info_data = $this->http($info_url);

if($info_data[0] == 200)
{
return json_decode($info_data[1], TRUE);
}
}

return FALSE;
}

public function http($url, $method, $postfields = null, $headers = array(), $debug = true)
{
$ci = curl_init();
/* Curl settings */
curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ci, CURLOPT_TIMEOUT, 30);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

switch ($method) {
case 'POST':
curl_setopt($ci, CURLOPT_POST, true);
if (!empty($postfields)) {
curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
$this->postdata = $postfields;
}
break;
}
curl_setopt($ci, CURLOPT_URL, $url);
curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ci, CURLINFO_HEADER_OUT, true);

$response = curl_exec($ci);
$http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);

if ($debug) {
echo "=====post data======\r\n";
var_dump($postfields);

echo '=====info=====' . "\r\n";
print_r(curl_getinfo($ci));

echo '=====$response=====' . "\r\n";
print_r($response);
}
curl_close($ci);
return array($http_code, $response);
}

}