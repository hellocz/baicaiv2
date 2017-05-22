<?php

function addslashes_deep($value) {
    $value = is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    return $value;
}

function stripslashes_deep($value) {
    if (is_array($value)) {
        $value = array_map('stripslashes_deep', $value);
    } elseif (is_object($value)) {
        $vars = get_object_vars($value);
        foreach ($vars as $key => $data) {
            $value->{$key} = stripslashes_deep($data);
        }
    } else {
        $value = stripslashes($value);
    }

    return $value;
}

function todaytime() {
    return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
}

/**
 * 友好时间
 */
function fdate($time) {
    if (!$time)
        return false;
    $fdate = '';
    $d = time() - intval($time);
    $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //年
    $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //月
    $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
    $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
    $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
    $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
    $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
    if ($d == 0) {
        $fdate = '刚刚';
    } else {
        switch ($d) {
            case $d < $atd:
                $fdate = date('Y年m月d日', $time);
                break;
            case $d < $td:
                $fdate = '后天' . date('H:i', $time);
                break;
            case $d < 0:
                $fdate = '明天' . date('H:i', $time);
                break;
            case $d < 60:
                $fdate = $d . '秒前';
                break;
            case $d < 3600:
                $fdate = floor($d / 60) . '分钟前';
                break;
            case $d < $dd:
                $fdate = floor($d / 3600) . '小时前';
                break;
            case $d < $yd:
                $fdate = '昨天' . date('H:i', $time);
                break;
            case $d < $byd:
                $fdate = '前天' . date('H:i', $time);
                break;
            case $d < $md:
                $fdate = date('Y年m月d日 H:i', $time);
                break;
            case $d < $ld:
                $fdate = date('Y年m月d日 H:i', $time);
                break;
            default:
                $fdate = date('Y年m月d日 H:i', $time);
                break;
        }
    }
    return $fdate;
}

/**
 * 获取用户头像
 */
function avatar($uid, $size) {
    $avatar_size = explode(',', C('pin_avatar_size'));
    $size = in_array($size, $avatar_size) ? $size : '100';
    $avatar_dir = avatar_dir($uid);
    $avatar_file = $avatar_dir . md5($uid) . "_{$size}.jpg";
    if (!is_file(C('pin_attach_path') . 'avatar/' . $avatar_file)) {
        $avatar_file = "default_{$size}.jpg";
    }
    return __ROOT__ . '/' . C('pin_attach_path') . 'avatar/' . $avatar_file;
}

function avatar_dir($uid) {
    $uid = abs(intval($uid));
    $suid = sprintf("%09d", $uid);
    $dir1 = substr($suid, 0, 3);
    $dir2 = substr($suid, 3, 2);
    $dir3 = substr($suid, 5, 2);
    return $dir1 . '/' . $dir2 . '/' . $dir3 . '/';
}

function attach($attach, $type) {
	if($attach==""){
		return "/images/nopic.jpg";
	}else{
		if(false === strpos($attach, 'http://')) {
			//本地附件
			return __ROOT__ . '/' . C('pin_attach_path') . $type . '/' . $attach;
			//远程附件
			//todo...
		} else {
			//URL链接
			return $attach;
		}
	}
}

/*
 * 获取缩略图
 */

function get_thumb($img, $suffix = '_thumb') {
    if (false === strpos($img, 'http://')) {
        $ext = array_pop(explode('.', $img));
        $thumb = str_replace('.' . $ext, $suffix . '.' . $ext, $img);
    } else {
        if (false !== strpos($img, 'taobaocdn.com') || false !== strpos($img, 'taobao.com')) {
            //淘宝图片 _s _m _b
            switch ($suffix) {
                case '_s':
                    $thumb = $img . '_100x100.jpg';
                    break;
                case '_m':
                    $thumb = $img . '_210x1000.jpg';
                    break;
                case '_b':
                    $thumb = $img . '_480x480.jpg';
                    break;
            }
        }
    }
    return $thumb;
}

/**
 * 对象转换成数组
 */
