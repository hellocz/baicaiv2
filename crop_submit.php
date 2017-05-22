<?php
$pic_name=$_REQUEST['pic_name'];
$x=$_REQUEST['x'];
$y=$_REQUEST['y'];
$w=$_REQUEST['w'];
$h=$_REQUEST['h'];
$targ_w = $targ_h = 200;
include_once("jcrop_image.class.php");
$filep="upload/";
$crop=new jcrop_image($filep, $pic_name,$x,$y,$w,$h,$targ_w,$targ_h);
$file=$crop->crop();
echo(1);
die();
?>