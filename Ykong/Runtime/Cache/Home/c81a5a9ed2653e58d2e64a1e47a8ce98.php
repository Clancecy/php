<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>User Login</title>

    <!-- Our CSS stylesheet file -->
    <link rel="stylesheet" href="/yuankong/Public/assets/css/styles.css"/>

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

<div id="formContainer">
    <form id="login" method="post">
        <a href="#" id="flipToRecover" class="flipLink">Forgot?</a>
        <input type="text" name="Name" id="loginEmail" placeholder="username"/>
        <input type="password" name="Passwd" id="loginPass" placeholder="pass"/>
        <input type="submit" name="submit" value="Login" id="sub"/>
    </form>
    <form id="recover" method="post">
        <a href="#" id="flipToLogin" class="flipLink">Forgot?</a>
        <input type="text" name="recoverEmail" id="recoverEmail" placeholder="Email"/>
        <input type="submit" name="submit" value="Recover" id="reset"/>
    </form>
</div>
<!-- JavaScript includes -->
<script type="text/javascript" src="/yuankong/Public/easyui/jquery.min.js"></script>
<script src="/yuankong/Public/assets/js/script.js"></script>

</body>

<script type="text/javascript">
    $(function () {
        $("#sub").click(
                function () {
                    $.post("/yuankong/home/user/checkuser",
                            {
                                Name: $("#loginEmail").val(),
                                Passwd: $("#loginPass").val()
                            }, function (data) {
                                if (data.toString() == "1")
                                    window.location.href = "<?php echo U('User/Map');?>";
                                else
                                    alert("用户名或密码错误！");
                            });
                    return false;
                }
        );


        $("#reset").click(
                function () {
                    $.post("/yuankong/home/index/send",
                            {
                                Email: $("#recoverEmail").val()
                            }, function (data) {
                                if (data.toString() == "1") {
                                    alert("修改成功！");
                                    $("#flipToLogin").click();
                                }
                                else {
                                    alert(data.toString());
                                }
                            });
                }
        );

    });
</script>
</html>