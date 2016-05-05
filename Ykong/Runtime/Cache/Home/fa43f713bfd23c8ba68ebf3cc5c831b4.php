<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>点标记</title>
    <script type="text/javascript" src="./js/jquery-2.2.0.js"></script>
    <script type="text/javascript" src="./js/jquery-2.2.2.min.js"></script>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
    <script src="http://webapi.amap.com/maps?v=1.3&key=0b50a7f73f2820d8f45c1c1a18cfb644&&callback=init"></script>

</head>
<body>
<div>只是一个地图</div>
<div style="width:30%; height:50%;border:1px solid gray;margin-left: 65%;margin-top: 5%" id="container">
</div>
<script>
    var px;
    var py;
    $(document).ready(function(){
       // alert("ok");
        $.post("/yuankong/home/index/getxy",
                function(data,status){
                   // alert("Data: " + data + "\nStatus: " + status);
                    if(status)
                    {
                        data=$.parseJSON(data);
                        px=parseFloat(data.x);
                        py=parseFloat(data.y);
                    }
                });
    });

    function init() {
        var marker, map = new AMap.Map("container", {
            resizeEnable: true,
            center: [px, py],
            zoom: 8
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


</script>
</body>
</html>