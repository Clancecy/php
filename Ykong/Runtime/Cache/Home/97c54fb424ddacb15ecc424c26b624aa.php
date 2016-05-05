<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>User Login</title>

    <!-- Our CSS stylesheet file -->
    <link rel="stylesheet" href="/yuankong/Public/assets/css/styles.css" />

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

<div id="formContainer">
    <form id="login" method="post">
        <a href="#" id="flipToRecover" class="flipLink">Forgot?</a>
        <input type="text" name="Name" id="loginEmail" placeholder="username" />
        <input type="password" name="Passwd" id="loginPass" placeholder="pass" />
        <input type="submit" name="submit" value="Login" id="sub"/>
    </form>
    <form id="recover" method="post" action="./">
        <a href="#" id="flipToLogin" class="flipLink">Forgot?</a>
        <input type="text" name="recoverEmail" id="recoverEmail" placeholder="Email" />
        <input type="submit" name="submit" value="Recover" />
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
                                Name:$("#loginEmail").val(),
                                Passwd:$("#loginPass").val()
                            },function(data)
                            {
                                window.location.href="Map.html";
                            });
                }
        );
    });
</script>
</html>