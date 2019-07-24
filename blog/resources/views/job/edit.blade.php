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
                    <input type="radio" name="j_type" lay-skin="primary" title="管理层" value="1" @if($list->j_type == 1) checked="checked" @endif id="zhu">
                    <input type="radio" name="j_type" lay-skin="primary" title="工人" value="2" @if($list->j_type == 2) checked="checked" @endif id="fu" >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>职位名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="j_name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" value="{{$list->j_name}}">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>职位名称(英文)
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="j_name_en" required="" lay-verify="job_name"
                           autocomplete="off" class="layui-input" value="{{$list->j_name_en}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>职位简称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="j_name_short" required=""
                           autocomplete="off" class="layui-input" value="{{$list->j_name_short}}">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                    修改
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


        //监听提交
        form.on('submit(add)', function(data){
            $.post({
                url:"/jobEditInsert",
                data:$("#data").serialize(),
                dataType:'json',
                success:function(res){
                    if(res.info == true){
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