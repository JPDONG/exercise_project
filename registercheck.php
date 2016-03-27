<?php
//error_reporting(E_ALL & ~E_DEPRECATED);
header("Content-Type: text/html; charset=utf-8");

function check_input($data){
	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
}

$user_name=check_input($_POST["user_name"]);
$user_email=check_input($_POST["user_email"]);
$user_password=check_input($_POST["user_password"]);
$check_password=check_input($_POST["check_password"]);

if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$user_email)) {
		echo "<script>alert('无效的 email 格式！');history.go(-1);</script>";
}else if($user_password=="" || $check_password=="" || $user_name==""){
	echo "<script>alert('请填写完整信息！');history.go(-1);</script>";
}else{
	if($user_password == $check_password){
		// $link = mysqli_connect('localhost', 'root', '');
		// mysqli_select_db($link,"filemanager");
		// mysqli_query($link,"set name 'UTF-8'");
		mysql_connect("localhost","root","") or die("connect failed");
	    mysql_select_db("exercise_project") or die("select db failed");
	    mysql_query("set names 'UTF-8'");
	    $sql = "select email from user where email = '$user_email'";
	    $result = mysql_query($sql);
	    //$result = mysqli_query($link,$sql);
	    $num = mysql_num_rows($result); //统计执行结果影响的行数
	    echo $num;  
	    if($num){
	    	echo "<script>alert('邮箱已被注册'); history.go(-1);</script>";
	    }else{
	    	$sql_insert = "insert into user values('null','$user_name','$user_email','$user_password')";  
			$res_insert = mysql_query($sql_insert);  
			if($res_insert){  
					echo "<script>alert('注册成功！');</script>";
					$url = "login.html";
					echo "<script language='javascript' type='text/javascript'>";
					echo "window.location.href='$url'";
					echo "</script>";  
			}else{  
				echo "<script>alert('系统繁忙，请稍候！'); history.go(-1);</script>";  
			}  
		}
	}else{
		echo "<script>alert('密码不一致！');history.go(-1);</script>";
	}    
}
?>