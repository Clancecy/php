<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>点标记</title>

    <link rel="stylesheet" type="text/css" href="/yuankong/Public/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/yuankong/Public/easyui/themes/icon.css">
    <link rel="stylesheet" href="/yuankong/Public/assets/css/buttons.css"/>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <script src="http://webapi.amap.com/maps?v=1.3&key=0b50a7f73f2820d8f45c1c1a18cfb644"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.1.min.js"></script>
    <script type="text/javascript" src="/yuankong/Public/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="/yuankong/Public/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/yuankong/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
    <style>
        .marker {
            color: #ff6600;
            padding: 4px 10px;
            border: 1px solid #fff;
            white-space: nowrap;
            font-size: 12px;
            font-family: "";
            background-color: #0066ff;
        }
    </style>
</head>
<body>
<div>
欢迎您，<?php echo (session('Name')); ?>  <a href="<?php echo U('User/Logout');?>">注销</a>
</div>
<div style="width: 100%;height:500px;margin-left:5%;margin-top: 2%">
<div id="tt" class="easyui-tabs" style="width: 40%;height: 100%">

    <div title="常用文件" id="ufile"
         style="width: 40%;border:1px solid gray;height:500px;overflow:scroll;overflow-scrolling:touch">
        <ul id="obox"></ul>
    </div>
    <div title="手机储存" id="file"
         style="width: 40%;border:1px solid gray;height:500px;overflow:scroll;overflow-scrolling:touch">
        <ul id="box"></ul>
    </div>
</div>
    <br>
    <div>
        <button class="button button-primary button-rounded button-jumbo" id="Del" disabled="disabled">Go</button>
        <a href="http://www.bootcss.com/" class="button button-primary button-rounded button-jumbo">Go</a>
        <a href="http://www.bootcss.com/" class="button button-primary button-rounded button-jumbo">Go</a>
        <br>
        <br>
        <a href="http://www.bootcss.com/" class="button button-primary button-rounded button-jumbo">Go</a>
        <a href="http://www.bootcss.com/" class="button button-primary button-rounded button-jumbo">Go</a>
        <a href="http://www.bootcss.com/" class="button button-primary button-rounded button-jumbo">Go</a>
    </div>
<div style="width:45%; height:500px;border:1px solid gray;margin-left: 50%;margin-top: 3.2%" id="container">
</div>
    <div style="margin-right: 5%">
        当前网络状态：<span></span>
    </div>
    <div class="button-group" style="margin-right: 2%">

        <input type="button" class="button" value="我的手机位置" id="pos" onclick="init()">
    </div>
</div>
<script>

    var map = new AMap.Map('container', {
        resizeEnable: true,
        center: [116.39, 39.9],
        zoom: 17
    });
    var marker = new AMap.Marker({
        position: map.getCenter()
    });
    marker.setMap(map);
    // 设置鼠标划过点标记显示的文字提示
    marker.setTitle('我是marker的title');



    var markerContent = document.createElement("div");
    // 点标记中的图标
    var markerImg = document.createElement("img");
    markerImg.className = "markerlnglat";
    markerImg.src = "http://webapi.amap.com/theme/v1.3/markers/n/mark_r.png";
    markerContent.appendChild(markerImg);
    var markerSpan = document.createElement("span");
    markerSpan.className = 'marker';

    map.plugin(['AMap.ToolBar'],function()
    {
        toolbar=new AMap.ToolBar();
        map.addControl(toolbar);
    })
    window.onload = inittree;
    var px;
    var py;
    var pos='';
    function init() {
        $.post("/yuankong/home/index/getxy",
                function (data, status) {
                    // alert("Data: " + data + "\nStatus: " + status);
                    if (status) {
                        data = $.parseJSON(data);
                        px = parseFloat(data.x);
                        py = parseFloat(data.y);
                        pos=data.position;
                        map.setCenter([px,py]);
                        marker.setPosition([px,py]);
                        // 点标记中的文本

                        markerSpan.innerHTML = pos;
                        markerContent.appendChild(markerSpan);
                        marker.setContent(markerContent); //更新点标记内容
                    }
                });
    }


    $("#Del").click(function()
    {
        var nodes = $('#obox').tree('getChecked');
        var s = '';
        for(var i=0; i<nodes.length; i++){
            if (s != '') s += ',';
            $.post("/yuankong/home/index/del",{
                text:nodes[i].text,
            },function(data)
            {
                s+=data.toString();
                alert(s);
            });
            $("#obox").tree('remove',nodes[i].target);
            document.getElementById("Del").disabled=true;
        }
    })
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
            onCheck: function (node,checked) {
                var nodes=$("#obox").tree("getChecked");
                    if(nodes.length>0)
                    {
                        document.getElementById("Del").disabled=false;
                    }
                    else
                    {
                        document.getElementById("Del").disabled=true;
                    }
            }
        });
    }
    function inittree() {
        $.post("/yuankong/home/user/getsession",function(data)
        {
            if(data.toString()!="")
            {
                $.post("/yuankong/home/index/before", function (data) {
                    file();
                });
            }
            else
            {
                window.location.href="<?php echo U('User/index');?>";
            }
        })
    }

    $("#tt").tabs({
        tabPosition: "left",
        headerWidth: $("#tt").width() * 0.17,
        tabHeight: 50
    })

</script>
</body>
</html>