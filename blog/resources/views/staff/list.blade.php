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

  </style>
  <script type="text/javascript" src="/c/js/xadmin.js"></script>
  <script type="text/javascript" src="/c/js/cookie.js"></script>
  <script>
    // 是否开启刷新记忆tab功能
    // var is_remember = false;
  </script>
</head>
  
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
        <form class="layui-form layui-col-md12 x-so" action="/staffList">

          {{--<input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">--}}
          {{--<input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">--}}
          <input type="text" name="condition"  placeholder="用户名，手机" autocomplete="off" class="layui-input">
          <div class="layui-input-inline">
          <select name="s_type" id="">
            <option value="1">前线人员</option>
            <option value="2">检视人员</option>
          </select>
          </div>
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
        {{--<button class="layui-btn" onclick="x_admin_show('添加用户','/staffAdd',600,500)"><i class="layui-icon"></i>添加</button>--}}
        {{--<span class="x-right" style="line-height:40px">共有数据：88 条</span>--}}
      </xblock>
      <table class="layui-table x-admin">
        <thead>
          <tr>
            {{--<th>--}}
              {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            <th>员工姓名</th>
            <th>手机号</th>
            <th>角色</th>
            <th>外判雇主</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
          @foreach($lists as $list)
          <tr>
            {{--<td>--}}
              {{--<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</td>--}}

            <td>{{$list->name1}}{{$list->name2}}</td>
            <td>{{$list->phone_num}}</td>
            <td>@if($list->role ==1)前线人员@elseif($list->role ==2)中层人员@elseif($list->role ==3)高层人员@else检视人员@endif  </td>
            <td>
              <div class="layui-input-inline">
                <select class="change_out staff{{$list->id}}" onchange="change({{$list->id}})" name="outEmployer" >
                  <option value="0">选择外判雇</option>
                  @foreach($outEmployer as $o)
                  <option value="{{$o->id}}" @if($list->out_eid == $o->id) selected="" @endif>{{$o->name}}</option>
                  @endforeach
                </select>
              </div>
            </td>
            <td class="td-status">
              @if($list->status)
                <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
              @else
                <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled" >停用</span>
              @endif
            </td>
            <td class="td-manage">
              @if($list->status)
              <a onclick="member_stop(this,{{$list->id}})" href="javascript:;"  title="停用">
                <i class="layui-icon layui-btn" style="background-color: brown">停用</i>
              </a>
              @else
                <a onclick="member_stop(this,{{$list->id}})" href="javascript:;"  title="启用">
                  <i class="layui-icon layui-btn">启用</i>
                </a>
              @endif
              <a title="" class="layui-btn" href="/staffDetail/{{$list->id}}">
                查看
              </a>
              {{--<a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">--}}
                {{--<i class="layui-icon">&#xe640;</i>--}}
              {{--</a>--}}
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

        // $(".change_out").change(function(){
        //
        // });
        //员工绑定外判雇主
        function change(id){
          var eid = $(".staff"+id).val();
          $.get({
            url:'/staffOutEmployer/'+id+'/'+eid,
            success:function(data){

            }
          });

        }



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
                    $.get({
                      url: "/setStaffStatus",
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
                $.get({
                  url:"/setStaffStatus",
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
              $(obj).parents("tr").remove();
              layer.msg('已删除!',{icon:1,time:1000});
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