<!DOCTYPE html>
<html class="x-admin-sm">

@include('public.header')
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        {{--<a href="">首页</a>--}}
        {{--<a href="">演示</a>--}}
        <a>
          <cite>进度管理</cite>
        </a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="/adminRecordList">
          {{--<img src="{{asset('storage/c_img/20190722_134132.png')}}" alt="">--}}
          {{--<input class="layui-input" placeholder="开始日" name="start" id="start">--}}
          {{--<input class="layui-input" placeholder="截止日" name="end" id="end">--}}
          <input type="text" name="phone_num"  placeholder="手机号" autocomplete="off" class="layui-input">
          <div class="layui-input-inline">
          <select name="c_type">
            <option value="0">选择主合约</option>
          </select>

          </div>
          <div class="layui-input-inline">
            <select name="type">
              <option value="0">选择记录类型</option>
              <option value="1">文字</option>
              <option value="2">通讯</option>
              <option value="3">图片</option>
              <option value="4">摄像</option>
            </select>
          </div>
          <div class="layui-input-inline">
            <select name="label">
              <option value="0">全部索引</option>
            </select>
          </div>
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
        <button class="layui-btn" onclick="x_admin_show('添加用户','/contractAdd','600','800')"><i class="layui-icon"></i>添加</button>
        {{--<span class="x-right" style="line-height:40px">共有数据：88 条</span>--}}
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            {{--<th>--}}
              {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            <th>姓名</th>
            <th>手机号</th>
            <th>合约</th>
            <th>索引</th>
            <th>类型</th>
            <th>时间</th>
            <th>位置</th>
            <th >操作</th>
            </tr>
        </thead>
        <tbody>
          @foreach($lists as $l)
          <tr>
            <td>{{$l->staff->name1}}{{$l->staff->name2}}</td>
            <td>{{$l->staff->phone_num}}</td>
            <td>{{$l->contract->c_name}}</td>
            <td>@if($l->l1 != null) {{$l->l1}}
                     @if($l->l2 != null) =>{{$l->l2}}
                          @if($l->l3 != null) =>{{$l->l3}}
                            @if($l->l4 != null) =>{{$l->l4}}
                              @if($l->l5 != null) =>{{$l->l5}}
                              @endif
                            @endif
                          @endif
                     @endif
                 @endif</td>
            <td>@if($l->type == '1')文字@elseif($l->type == '2')通讯 @elseif($l->type == '3')图片@else 摄像 @endif</td>
            <td>{{$l->r_time}}</td>
            <td>{{$l->coordinate}}</td>
            <td class="td-manage">
              <a class="layui-btn layui-btn-normal layui-btn-mini" onclick="x_admin_show('查看备注','/recordText?rid={{$l->id}}','600','400')" href="javascript:;">备注</a>
              <a class="layui-btn layui-btn-normal layui-btn-mini" onclick="x_admin_show('查看','/record?type={{$l->type}}&rid={{$l->id}}','800','400')"  href="javascript:;">查看</a>
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
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');
                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');
                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.get({
                url:'/contractDelete',
                data:{'id':id},
                dataType:'json',
                success:function(){
                  $(obj).parents("tr").remove();
                  layer.msg('已删除!',{icon:1,time:1000});
                }

              })

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