<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>点标记</title>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.1.min.js"></script>
    <script type="text/javascript" src="/yuankong/Public/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="/yuankong/Public/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/yuankong/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
    <link rel="stylesheet" type="text/css" href="/yuankong/Public/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/yuankong/Public/easyui/themes/icon.css">
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <script src="http://webapi.amap.com/maps?v=1.3&key=0b50a7f73f2820d8f45c1c1a18cfb644&&callback=init"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
</head>
<body>
<div id="tt" class="easyui-tabs" style="width: 40%;height:500px;margin-left: 5%;margin-top: 5%">

    <div title="常用文件" id="ufile"
         style="width: 40%;border:1px solid gray;height:500px;overflow:scroll;overflow-scrolling:touch">
        <ul id="obox"></ul>
    </div>
    <div title="手机储存" id="file"
         style="width: 40%;border:1px solid gray;height:500px;overflow:scroll;overflow-scrolling:touch">
        <ul id="box"></ul>
    </div>
</div>
<div id="bt" style="margin-left: 5%">
    <label><input id="allsec" type="checkbox" value=""/>全选</label>
    <label><input id="allnotsec" type="checkbox" value=""/>全不选</label>
    <input id="del" type="button" value="删除"/>
    <input id="sav" type="button" value="备份"/>
</div>
<div style="width:45%; height:500px;border:1px solid gray;margin-left: 50%;margin-top: 5%" id="container">
</div>
<script>
    window.onload = inittree;
    var px;
    var py;
    function init() {
        $.post("/yuankong/home/index/getxy",
                function (data, status) {
                    // alert("Data: " + data + "\nStatus: " + status);
                    if (status) {
                        data = $.parseJSON(data);
                        px = parseFloat(data.x);
                        py = parseFloat(data.y);
                        var marker, map = new AMap.Map("container", {
                            resizeEnable: true,
                            center: [px, py],
                            zoom: 17
                        });
                        if (marker) {
                            return;
                        }
                        marker = new AMap.Marker({
                            icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
                            position: [px, py]
                        });
                        marker.setMap(map);
                    }
                });
    }


    function file() {
        $("#box").tree({
            url: '<?php echo U("Index/tree");?>',
            lines: true,
            checkbox: true,

        });
        $("#obox").tree({
            url: '<?php echo U("Index/often");?>',
            lines: true,
            checkbox: true,
        });
    }
    function inittree() {
        $.post("/yuankong/home/index/before", function (data) {
            file();
        });
    }

    $("#tt").tabs({
        tabPosition: "left",
        headerWidth: $("#tt").width() * 0.17,
        tabHeight: 50
    })
    $(document).click(function () {
        alert($("#tt").width());
    })

</script>
</body>
</html>