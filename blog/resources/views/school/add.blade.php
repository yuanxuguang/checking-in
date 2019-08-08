<!DOCTYPE html>
<html class="x-admin-sm">
@include('public.header')
  
  <body>
    <div class="x-body">
        <form class="layui-form" id="data">
            <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>学校编号
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_email" name="s_num" required="" lay-verify="name"
                  autocomplete="off" class="layui-input">
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
                  autocomplete="off" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>学校名称(英文)
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="s_name_en" required="" lay-verify="company_name"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>学校简称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="s_name_short" required="" lay-verify="company_name"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>地区
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="s_area" required="" lay-verify="company_num"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>详细地址
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="s_address" required="" lay-verify="company_name"
                           autocomplete="off" class="layui-input">
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
              name: function(value){
                  if(value.length < 1){
                      return '名字不能为空';
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


            $(".employer_type").hide();
          // window.onload = function(){

                $('#zhu').next().on('click', function () {
                    $(".employer_type").hide();
                });
                $('#fu').next().on('click', function () {

                $(".employer_type").show();
                });
            // };

          //监听提交
          form.on('submit(add)', function(data){
              $.post({
                  url:"/schoolInsert",
                  data:$("#data").serialize(),
                  dataType:'json',
                  success:function(res){
                      if(res.info == true){
                          layer.alert("增加成功", {icon: 6},function () {
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
                          layer.alert("添加失败", {icon: 5},function () {
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