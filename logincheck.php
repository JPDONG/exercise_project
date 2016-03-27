<?php
session_start();
//error_reporting(E_ALL & ~E_DEPRECATED);
header("Content-Type: text/html; charset=utf-8");
function check_input($data){
	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
}
function connect_db(){
	mysql_connect("localhost","root","") or die("connect failed");
    mysql_select_db("exercise_project") or die("select db failed");
    mysql_query("set names 'UTF-8'");
    // $link = mysqli_connect('localhost', 'root', '');
    // mysqli_select_db($link,"filemanager");
    // mysqli_query($link,"set name 'UTF-8'");
    // return $link;
}

	$user_email=check_input($_POST["user_email"]);
	$user_password=check_input($_POST["user_password"]);
	if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$user_email)) {
		echo "<script>alert('无效的 email 格式！');history.go(-1);</script>";
	}else if($user_password == ""){  
		echo "<script>alert('请输入密码！'); history.go(-1);</script>";  
    }else{
    	connect_db();
    	$sql = "select email,password from user where email = '$user_email' and password = '$user_password'";
    	$result = mysql_query($sql);
    	$num = mysql_num_rows($result);
    	if($num){
           
            
                // store session data
            $_SESSION['user_email']=$user_email;

    		// $row = mysql_fetch_array($result);
    		// echo $row[0];
            $url = "./exercisepage/main.html";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";  
    	}else{
    		echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>";
    	}
	}

?>