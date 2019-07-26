<html class="x-admin-sm">
@include('public.header')
  
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="/schoolList">
          {{--<input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">--}}
          {{--<input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">--}}
          <input type="text" name="condition"  placeholder="学校编号，学校名称" autocomplete="off" class="layui-input">
          {{--<div class="layui-input-inline">--}}
          {{--<select name="employerType" id="">--}}
            {{--<option value="0">雇主类型</option>--}}
            {{--<option value="1">主雇主</option>--}}
            {{--<option value="2">外判雇主</option>--}}
          {{--</select>--}}
          {{--</div>--}}
          <input  type="file" name="c_img" lay-skin="primary" title="主合约" value="0"  >
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加用户','/schoolAdd',600,500)"><i class="layui-icon"></i>添加</button>
        {{--<input type="file" id="import_excel" style="float: right;color:#009688;" multiple="multiple">--}}

        <label for="fileinp" style="float: right;">
          <input type="file" id="excel" name="excel">
          <input type="button" id="btn" value="确定导入" style="height: 30px;background:#009688;border:none;color:#FFFFFF;padding: 10px;line-height: 15px;margin-right: 10px;">

        </label>
      </xblock>
      <table class="layui-table x-admin">
        <thead>
          <tr>
            <th>学校编号</th>
            <th>学校名称</th>
            <th>学校简称</th>
            <th>地区</th>
            <th>地址</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($lists as $list)
          <tr>
            <td>{{$list->s_num}}</td>
            <td>{{$list->s_name_zn}}</td>
            <td>{{$list->s_name_short}}</td>
            <td>{{$list->s_area}}</td>
            <td>{{$list->s_address}}</td>
            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','/schoolEdit/{{$list->id}}',600,500)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" onclick="member_del(this,{{$list->id}})" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="page">
        {{$lists->links()}}
      </div>

    </div>
    <script>
      layui.use('laydate', function(){
        var laydate = layui.laydate;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*用户-停用*/
      function member_stop(obj,id){
              if($(obj).attr('title')=='启用'){
                layer.confirm('确认要启用吗？',function(index) {
                    //发异步把用户状态进行更改
                    $(obj).attr('title', '启用')
                    $.post({
                      url: "/setEmployerStatus",
                      data: {'status': 1, 'id': id},
                      dataType: 'json',
                      success: function (res) {
                        //发异步把用户状态进行更改
                        $(obj).find('i').html('&#xe601;');

                        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已启用');
                        layer.msg('已启用!', {icon: 6, time: 1000});
                        window.location.reload();
                      }
                    });
                });
                // $(obj).find('i').html('&#xe62f;');
                //
                // $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                // layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                layer.confirm('确认要停用吗？',function(index) {
                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $.post({
                  url:"/setEmployerStatus",
                  data:{'status':0,'id':id },
                  dataType:'json',
                  success:function(res){
                    //发异步把用户状态进行更改
                    $(obj).find('i').html('&#xe62f;');
                    window.location.reload();
                    $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                    layer.msg('已停用!', {icon: 5, time: 1000});
                  }
                });

                // $(obj).attr('title','启用')
                // $(obj).find('i').html('&#xe601;');
                //
                // $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                // layer.msg('已启用!',{icon: 5,time:1000});
              }
              )};
              

      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.get({
                url:'/schoolDelete',
                data:{'id':id},
                dataType:'json',
                success:function(){
                  $(obj).parents("tr").remove();
                  layer.msg('已删除!',{icon:1,time:1000});
                }
              });

          });
      }

      var fileM = document.querySelector("#excel");
      // $("#excel").on("change",function(){
      //   //获取文件对象，files是文件选取控件的属性，存储的是文件选取控件选取的文件对象，类型是一个数组
      //   var fileObj = fileM.files[0];
      //   //创建formdata对象，formData用来存储表单的数据，表单数据时以键值对形式存储的。
      //   var formData = new FormData();
      //   formData.append('file', fileObj);
      //   $.ajax({
      //     url: "/excelImport",
      //     type: "post",
      //     dataType: "json",
      //     data: formData,
      //     async: false,
      //     cache: false,
      //     contentType: false,
      //     processData: false,
      //     success: function (json_data) {
      //       alert("恭喜你！上传成功");
      //     },
      //   });
      // });
      $("#btn").click(function(){
        //获取文件对象，files是文件选取控件的属性，存储的是文件选取控件选取的文件对象，类型是一个数组
        var fileObj = fileM.files[0];
        console.log(fileObj);
        //创建formdata对象，formData用来存储表单的数据，表单数据时以键值对形式存储的。
        var formData = new FormData();
        formData.append('file', fileObj);
        // var excel = new FormData(document.getElementById("excel"));
        console.log(excel);
          $.post({
            url:'/excelImport',
            data:formData,
            processData:false,
            contentType:false,
            async: false,
            cache: false,
            dataType:'json',
            success:function(res){
              if(res.info == '-1'){
                layer.msg('请上传xls或xlsx后缀文件', {icon: 2});
              }else{
                layer.msg('导入成功', {icon: 1});
                window.location.reload();
              }

            }
          })
      });

      function delAll (argument) {
        var data = tableCheck.getData();
        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
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