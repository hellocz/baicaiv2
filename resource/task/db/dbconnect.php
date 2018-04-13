<?php
$con = mysqli_connect("localhost","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  else{
  mysqli_set_charset($con, "utf8");
  mysqli_select_db($con,"xl_baicai");
  }

// some code

?>