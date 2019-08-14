<!DOCTYPE html>
<html class="x-admin-sm">
<head>

    <META HTTP-EQUIV="Content-Type" CONTENT="text/html" CHARSET="big5">
    <title>后台登录-X-admin2.1</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8 />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/c/css/font.css">
    <link rel="stylesheet" href="/c/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript"src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.min.js"></script>
    <script src="/c/lib/layui/layui.js" charset="utf-8"></script>

    <style>
        #WidgetFloaterPanels{
            display:none !important;
        }
        #WidgetLogoPanel{
            display:none !important;
        }
        .layui-layer-iframe{
            z-index: 19891019; width: 600px; height: 400px; top: 1px !important; left: 510px;
        }
        .layui-input{
            background:none;
            outline:none;
            border:0px;
        }
        input:focus{
            border:none;
        }

        /*.layui-form-item{*/
            /*float:right;*/
        /*}*/
    </style>
    <script type="text/javascript" src="/c/js/xadmin.js"></script>
    <script type="text/javascript" src="/c/js/cookie.js"></script>
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    </script>
</head>

<body>
<div class="x-body">
    <form class="layui-form" id="data">
        <input type="text" name="id" value="{{$staff->id}}" style="display: none;">
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>姓名:
            </label>
            <div class="layui-input-inline">

                <p style="line-height:35px;">{{$staff->name1}}</p>
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red"></span>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>性别:
            </label>
            <div class="layui-input-inline">
                @if($staff->sex==1)<p style="line-height:35px;">男</p>
                @else
                    <p style="line-height:35px;">女</p>
                @endif
                {{--<input type="radio" name="sex" lay-skin="primary" title="男" value="1" @if($staff->sex==1) checked="checked" @endif id="zhu">--}}
                {{--<input type="radio" name="sex" lay-skin="primary" title="女" value="2" @if($staff->sex==2) checked="checked" @endif id="fu" >--}}
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red"></span>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>员工手机:
            </label>
            <div class="layui-input-inline">
                <p style="line-height:35px;">{{$staff->phone_num}}</p>
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red"></span>
            </div>
        </div>
        <div class="layui-form-item employer_type">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>国家编号:
            </label>
            <div class="layui-input-inline">
                @if($staff->country_type == '1')
                <p style="line-height:35px;">中国(86)</p>
                @else
                    <p style="line-height:35px;">香港(852)</p>
                @endif
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>邮箱:
            </label>
            <div class="layui-input-inline">
                <p style="line-height:35px;">{{$staff->email}}</p>
            </div>
        </div>

        <div class="layui-form-item ">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>选择合约:
            </label>
            <div class="layui-input-inline">
                <p style="line-height:35px;">{{$outEmployer->name}}</p>
            </div>
        </div>

        <div class="layui-form-item ">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>职位:
            </label>
            <div class="layui-input-inline">
                <p style="line-height:35px;">{{$staff->job->j_name}}</p>
            </div>
        </div>
        <div class="layui-form-item" >
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>工人注册证:
            </label>
            <div class="layui-input-inline">
                <img src="{{$staff->work_card_front}}" alt="">
                <img src="{{$staff->work_reverse}}" alt="">
                <p>注册证发出日期:{{$staff->work_card_start_time}}</p>
                <p>注册证发出日期:{{$staff->work_card_end_time}}</p>
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red"></span>
            </div>
        </div>
        <div class="layui-form-item ">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>注册工种:
            </label>
            <div class="layui-input-inline">
                <p style="line-height:35px;">{{$staff->job->j_name}}</p>
            </div>
        </div>
        <div class="layui-form-item ">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>技术水平:
            </label>
            <div class="layui-input-inline">
                @if($staff->technical_merit == 1)
                <p style="line-height:35px;">熟练</p>
                @else
                    <p style="line-height:35px;">一般</p>
                @endif
            </div>
        </div>
        <div class="layui-form-item" >
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>安全证:
            </label>
            <div class="layui-input-inline">
                <img src="{{$staff->safety_card_front}}" alt="">
                <img src="{{$staff->safety_reverse}}" alt="">
                <p>安全证发出日期:{{$staff->safety_card_start_time}}</p>
                <p>安全证发出日期:{{$staff->safety_card_end_time}}</p>
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red"></span>
            </div>
        </div>

    </form>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //自定义验证规则
        form.verify({
            name: function(value){
                if(value.length < 1){
                    return '名字不能为空';
                }
            },
            idcard: function(value){
                if(value.length < 1){
                    return '身份证不能为空';
                }
            },
            company_name: function(value){
                if(value.length < 1){
                    return '公司名字不能为空';
                }
            },
            company_num: function(value){
                if(value.length < 1){
                    return '公司编号不能为空';
                }
            },
            nikename: function(value){
                if(value.length < 3){
                    return '昵称至少得5个字符啊';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,repass: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
        });

        //监听提交
        form.on('submit(add)', function(data){
            $.post({
                url:"/staffEditInsert",
                data:$("#data").serialize(),
                dataType:'json',
                success:function(res){
                    if(res.info == true){
                        layer.alert("修改成功", {icon: 6},function () {
                            // 可以对父窗口进行刷新
                            x_admin_father_reload();
                            //关闭当前frame
                            x_admin_close();
                        });
                    }else{
                        alert(res.error['phone']);
                        // switch (res.error()) {
                        //     case 'phone':
                        //         alert(res.error['phone']);
                        //         break;
                        // }
                        layer.alert("修改失败", {icon: 5},function () {
                            // // 获得frame索引
                            // var index = parent.layer.getFrameIndex(window.name);
                            // //关闭当前frame
                            // parent.layer.close(index);

                            //关闭当前frame
                            x_admin_close();
                        });
                    }

                }

            });
            return false;
        });
    });
</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
@include('public.footer')
</body>

</html>