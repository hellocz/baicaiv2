<?php 
class rssAction extends frontendAction {
function post_to_sina_weibo($post_ID) {
if( wp_is_post_revision($post_ID) ) return;// 将 abc 替换成你的新浪微博登陆名
$username = "shiqian1980@gmail.com";
// 将 123 替换成你的新浪微博密码
$password = "88XCCCM-";
$get_post_info = get_post($post_ID);
if ( $get_post_info->post_status == 'publish' && $_POST['original_post_status'] != 'publish' ) {
$request = new WP_Http;
$status = strip_tags( $_POST['post_title'] ) . ' ' . urlencode( get_permalink($post_ID) );
$api_url = 'http://api.t.sina.com.cn/statuses/update.json';
$body = array( 'status' => $status, 'source'=>'123456789');
$headers = array( 'Authorization' => 'Basic ' . base64_encode("$username:$password") );
$result = $request->post( $api_url , array( 'body' => $body, 'headers' => $headers ) );
}
}

}
?>