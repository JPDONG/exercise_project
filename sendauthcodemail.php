<?php
header("Content-Type: text/html; charset=utf-8");
require_once "email.class.php";

function check_input($data){
	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
}
$user_email=check_input($_POST['user_email']);

if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$user_email)) {
		echo "<script>alert('无效的 email 格式！');history.go(-1);</script>";
}else{
	mysql_connect("localhost","root","") or die("connect failed");
	mysql_select_db("exercise_project") or die("select db failed");
	mysql_query("set names 'UTF-8'");
	$sql_select = "select email,code from authcode where email = '$user_email'";
	$result = mysql_query($sql_select);
	$row = mysql_fetch_array($result);
	$num = mysql_num_rows($result); //统计执行结果影响的行数
	//echo $num;  
	if($row){
		$auth_code=$row['code'];
	}else{
		$auth_code = rand(1000,9999);
		//echo $auth_code;
		$sql_insert="insert into authcode values('null','$user_email','$auth_code')";
		$result_insert = mysql_query($sql_insert);
		if(!$result_insert){
			die("系统繁忙");
		}
	}
	$smtpserver = "smtp.qq.com";//SMTP服务器
	$smtpserverport =25;//SMTP服务器端口
	$smtpusermail = "dongjp1994@qq.com";//SMTP服务器的用户邮箱
	$smtpemailto = $user_email;//发送给谁
	$smtpuser = "dongjp1994";//SMTP服务器的用户帐号
	$smtppass = "djp.553030";//SMTP服务器的用户密码
	$mailtitle = "练习系统验证码";//邮件主题
	$mailcontent = "<h1>".$auth_code."</h1>";//邮件内容
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
	//************************ 配置信息 ****************************
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = false;//是否显示发送的调试信息
	$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);

	echo "<div style='width:300px; margin:36px auto;'>";
	if($state==""){
		echo "<script>alert('邮件发送失败！');history.go(-1);</script>";
		exit();
	}
	echo "<script>alert('邮件发送成功！');history.go(-1);</script>";
}
?>