<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <script type="text/javascript" src="/yuankong/Public/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="/yuankong/Public/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/yuankong/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
    <link rel="stylesheet" type="text/css" href="/yuankong/Public/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/yuankong/Public/easyui/themes/icon.css">

</head>
<body>

<div id="file" style="width: 30%;height:500px;margin-left: 5%;margin-top: 5%;overflow:scroll;overflow-scrolling:touch">
    <ul id="box"></ul>
</div>
</body>

<script type="text/javascript">
    window.onload = init;
    function file() {
        $("#box").tree({
            url: '<?php echo U("Index/tree");?>',
            lines: true,
            checkbox: true,
        })
    }
    function init() {
        $.post("/yuankong/home/index/before", function (data) {
            file();
            if(data!="exist")
            setTimeout(function () { $("#box").tree("reload");alert("加载完毕！");}, 4000);
        });
    }
    function mScroll(id)
    {$("html,body").stop(true);$("html,body").animate({scrollTop: $("#"+id).offset().top}, 1000);}

    mScroll("file");
</script>
</html>