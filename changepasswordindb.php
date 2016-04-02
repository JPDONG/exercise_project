<?php
error_reporting(E_ALL & ~E_DEPRECATED);
header("Content-Type: text/html; charset=utf-8");
function check_input($data){
	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
}
$user_email=$_SESSION['user_email'];
$user_password=check_input($_POST['user_password']);
$check_password=check_input($_POST['check_password']);
if($user_password == $check_password){
	mysql_connect("localhost","root","") or die("connect failed");
	mysql_select_db("filemanager") or die("select db failed");
	mysql_query("set names 'UTF-8'");
	$sql="update user set password = '$user_password' WHERE email = '$user_email'";
	$result = mysql_query($sql);
	if($result){
		echo "<script>alert('修改成功！');</script>";
		$url = "index.html";
		echo "<script language='javascript' type='text/javascript'>";
		echo "window.location.href='$url'";
		echo "</script>";  
	}else{
		echo "<script>alert('系统繁忙');history.go(-1);</script>";
	}
}else{
	echo "<script>alert('两次密码不一致');history.go(-1);</script>";
}

?>