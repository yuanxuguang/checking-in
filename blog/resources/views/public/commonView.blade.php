<!doctype html>
<html  class="x-admin-sm">
@include('public.header')
<body>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="./index.html">考勤项目 2.0</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        {{--<ul class="layui-nav left fast-add" lay-filter="">--}}
          {{--<li class="layui-nav-item">--}}
            {{--<a href="javascript:;">+新增</a>--}}
            {{--<dl class="layui-nav-child"> <!-- 二级菜单 -->--}}
              {{--<dd><a onclick="x_admin_show('资讯','https://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>--}}
              {{--<dd><a onclick="x_admin_show('图片','https://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>--}}
               {{--<dd><a onclick="x_admin_show('用户 最大化','https://www.baidu.com','','',true)"><i class="iconfont">&#xe6b8;</i>用户最大化</a></dd>--}}
               {{--<dd><a onclick="x_admin_add_to_tab('在tab打开','https://www.baidu.com',true)"><i class="iconfont">&#xe6b8;</i>在tab打开</a></dd>--}}
            {{--</dl>--}}
          {{--</li>--}}
        {{--</ul>--}}
        <ul class="layui-nav right" lay-filter="">
            <li class="layui-nav-item">
                <select name="" id="change" onchange="changeLanguage()">
                    <option value="">切换语言</option>
                    <option value="zhongwen">中文</option>
                    <option value="English">英文</option>
                    <option value="fanti">繁体</option>
                </select>
            </li>
            <li class="layui-nav-item">
            <a href="javascript:;">{{$employer->name}}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('个人信息','/employerInfo',600,400)">个人信息</a></dd>
              <dd><a href="/loginOut">退出</a></dd>
            </dl>
            </li>
            <li class="layui-nav-item to-index"><a href="/">前台首页</a></li>
        </ul>
        
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
            @if(session('e_type') == '777' || session('e_type')=='1')
            <li>
                <a _href="/employerList">
                    <i class="iconfont">&#xe6a7;</i>
                    <cite>雇主管理</cite>
                </a>
            </li>
            @endif
            <li>
                <a _href="/contractList">
                    <i class="iconfont">&#xe6a7;</i>
                    <cite>合约管理</cite>

                </a>

            </li>
            <li>
                <a _href="/labelList">
                    <i class="iconfont">&#xe6a7;</i>
                    <cite>标签管理</cite>
                </a>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>考勤</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/clockList">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>上班打卡</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/stationClockList">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>工位打卡</cite>
                        </a>
                    </li >
                </ul>
            </li>

            <li>
                <a _href="/schoolList">
                    <i class="iconfont">&#xe6a7;</i>
                    <cite>学校管理</cite>
                </a>
            </li>
            <li>
                <a _href="/jobList">
                    <i class="iconfont">&#xe6a7;</i>
                    <cite>职位管理</cite>
                </a>
            </li>
            <li>
                <a _href="/staffList">
                    <i class="iconfont">&#xe6a7;</i>
                    <cite>员工管理</cite>
                </a>
            </li>
            <li>
                <a _href="/adminRecordList">
                    <i class="iconfont">&#xe6a7;</i>
                    <cite>进度管理</cite>
                </a>
            </li>
            <li>
                <a _href="/setDistance">
                    <i class="iconfont">&#xe6a7;</i>
                    <cite>设置</cite>
                </a>
            </li>

            {{--<li>--}}
                {{--<a href="javascript:;">--}}
                    {{--<i class="iconfont">&#xe723;</i>--}}
                    {{--<cite>城市联动</cite>--}}
                    {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu">--}}
                    {{--<li>--}}
                        {{--<a _href="city.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>三级地区联动</cite>--}}
                        {{--</a>--}}
                    {{--</li >--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="javascript:;">--}}
                    {{--<i class="iconfont">&#xe726;</i>--}}
                    {{--<cite>管理员管理</cite>--}}
                    {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu">--}}
                    {{--<li>--}}
                        {{--<a _href="admin-list.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>管理员列表</cite>--}}
                        {{--</a>--}}
                    {{--</li >--}}
                    {{--<li>--}}
                        {{--<a _href="admin-role.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>角色管理</cite>--}}
                        {{--</a>--}}
                    {{--</li >--}}
                    {{--<li>--}}
                        {{--<a _href="admin-cate.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>权限分类</cite>--}}
                        {{--</a>--}}
                    {{--</li >--}}
                    {{--<li>--}}
                        {{--<a _href="admin-rule.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>权限管理</cite>--}}
                        {{--</a>--}}
                    {{--</li >--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="javascript:;">--}}
                    {{--<i class="iconfont">&#xe6ce;</i>--}}
                    {{--<cite>系统统计</cite>--}}
                    {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu">--}}
                    {{--<li>--}}
                        {{--<a _href="echarts1.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>拆线图</cite>--}}
                        {{--</a>--}}
                    {{--</li >--}}
                    {{--<li>--}}
                        {{--<a _href="echarts2.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>柱状图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts3.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>地图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts4.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>饼图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts5.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>雷达图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts6.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>k线图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts7.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>热力图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts8.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>仪表图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="javascript:;">--}}
                    {{--<i class="iconfont">&#xe6b4;</i>--}}
                    {{--<cite>图标字体</cite>--}}
                    {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu">--}}
                    {{--<li>--}}
                        {{--<a _href="unicode.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>图标对应字体</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="javascript:;">--}}
                    {{--<i class="iconfont">&#xe6b4;</i>--}}
                    {{--<cite>其它页面</cite>--}}
                    {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu">--}}
                    {{--<li>--}}
                        {{--<a href="login.html" target="_blank">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>登录页面</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="error.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>错误页面</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
      </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                <dl>
                    <dd data-type="this">关闭当前</dd>
                    <dd data-type="other">关闭其它</dd>
                    <dd data-type="all">关闭全部</dd>
                </dl>
          </div>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='/index' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
          <div id="tab_show"></div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved</div>  
    </div>
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
    @include('public.footer')
</body>
</html>