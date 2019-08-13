<html>
@include('public.header')

<body>
<div class="x-nav">
      <span class="layui-breadcrumb">
      <a href="/clockList">上班打卡</a>
      <a>
        <cite >安全装备</cite></a>
      </span>

</div>
    <div style="margin-top:20px;">
    @foreach($lists as $l)
    <video src="{{$l->quip_video}}"  width="510" height="310" controls="controls">
        Your browser does not support the video tag.
    </video>
    @endforeach
    </div>
</body>
</html>