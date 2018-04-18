<?php 
require '../common/functions.php';
$now_user = now_user();
    if(!$now_user) {
    	header('Location:login.php');
    }
?>
<h2 align="center">修改密码 | <a href="quit.php">退出后台</a></h2>
<form action="" method="post">
	<table align="center">
            <tr><td>原密码：</td><td><input type="password" name="or-pwd" ></td></tr>
            <tr><td>新密码：</td><td><input type="password" name="now-pwd" ></td></tr>
            <tr><td>再次输入：</td><td><input type="password" name="now-pwd-aga"></td></tr>
            <tr><td></td><td><input type="submit" value="确认"></td></tr>
    </table>
    <a href='index.php'>返回</a>
</form>
<?php
if($_POST){
	if(empty($_POST['or-pwd']) || empty($_POST['now-pwd']) || empty($_POST['now-pwd-aga']) ) {
            die('不能为空');
    }
    if($_POST['now-pwd'] != $_POST['now-pwd-aga']) {
    	die('两次输入密码不一致');
    }
    $orpwd = md5($_POST['or-pwd']);
    $nowpwd = md5($_POST['now-pwd']);
    $con = connect_db();
    $sql = "SELECT password FROM `huka_admins` WHERE name='".$now_user."'";
    $password = $con->query($sql)->fetch_row(); 
    if($password[0] != $orpwd ) {
    	die('原密码不正确');
    }else {
    	$update_sql = "UPDATE `huka_admins` SET password='".$nowpwd."' WHERE name = '".$now_user."'";
    	$con->query($update_sql);
    	if($con->affected_rows) {
    		echo "修改成功"."<br>";
    	}
    }

}
