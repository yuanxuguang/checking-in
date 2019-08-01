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
          {{--<input type="text" name="condition"  placeholder="学校编号，学校名称" autocomplete="off" class="layui-input">--}}
          {{--<div class="layui-input-inline">--}}
          {{--<select name="employerType" id="">--}}
            {{--<option value="0">雇主类型</option>--}}
            {{--<option value="1">主雇主</option>--}}
            {{--<option value="2">外判雇主</option>--}}
          {{--</select>--}}
          {{--</div>--}}
          {{--<button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>--}}
        </form>
      </div>
      <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加用户','/jobAdd',600,500)"><i class="layui-icon"></i>添加</button>
      </xblock>
      <table class="layui-table x-admin">
        <thead>
          <tr>
            <th>职位名称</th>
            <th>职位名称(英文)</th>
            <th>职位简称</th>
            <th>类型</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($lists as $list)
          <tr>
            <td>{{$list->j_name}}</td>
            <td>{{$list->j_name_en}}</td>
            <td>{{$list->j_name_short}}</td>
            <td>@if($list->j_type == 1) 管理层 @else 工人@endif</td>

            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','/jobEdit/{{$list->id}}',600,500)" href="javascript:;">
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



      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.get({
                url:'/jobDelete',
                data:{'id':id},
                dataType:'json',
                success:function(){
                  $(obj).parents("tr").remove();
                  layer.msg('已删除!',{icon:1,time:1000});
                }
              });

          });
      }



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