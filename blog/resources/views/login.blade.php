<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.1</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="c/css/font.css">
	<link rel="stylesheet" href="c/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="c/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="c/js/xadmin.js"></script>
    <script type="text/javascript" src="c/js/cookie.js"></script>

</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">x-admin2.0-管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" action="/doLogin" method="post">
            {{csrf_field()}}

            <input name="company_num" placeholder="公司编号"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
            @if(session('error'))
                <div class="info" style="font-size: 18px;color:red;">
                    {{session('error')}}
                </div>
            @endif
    </div>

    <script>
        // $(function  () {
        //     layui.use('form', function(){
        //       var form = layui.form;
        //       // layer.msg('玩命卖萌中', function(){
        //       //   //关闭后的操作
        //       //   });
        //       //监听提交
        //       form.on('submit(login)', function(data){
        //         // alert(888)
        //         layer.msg(JSON.stringify(data.field),function(){
        //             location.href='index.html'
        //         });
        //         return false;
        //       });
        //     });
        // })

        
    </script>

    
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
</body>
</html>