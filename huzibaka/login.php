<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>huzibaka_login</title>
    <style>
        form{
            width: 260px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <form id="login-form" method="post" action="">
        <h2 align="center">登陆</h2>
        <table>
            <tr><td>用户名：</td><td><input type="text" name="username" id="username"></td></tr>
            <tr><td>密 码：</td><td><input type="password" name="password" id="password"></td></tr>
            <tr><td>验证码：</td><td><input type="text" name="captcha" id="captcha"></td></tr>
            <tr><td colspan="2" align="center"><a href="javascript:;" onclick="this.firstElementChild.src='captcha.php?'+Math.random()">
                        <img id="captcha-img" src="captcha.php"></a></td></tr>
            <tr><td colspan="2" align="center">
                    <div style="margin-top: 12px;"><input type="submit" value="登陆" style="border-radius:18px;width: 100px;height: 30px;"></div>
                </td></tr>
        </table>
    </form>
</body>
</html>

<?php
    if($_POST){
        if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['captcha']) ) {
            die('不能为空');
        }
        session_start();
        $captcha = strtolower($_POST['captcha']);
        $name = $_POST['username'];
        $password = $_POST['password'];
        if($captcha != strtolower($_SESSION['captcha'])) {
            die('验证码错误');
        }

        require '../common/functions.php';
        $con = connect_db();

        $sql = "SELECT `password` FROM `huka_admins` WHERE `name`='".$name."' ";

        $rst = $con->query($sql);
        if(!$rst) {
            die('不存在该管理员');
        } else {
            $row = $rst->fetch_row();
            if($row[0] == md5($password)) {
                $_SESSION['username'] = $name;
                echo "<script>window.location.href='http://".$_SERVER['HTTP_HOST']."/huzibaka/index.php'</script>";
            } else {
                echo $row[0];
                die('密码错误');
            }
        }

    }