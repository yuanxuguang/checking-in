<!DOCTYPE html>
<html class="x-admin-sm">
@include('public.header')
  
  <body>
    <div class="x-body">
        <form class="layui-form" id="data" >
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>合约类型
                </label>
                <div class="layui-input-inline">
                    <input type="radio" name="c_type" lay-skin="primary" title="主合约" value="1" checked="" id="zhu">
                    <input type="radio" name="c_type" lay-skin="primary" title="子合约" value="2" id="zi" >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red"></span>
                </div>
            </div>
            <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>合约名称
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="username" name="c_name" required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
            </div>
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>详细地址
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="username" name="c_address" required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item employer_type hidden" >
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>选择外判雇主
                </label>
                <div class="layui-input-inline">
                    <select id="out_employer" name="out_employer" class="valid">
                        <option value="0">请选择</option>
                    </select>
                </div>
          </div>
            <div class="layui-form-item employer_type hidden" >
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>上一合约
                </label>
                <div class="layui-input-inline">
                    <select id="leaders" name="up_contract" class="valid">
                        <option value="0">请选择</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item employer_type">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>合约类型
                </label>
                <div class="layui-input-inline">
                    <select id="leaders" name="c_c_type" class="valid">
                        <option value="0">请选择</option>
                        <option value="1">Project</option>
                        <option value="2">Major Repair</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item employer_type">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>合约图片
                </label>
                <div class="layui-input-inline">
                    <input type="file" name="c_img" lay-skin="primary" title="主合约" value="0"  >

                </div>
            </div>
            <div class="layui-form-item employer_type" style="width:100%;height: 100%">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>选取位置
                </label>
                <div class="layui-input-inline " >
                    {{--<iframe src="https://m.amap.com/picker/?key=608d75903d29ad471362f8c58c550daf" style="width:100%;height: 100%" frameborder="0"></iframe>--}}
                    {{--<input type="button" name="c_type" lay-skin="primary"  value="0"  >--}}
                    <a href="/map" class="layui-btn">选取位置</a>

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
            // window.onload = function(){

            $('#zhu').next().on('click', function () {
                $(".hidden").hide();
            });
            $('#zi').next().on('click', function () {

                $(".hidden").show();
            });
          //监听提交
          form.on('submit(add)', function(data){
              var form = new FormData(document.getElementById("data"));
              $.post({
                  url:"/contractInsert",
                  data:form,
                  processData:false,
                  contentType:false,
                  dataType:'json',
                  success:function(res){
                      if(res.info === 1){
                          layer.alert("增加成功", {icon: 6},function () {
                              x_admin_father_reload();// 可以对父窗口进行刷新
                              //关闭当前frame
                              x_admin_close();
                          });
                      }else{
                          layer.alert("添加失败", {icon: 5},function () {
                              //关闭当前frame
                              x_admin_close();
                          });
                      }
                  }
              });
              return false;
          });
          
          
        });

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
      })();</script>

  @include('public.footer')
  </body>

</html>