<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<title>HTML5 HTML5 调用百度地图API地理定位实例</title>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=E4805d16520de693a3fe707cdc962045"></script>
</head>
<body style="margin:50px 10px;">
<div id="status" style="text-align: center"></div>
<div style="width:600px;height:480px;border:1px solid gray;margin:30px auto" id="container"></div>
</body>
</html>

<script type="text/javascript">

    window.onload = function() {
        if(navigator.geolocation) {
            document.getElementById("status").innerHTML = "HTML5 Geolocation is supported in your browser.";
            // 百度地图API功能
            var map = new BMap.Map("container");
            var point = new BMap.Point(116.331398,39.897445);
            map.centerAndZoom(point,12);

            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function(r){
                if(this.getStatus() == BMAP_STATUS_SUCCESS){
                    var mk = new BMap.Marker(r.point);
                    map.addOverlay(mk);
                    map.panTo(r.point);
                    alert('您的位置：'+r.point.lng+','+r.point.lat);
                }
                else {
                    alert('failed'+this.getStatus());
                }
            },{enableHighAccuracy: true})
        }
    };

</script>