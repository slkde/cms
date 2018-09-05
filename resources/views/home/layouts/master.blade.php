<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <meta name="keywords" content="集安,集安房产,集安二手房,集安租房,集安人才,集安招聘,集安供求,集安二手车,集安出兑,集安信息港,集安信息网">
        <meta name="description" content="集安生活信息网站，主要栏目设置：房产、人才、供求、车辆、交友、招生、出兑、服务、商家、资讯。">        
        <link href="/static/home/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/static/home/awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="/static/home/css/patch.css" rel="stylesheet" type="text/css">
        @stack('css')
    </head>
    <body>
        </div>
        <script type="text/javascript">
          (function(win,doc){
                var s = doc.createElement("script"), h = doc.getElementsByTagName("head")[0];
                if (!win.alimamatk_show) {
                    s.charset = "gbk";
                    s.async = true;
                    s.src = "https://alimama.alicdn.com/tkapi.js";
                    h.insertBefore(s, h.firstChild);
                };
                var o = {
                    pid: "mm_31378226_46578774_19966750203",/*推广单元ID，用于区分不同的推广渠道*/
                    appkey: "24950673",/*通过TOP平台申请的appkey，设置后引导成交会关联appkey*/
                    unid: "",/*自定义统计字段*/
                    type: "click" /* click 组件的入口标志 （使用click组件必设）*/
                };
                win.alimamatk_onload = win.alimamatk_onload || [];
                win.alimamatk_onload.push(o);
            })(window,document);
        
        </script>
        <div class="container">
          <nav class="navbar navbar-default"  role="navigation">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand " href="/">集安信息网</a>
              </div>

              <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                  {{-- @foreach($menu as $v)
                    <li><a href="/category/{{ $v->id }}"><i class="icon-home">&nbsp;</i>{{ $v->name }}</a></li>
                  @endforeach --}}
                  <li><a href="/category/1"><i class="icon-home">&nbsp;</i>房产</a></li>
                  <li><a href="/category/2" ><i class="icon-user">&nbsp;</i>人才</a></li>
                  <li><a href="/category/3" ><i class="icon-shopping-cart">&nbsp;</i>供求</a></li>
                  <li><a href="/category/4" ><i class="icon-bell">&nbsp;</i>服务</a></li>
                  <li><a href="/category/5" ><i class="icon-heart">&nbsp;</i>交友</a></li>
                  <li><a href="/category/6" ><i class="icon-truck">&nbsp;</i>车辆</a></li>
                </ul>
               <form class="navbar-form navbar-left">
                <div class="input-group"  >
                  <input type="text" style="font-size: 12px;" class="form-control" placeholder="请输入电话或者关键词" id="keyword" value="{{  $key or '' }}">
                  <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search">
                      <i class="icon-search"></i>
                    </button>
                  </div>
                </div>
              </form>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
          {{-- 广告位 --}}
          <div class="text-center hidden-xs">

            <script type="text/javascript">
                var cpro_id = "u2951847";
            </script>
            <script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>

            
          </div>
          
          @yield('content')
          <div class="row">
            <div  class="col-md-12 text-center small">
                  <hr />
                  <p>集安信息网，家乡人自己的生活信息平台！</p>
                                      <p>
                        <a target="_blank" href="/about">关于</a> &nbsp; 
                        <a target="_blank" href="/post">发布</a> &nbsp;                         
                        <a target="_blank" href="/tp">置顶</a> &nbsp; 
                        <a target="_blank" href="/statement">声明</a> &nbsp; 
                        <a target="_blank" href="/blog">博客</a> &nbsp; 
                        <a class="hidden-xs" target="_blank" href="/sitemap.xml">Sitemap</a>

                    </p>
                  <p>Copyright @ 2011-2018 集安小江南信息网 吉ICP备11004057号</p>
                  @if (Request::path() == '/')
                    <ul class="list-inline hidden-xs">
                            <li><strong>友情链接：</strong></li>
                            <li><a target="_blank" href="http://www.0434w.com/">四平信息网</a></li>
                            <li><a target="_blank" href="http://www.ddxinxi.cn/">丹东信息网</a></li>
                            <li><a target="_blank" href="http://www.e0453.com/">牡丹江信息网</a></li>
                            <li><a target="_blank" href="http://www.songyuan123.com/">松原信息网</a></li>
                            <li><a target="_blank" href="http://www.cqkan.com/">长青信息网</a></li>
                            <li><a target="_blank" href="http://www.cqhc.cn/">合川信息网</a></li>
                            <li><a target="_blank" href="http://www.jldh.net/">敦化信息网</a></li>
                            <li><a target="_blank" href="http://www.2ya.com.cn/">公主岭供求世界</a></li>
                            <li><a target="_blank" href="http://www.419300.com/">溆浦信息网</a></li>
                            <li><a target="_blank" href="/url/aHR0cDovL3RpZWJhLmJhaWR1LmNvbS9mP2t3PSVCQyVBRiVCMCVCMiZmcj1hbGEwJnRwbD01">集安贴吧</a></li>
                            <li><a target="_blank" href="/url/aHR0cDovL3d3dy53ZWF0aGVyLmNvbS5jbi93ZWF0aGVyLzEwMTA2MDUwNS5zaHRtbA==">集安天气</a></li>
                            
                    </ul>
                  @endif
            </div>
          </div>
      </div>
      @stack('custom')
      <script src="{{asset('/static/home/js/jquery-3.1.1.min.js')}}"></script>
      <script src="{{asset('/static/home/bootstrap/js/bootstrap.min.js')}}"></script>
      <script type="text/javascript">
          $(document).ready(function(){
            $('[data-toggle="popover"]').popover()
            $("#searchInfoByTel").click(function(){
                  var tel = $("#tel").val();
                  if ( (! /^[0-9]+\-?\d+$/.test(tel)) || (7 > tel.length || tel.length > 11) ) {
                      $("#msgSearch").html("<center><strong  class=\"text-warning\">电话号码输入错误</strong></center>");
                      $("#searchInfoByTelForm").addClass('has-error');
                      return false;
                  }
                  window.location.href = '/search/' + tel;
            });

              $("#search").click(function(){
                    var keyword = $("#keyword").val();
                    if (! keyword) {
                      return false;
                    }
                    window.location.href = '/search/' + keyword;
                    return false;
              });
              // var _hmt = _hmt || [];
              // (function() {
              //   var hm = document.createElement("script");
              //   hm.src = "https://hm.baidu.com/hm.js?7c264a8d181125904ec9d9a949b71c0d";
              //   var s = document.getElementsByTagName("script")[0]; 
              //   s.parentNode.insertBefore(hm, s);
              // })();
              var _hmt = _hmt || [];
              (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?a64d6598aabfd46656aad760fe6b5354";
                var s = document.getElementsByTagName("script")[0]; 
                s.parentNode.insertBefore(hm, s);
              })();
              
          });
      </script>        
      @stack('js')      
    </body>
</html>