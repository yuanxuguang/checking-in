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
        .layui-form select{
            display: block;
        }
        .layui-select-title{
            display:none;
        }
        #WidgetFloaterPanels{
            display:none !important;
        }
        #WidgetLogoPanel{
            display:none !important;
        }
        .layui-layer-iframe{
            z-index: 19891019; width: 600px; height: 400px; top: 1px !important; left: 510px;
        }

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
        <form class="layui-form" id="data" >
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>合约类型
                </label>
                <div class="layui-input-inline">
                        <input type="radio" name="l_type" lay-skin="primary" title="二维码" value="1" checked="" id="code">
                        <input type="radio" name="l_type" lay-skin="primary" title="索引" value="2" id="label" >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            @if($is_upLabel)
            <div class="layui-form-item hidden">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red"></span>
                </label>
                <div class="layui-input-inline">

                    <input type="checkbox" lay-skin="primary" title="选择上级索引" value="1"  id="check_label">

                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            @endif
            <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>标签名称
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="username" name="l_name" required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item employer_type hidden changeLabel" >
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>选择学校
                </label>
                <div class="layui-input-inline">
                    <select id="out_employer" name="s_id" class="valid">
                        <option value="0">请选择</option>
                        @foreach($schools as $s)
                        <option value="{{$s->id}}">{{$s->s_name_zn}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item employer_type hidden changeLabel" >
                    <label for="username" class="layui-form-label">
                        <span class="x-red">*</span>合约
                    </label>
                    <div class="layui-input-inline">
                        <select id="out_employer" name="c_id" class="valid">
                            <option value="0">请选择</option>
                            @foreach($contracts as $c)
                                <option value="{{$c->id}}">{{$c->c_name}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            @if($up1_labels)
            <div class="layui-form-item employer_type label_level level1" >
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>1级
                </label>
                <div class="layui-input-inline">
                    <select id="up1_label" name="up_label1" class="valid">
                        <option value="0">选择索引</option>
                        @foreach($up1_labels as $up1)
                        <option value="{{$up1->id}}">{{$up1->l_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
                <div class="layui-form-item employer_type label_level level2" >
                    <label for="username" class="layui-form-label">
                        <span class="x-red">*</span>2级
                    </label>
                    <div class="layui-input-inline">
                        <select id="up2_label" name="up_label2" class="valid">
                            <option value="0">选择索引</option>

                        </select>
                    </div>
                </div>

                <div class="layui-form-item employer_type label_level level3" >
                    <label for="username" class="layui-form-label">
                        <span class="x-red">*</span>3级
                    </label>
                    <div class="layui-input-inline">
                        <select id="up3_label" name="up_label3" class="valid">
                            <option value="0">选择索引</option>

                        </select>
                    </div>
                </div>
            <div class="layui-form-item employer_type label_level level4" >
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>4级
                </label>
                <div class="layui-input-inline">
                    <select id="up4_label" name="up_label4" class="valid">
                        <option value="0">选择索引</option>

                    </select>
                </div>
            </div>

            {{--<div class="layui-form-item employer_type  label_level level2" >--}}
                {{--<label for="username" class="layui-form-label">--}}
                    {{--<span class="x-red">*</span>2级--}}
                {{--</label>--}}
                {{--<div class="layui-input-inline">--}}
                    {{--<select id="out_employer" name="c_c_id" class="valid">--}}
                        {{--<option value="0">选择索引</option>--}}
                        {{--<option value="0">1</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="layui-form-item code_type ">
                <label for="username" class="layui-form-label ">
                    <span class="x-red">*</span>选取位置
                </label>
                <div class="layui-input-inline " >
                    {{--<iframe src="https://m.amap.com/picker/?key=608d75903d29ad471362f8c58c550daf" style="width:100%;height: 100%" frameborder="0"></iframe>--}}
                    {{--<input type="button" name="c_type" lay-skin="primary"  value="0"  >--}}
                    <a href="https://apis.map.qq.com/tools/locpicker?search=1&type=0&backurl=http://1.yxg404.top/contractAddS&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&referer=myapp" class="layui-btn">选取位置</a>
                </div>
            </div>

          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  增加
              </button>
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
            nikename: function(value){
              if(value.length < 5){
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

            $(".hidden").hide();
            $(".label_level").hide();
            // window.onload = function(){

            $('#code').next().on('click', function(){
                $(".hidden").hide();

            });
            $('#label').next().on('click', function(){
                $(".code_type").hide();
                $(".hidden").show();

            });

            $("#check_label").next().on('click',function(){ //一级标签 是否显示二级标签
                var nn = $("#check_label").is(":checked");
                if(nn == true){
                    $('.level1').show();
                    $(".changeLabel").hide();
                    $(".level2",".level3").hide();
                }else{
                    $('.label_level').hide();
                    $(".changeLabel").show();
                }
            });

          //监听提交
          form.on('submit(add)', function(data){
              var form = new FormData(document.getElementById("data"));
              // var tes = $("input[type='radio']:checked").val();
              // alert(tes);
              $.post({
                  url:"/labelInsert",
                  data:form,
                  processData:false,
                  contentType:false,
                  dataType:'json',
                  success:function(res){
                      if(res.info == true){
                          layer.alert("增加成功", {icon: 6},function () {
                              x_admin_father_reload();// 可以对父窗口进行刷新
                              //关闭当前frame
                              x_admin_close();
                          });
                      }else{
                          layer.alert("添加失败", {icon: 5},function (){
                              //关闭当前frame
                              x_admin_close();
                          });
                      }
                  }
              });
              return false;
          });

        });
        window.onload = function(){
            $("#up1_label").change(function(){  //一级下是否有二级
                var lid = $(this).children('option:selected').val();
                $('#up2_label option[value != 0]').empty();
                $.get({
                    url:'/getLevel2Label',
                    data:{'lid':lid},
                    dataType: 'json',
                    success:function(res){
                        // var in = $.isEmptyObject(res);
                        // alert(in);
                        if($.isEmptyObject(res)){
                            $('.level2').hide();
                            $('.level3').hide();
                            $('.level4').hide();
                        }else{
                            $('.level2').show();
                            var list = new Array();
                            for(var i in res){
                                list[i] = "<option value="+res[i].id+">"+res[i].l_name+"</option>";
                                $('#up2_label').append(list[i]);
                            }
                        }
                    }
                })
            });

            $("#up2_label").change(function(){  //二级是否有三级
                var lid = $(this).children('option:selected').val();
                $('#up3_label option[value != 0]').empty(); // up3_label下不等于0 的清空,避免数据重复
                $.get({
                    url:'/getLevel2Label',
                    data:{'lid':lid},
                    dataType: 'json',
                    success:function(res){
                        // var in = $.isEmptyObject(res);
                        // alert(in);
                        if($.isEmptyObject(res)){
                            $('.level3').hide();
                            $('.level4').hide();
                        }else{
                            $('.level3').show();

                            var list = new Array();
                            for(var i in res){
                                list[i] = "<option value="+res[i].id+">"+res[i].l_name+"</option>";
                                $('#up3_label').append(list[i]);
                            }
                        }
                    }
                })
            });

            $("#up3_label").change(function(){  //三级是否有四级
                var lid = $(this).children('option:selected').val();
                $('#up4_label option[value != 0]').empty(); // up3_label下不等于0 的清空,避免数据重复
                $.get({
                    url:'/getLevel2Label',
                    data:{'lid':lid},
                    dataType: 'json',
                    success:function(res){
                        // var in = $.isEmptyObject(res);
                        // alert(in);
                        if($.isEmptyObject(res)){
                            $('.level4').hide();
                        }else{
                            $('.level4').show();
                            var list = new Array();
                            for(var i in res){
                                list[i] = "<option value="+res[i].id+">"+res[i].l_name+"</option>";
                                $('#up4_label').append(list[i]);
                            }
                        }
                    }
                })
            });
        };
        (function(){
            var iframe = document.getElementById('test').contentWindow;
            document.getElementById('test').onload = function(){
                iframe.postMessage('hello','https://m.amap.com/picker/');
            };
            window.addEventListener("message", function(e){
                console.log(e.data);
                alert('您选择了:' + e.data.name + ',' + e.data.location)
            }, false);
        }())
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();
    </script>

  @include('public.footer')
  </body>

</html>