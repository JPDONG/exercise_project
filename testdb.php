<?php
mysql_connect("localhost", "root", "") or die("connect failed");
mysql_select_db("exercise_project") or die("select db failed");
mysql_query("set names 'UTF-8'");
$sql = "select email from user ";
$result = mysql_query($sql);
//$result = mysqli_query($link,$sql);
$num = mysql_num_rows($result);
//统计执行结果影响的行数
echo $num;
?>