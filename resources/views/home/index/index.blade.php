@extends('home.layouts.master')
@section('title', '集安信息网')
@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    var page = 1;
    $("#readmore").click(function () {
        page++;
        load_contents(page);
    });

    function load_contents(page){
        $.ajax({
          type: 'post',
          url: '/getinfo',
          data:{'_token':'{{csrf_token()}}', 'page':page},
          beforeSend: function() {
              $("#readmore").hide();
              $("#readmorecontainer").append("<span class=\"small\" id=\"loading\"><i class=\"icon-spinner icon-2x icon-spin\"></i>&nbsp;加载中......</span>");
          },
          success: function(html){
              if(html)
              {
                  $("#list").append(html);
                  //$("html, body").animate({scrollTop: $("#readmore").offset().top}, 800);
              } else {
                  $("#readmore").remove();
                  $("#readmorecontainer").html('数据已经全部显示');
              }
              $("#loading").remove();
              $("#readmore").show();
          },
          dataType: 'html'
        });
    }
});
</script>
@endpush
@section('content')
@push('custom')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">请输入您的电话：</h4>
      </div>
      <div class="modal-body small">
          <form class="form-inline text-center" method="get" action="/search/">
                <div id="searchInfoByTelForm" class="form-group">
                  <label class="sr-only" for="tel">电话</label>
                  <input maxlength="15" type="text" class="form-control input-default" id="tel" placeholder="电话" name="tel">
                </div>
                <button type="button" id="searchInfoByTel" class="btn btn-default">查找</button>
          </form>
      </div>
      <div class="modal-footer" id="msgSearch">&nbsp;</div>
    </div>
  </div>
</div>
@endpush
<div class="row">
    <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading">
                  <div class="text-muted pull-left">最新信息</div>&nbsp;
                  <div class="pull-right">
                      <a class="text-top small hidden-xs" tabindex="0" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" data-content="通过搜索找到冒发的信息，用该信息中所留的联系方式联系网站客服，申请取消信息。">电话被冒用了，怎么办？！</a>
                      <a class="text-top small" target="_blank" href="/tp">置顶推广</a>&nbsp;
                      <a class="visible-xs-inline small" href="/post">发布信息</a>&nbsp;
                  </div>
            </div>
            <ul class="list-group" id="list">
                  @foreach ($latestItems as $item)
                      <li class="list-group-item ">
                      @if($item->index_top_expired > now())<span class="label label-warning lb-md">顶</span>@else <i class="icon-angle-right"></i>@endif
                        <strong>
                            <a target="_blank" @if($item->index_top_expired > now()) class="text-top" @endif href="/info-{{ $item->id }}.html">
                                 {{ str_limit($item->title, 40) }}
                            </a>
                        </strong>
                        @if($item->is_mobile == 'Y')<i class="icon-mobile-phone icon-large"></i>@endif
                          <a target="_blank" class="small text-info hidden-xs" href="/category/{{ $item->category->id }}">{{ $item->category->name }}</a>
                          <span class="small text-muted hidden-xs">{{ $item->district->name }}</span>
                        @if(date('Y-m-d',strtotime($item->created_at)) == date('Y-m-d'))
                        <span class="small text-muted pull-right">今天</span>
                        @else
                        <span class="small text-muted pull-right">{{ date('Y-m-d',strtotime($item->created_at)) }}</span>
                        @endif
                      </li>
                  @endforeach
              </ul>
          </div>
          {{-- @if ($isShowMore == true) --}}
          <div class="text-center" id="readmorecontainer"><input id="readmore" class="btn btn-info btn-default btn-block" type="button" value=" 加载更多 "></div>
          {{-- @endif --}}
    </div>
  <div class="col-md-4" id="container-main-right">
         <div class="panel panel-default hidden-xs">
          <div class="panel-body small text-center ">
              <p><strong>今天是 {{ date("Y年m月d日") }} 祝您一切顺利！</strong></p>
              <div><img width="100" src="{{ asset('/upload/qrcode.png') }}"></div>
              <a href="/post" class="btn btn-primary" role="button"><i class="icon-pencil"></i> 快速发布信息</a>
              <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary" role="button"><i class="icon-search"></i> 查找我的信息</a>              
          </div>
        </div>

        <div class="panel panel-default hidden-xs hidden-sm">     
          <div class="panel-heading"><div class="text-muted pull-left">支付宝扫码领红包</div>&nbsp;</div>
          <div class="list-group small">            
            <div class="text-center"><img width="80%" src="{{ asset('/upload/alipayhb.jpg') }}"></div>
          </div>
        </div>

        <div class="panel panel-default hidden-xs">     
          <div class="panel-heading"><div class="text-muted pull-left">最新回复</div>&nbsp;</div>
          <div class="list-group small">            
            @foreach ($comments as $item)
            @if(mb_strlen($item->content) > 3)
            <li class="list-group-item"><a target="_blank" href="info-{{ $item->article_id }}.html" >{{ str_limit($item->content, 45) }}</a></li>            
            @endif
            @endforeach
          </div>
        </div>

        <div class="panel panel-default hidden-xs">     
          <div class="panel-heading"><div class="text-muted pull-left">最新文章</div>&nbsp;</div>
          <div class="list-group small">
            @foreach ($blog_articles as $item)
            <li class="list-group-item"><a target="_blank" href="http://www.ja168.net/blog/?p={{ $item->id }}">{{$item->post_title}}</a></li>  
            @endforeach            
          </div>
        </div>
  </div>
</div>
@endsection