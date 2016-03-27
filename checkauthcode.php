<html>
<head>
	<meta charset="UTF-8">
	<title>change password</title>
	<style type="text/css">
	p{margin: 10px;}
	.submit{margin-top: 10px;}
	</style>
</head>
<body align="center">
<?php
error_reporting(E_ALL & ~E_DEPRECATED);
function check_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$user_email=check_input($_POST['user_email']);
$auth_code=check_input($_POST['auth_code']);

if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$user_email)) {
		echo "<script>alert('无效的 email 格式！');history.go(-1);</script>";
}else if($auth_code==""){
	echo "<script>alert('请填写验证码！');history.go(-1);</script>";
}else{
	mysql_connect("localhost","root","") or die("connect failed");
	mysql_select_db("exercise_project") or die("select db failed");
	mysql_query("set names 'UTF-8'");
	$sql = "select email,code from authcode where email = '$user_email'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['email'] == $user_email && $row['code'] == $auth_code){
		echo "<h2>修改密码</h2>";
		echo "<form action='changepassword.php' method='post'>";
		echo "<p>填写新密码：<input type='password' name='user_password'><br>";
		echo "<p>确认新密码：<input type='password' name='check_password'><br>";
		echo "<input type='hidden' name='user_email' value='$user_email' />";
		echo "<input class='submit' type='submit'></form>";
	}else{
		echo "<script>alert('邮箱或验证码错误'); history.go(-1);</script>";
		//die("邮箱或验证码错误");
	}
}
?>


</body>
</html>

