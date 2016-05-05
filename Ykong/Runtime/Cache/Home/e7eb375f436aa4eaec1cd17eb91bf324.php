<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <script type="text/javascript" src="./easyui/jquery.min.js"></script>
    <script type="text/javascript" src="./easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="./easyui/locale/easyui-lang-zh_CN.js"></script>
    <link rel="stylesheet" type="text/css" href="./easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="./easyui/themes/icon.css">

</head>
<body>
<ul id="box"></ul>
</body>

<script type="text/javascript">
    $(function () {
        $("#box").tree({
            url:'<?php echo U("Index/tree");?>',
            lines:true,
        })
    })
</script>
</html>