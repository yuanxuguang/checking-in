<!DOCTYPE html>
<html class="x-admin-sm">
@include('public.header')
  
  <body>
    <div class="x-body">
        <form class="layui-form" id="data">
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>员工名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>性别
                </label>
                <div class="layui-input-inline">
                    <input type="radio" name="sex" lay-skin="primary" title="男" value="1" checked="" id="zhu">
                    <input type="radio" name="sex" lay-skin="primary" title="女" value="2" id="fu" >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>员工手机
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="phone_num" required="" lay-verify="phone"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            <div class="layui-form-item employer_type">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>国家编号
                </label>
                <div class="layui-input-inline">
                    <select id="country_type" name="country_type" class="valid">
                        <option value="1">中国(86)</option>
                        <option value="2">香港(852)</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>身份证
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_email" name="ID_card" required="" lay-verify="idcard"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red"></span>
              </div>
            </div>
            <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>邮箱
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_username" name="email" required="" lay-verify="email"
                  autocomplete="off" class="layui-input">
              </div>
            </div>

            <div class="layui-form-item ">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>选择合约
                </label>
                <div class="layui-input-inline">
                    <select id="leaders" name="c_id" class="valid">
                        @foreach($contracts as $c)
                        <option value="{{$c->id}}">{{$c->c_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item ">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>角色
                </label>
                <div class="layui-input-inline">
                    <select id="leaders" name="role" class="valid">
                        <option value="1">前线员工</option>
                        <option value="2">中层人员</option>
                        <option value="3">高层人员</option>
                        <option value="4">检视人员</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item ">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>职位
                </label>
                <div class="layui-input-inline">
                    <select id="j_id" name="j_id" class="valid">
                        @foreach($jobs as $job)
                        <option value="{{$job->id}}">{{$job->j_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>打卡方式
                </label>
                <div class="layui-input-inline">
                    <input type="radio" name="clock_type" lay-skin="primary" title="摄像打卡" value="1" checked="" id="zhu">
                    <input type="radio" name="clock_type" lay-skin="primary" title="人脸识别" value="2" id="fu" >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
          <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_pass" name="password" required="" lay-verify="pass"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    6到16个字符
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    6到16个字符
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
                  url:"/staffInsert",
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