function object_to_array($obj) {
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    foreach ($_arr as $key => $val) {
        $val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
        $arr[$key] = $val;
    }
    return $arr;
}
/*获取商品来源*/
function getly($orig_id){
	$str = M("item_orig")->where("id=$orig_id")->getField('name');
	return $str;
}
/*获取用户名*/
function get_uname($uid){
	$uname = M("user")->where("id='$uid'")->getField("username");
	return $uname;
}
/*获取商城导航*/
function getdh(){
	$dh=M("item_orig")->order("ordid asc")->limit(12)->select();
	$str = "";
	foreach($dh as $key=>$val){
		$str .= "<a href='".U('go/index',array("to"=>base64_encode("http://".$val['url'])))."' title='$val[name]' target='_blank'>".$val['name']."</a>";
	}
	return $str;
}
/*面包削*/
function getpos($id,$str=''){
	$pstr=M("item_cate")->where("id=$id")->field("id,name,pid")->find();
	if($pstr['pid']!='0'){
		if($str==""){
			$str = "<a href='".U('book/cate',array('cid'=>$id))."'>".$pstr['name']."</a>";
		}else{
			$str = "<a href='".U('book/cate',array('cid'=>$id))."'>".$pstr['name']."</a> > ".$str;
		}
		$str = getpos($pstr['pid'],$str);
	}else{
		if($str==""){
			$str = "<a href='".U('article/index',array('id'=>$id))."'>".$pstr['name']."</a> ";
		}else{
			$str = "<a href='".U('book/cate',array('cid'=>$id))."'>".$pstr['name']."</a> > ".$str;
		}
	}
	return $str;
}
/*文章类面包削*/
function getapos($id,$str=''){
	$pstr=M("article_cate")->where("id='$id'")->find();
	if($pstr['pid']!='0'){
		if($str==""){
			$str = "<a href='".U('article/index',array('id'=>$id))."'>".$pstr['name']."</a>";
		}else{
			$str = "<a href='".U('article/index',array('id'=>$id))."'>".$pstr['name']."</a> > ".$str;
		}
		$str = getapos($pstr['pid'],$str);
	}else{
		if($str==""){
			$str = "<a href='".U('article/index',array('id'=>$id))."'>".$pstr['name']."</a> ";
		}else{
			$str = "<a href='".U('article/index',array('id'=>$id))."'>".$pstr['name']."</a> > ".$str;
		}
	}
	return $str;
}
//获取IP地址
function getip(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
	  $cip = $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
	  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif(!empty($_SERVER["REMOTE_ADDR"])){
	  $cip = $_SERVER["REMOTE_ADDR"];
	}
	else{
	  $cip = "无法获取！";
	}
	return $cip;
}
//文章类根栏目
function getbcid($id){
	$myid=M("article_cate")->where("id='$id'")->field('id,pid')->find();
	if($myid['pid']!='0'){
		$bcid = getbcid($myid['pid']);
	}else{
		$bcid = $myid['id'];
	}
	return $bcid;
}
//商品栏目名
function getcate($id){
	$str = M("item_cate")->where("id=$id")->getField('name');
	return $str;
}
//获取积分商品图片
function score_item_img($id){
	$img = M("score_item")->where("id=$id")->getField("img");
	$img = attach($img,'score_item');
	return $img;
}
//获取商城图片
function orig_img($id){
	$img = M("item_orig")->where("id=$id")->getField("img_url");
	if($img){
		$img = attach($img,"item_orig");
		return $img;
	}else{
		return '/images/nopic.jpg';
	}
}
//获取评论对象名称
function get_item_name($id,$xid){
	switch($xid){
		case "1":$mod=M('item');$name="title";break;
		case "2":$mod=M("zr");$name="title";break;
		case "3":$mod=M("article");$name="title";break;
		case "4":$mod=M("comment");$name="info";break;
	}
	$str = $mod->where("id=$id")->getField($name);
	return $str;
}
//获取模型对象
function get_mod($xid){
	switch($xid){
		case "1":$mod_s=M("item");break;
		case "2":$mod_s=M("zr");break;
		case "3":$mod_s=M("article");break;
	}
	return $mod_s;
}
//获取是否收藏
function islikes($itemid,$xid,$uid){
	$islike=M("likes")->where("uid=$uid and itemid=$itemid and xid=$xid")->find();
	if($islike){return "sz_11_l";}else{return "sz_11";}
}
//积分日志
function set_score_log($user,$action,$score,$coin,$offer,$exp){
	$score_log_mod = D('score_log');
	$score_log_mod->create(array(
		'uid' => $user['id'],
		'uname' => $user['username'],
		'action' => $action,
		'score' => $score,
		'coin' => $coin,
		'offer' => $offer,
		'exp' => $exp,
	));
	$score_log_mod->add();
}
//设置积分，金币等
function set_score($user,$score,$coin,$offer,$exp){
	$data['score']=$user['score']+$score;
	$data['coin']=$user['coin']+$coin;
	$data['exp']=$user['exp']+$exp;
	$data['offer']=$user['offer']+$offer;
	M("user")->where("id=$user[id]")->save($data);
}
//设置SEO
function set_seo($str){
	return array('title'=>$str."-".C('pin_site_name'),'keywords'=>$str."-".C('pin_site_name'),'description'=>$str."-".C('pin_site_name'));
}
?>