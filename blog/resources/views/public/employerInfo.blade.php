<!DOCTYPE html>
<html class="x-admin-sm">

@include('public.header')
  
  <body>
    <div class="x-body">
        <form class="layui-form" id="data">
            <input type="text" name="id" value="{{$list->id}}" style="display:none;">
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>雇主类型
                </label>
                <div class="layui-input-inline">
                    @if($list->type == '1')
                     <input type="text" id="L_email" name="name" required="" lay-verify="name"
                               autocomplete="off" class="layui-input" value="主顾主" style="border: 0px;outline:none;">
                    @else
                        <input type="text" id="L_email" name="name" required="" lay-verify="name"
                               autocomplete="off" class="layui-input" value="子顾主" style="border: 0px;outline:none;">
                    @endif
                    {{--<input type="radio" name="type" lay-skin="primary" title="主雇主" value="0" id="zhu" style="">--}}
                    {{--<input type="radio" name="type" lay-skin="primary" title="外判雇主" value="1" id="fu"  @if($list->type == '2') checked="checked" @endif>--}}
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            @if($list->type == 2)
            <div class="layui-form-item employer_type">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>主雇主:
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" value="{{$list->boss_name}}" style="border: 0px;outline:none;">
                </div>
            </div>
            @endif
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>雇主姓名:
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" value="{{$list->name}}" style="border: 0px;outline:none;">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>公司名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="company_name" required="" lay-verify="company_name"
                           autocomplete="off" class="layui-input" value="{{$list->company_name}}" style="border: 0px;outline:none;">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>公司编号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="company_num" required="" lay-verify="company_num"
                           autocomplete="off" class="layui-input" value="{{$list->company_num}}" style="border: 0px;outline:none;">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>手机号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="phone" required="" lay-verify="phone"
                           autocomplete="off" class="layui-input" value="{{$list->phone}}" style="border: 0px;outline:none;">
                </div>
            </div>



        </form>
    </div>
    <script>
        if ($('#zhu').attr('checked')) {
            $(".employer_type").hide();
        }

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

          $('#zhu').next().on('click', function () {
              $(".employer_type").hide();
          });
          $('#fu').next().on('click', function () {

              $(".employer_type").show();
          });

        //监听提交
        form.on('submit(add)', function(data){
            $.post({
                url:"/editInsert",
                data:$("#data").serialize(),
                dataType:'json',
                success:function(res){
                    if(res.info === 1){
                        layer.alert("修改成功", {icon: 6},function () {
                            // // 获得frame索引
                            // var index = parent.layer.getFrameIndex(window.name);
                            // //关闭当前frame
                            // parent.layer.close(index);
                            //关闭当前frame
                            x_admin_father_reload();
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