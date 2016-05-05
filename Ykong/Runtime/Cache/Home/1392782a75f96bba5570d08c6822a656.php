<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.1.min.js">
    </script>
    <script>
       $(document).ready(function(){
            $("#btn").click(function(){
//                $.post("/try/ajax/demo_test_post.php",
//                        {
//                            name:"Donald Duck",
//                            city:"Duckburg"
//                        },
//                        function(data,status){
//                            alert("Data: " + data + "\nStatus: " + status);
//                        });
            });
       });
    </script>
</head>
<body>

<button type="button" id="btn">发送一个 HTTP POST 请求道页面并获取返回内容</button>

</body>
</html>