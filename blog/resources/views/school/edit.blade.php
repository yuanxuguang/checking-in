<!DOCTYPE html>
<html class="x-admin-sm">

@include('public.header')
  
  <body>
    <div class="x-body">
        <form class="layui-form" id="data">
            <input type="text" name="id" value="{{$list->id}}" style="display:none;">
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>学校编号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="s_num" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" value="{{$list->s_num}}">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>学校名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="s_name_zn" required="" lay-verify="company_name"
                           autocomplete="off" class="layui-input" value="{{$list->s_name_zn}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>学校名称(英文)
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="s_name_zn" required="" lay-verify="company_name"
                           autocomplete="off" class="layui-input" value="{{$list->s_name_en}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>学校简称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="s_name_en" required="" lay-verify="company_num"
                           autocomplete="off" class="layui-input" value="{{$list->s_name_short}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>地区
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="s_area" required=""
                           autocomplete="off" class="layui-input" value="{{$list->s_area}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>地址
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_pass" name="s_address" required=""
                           autocomplete="off" class="layui-input" value="{{$list->s_address}}">
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
                url:"/schoolEditInsert",
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