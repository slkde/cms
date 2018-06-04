@extends('home.layouts.master')
@section('title', '集安信息网')
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
        
          <form class="form-inline" method="get" action="/search/">
            <center>
                <div id="searchInfoByTelForm" class="form-group">
                  <label class="sr-only" for="tel">电话</label>
                  <input maxlength="15" type="text" class="form-control input-default" id="tel" placeholder="电话" name="tel">
                </div>
                <button type="button" id="searchInfoByTel" class="btn btn-default btn-default">查找</button>                
                <p />
                <div class="modal-footer" id="msgSearch">&nbsp;</div>
            </center>
          </form>
      </div>
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
            <ul class="list-group">
                  @foreach ($latestItems as $item)
                      <li class="list-group-item ">
                      @if($item->index_top_expired > now())<span class="label label-warning lb-md">顶</span>@else <i class="icon-angle-right"></i>@endif
                        <strong>
                            <a target="_blank" @if($item->index_top_expired > now()) class="text-top" @endif href="/info-{{ $item->id }}.html">
                                 {{ str_limit($item->title, 40) }}
                            </a>
                        </strong>
                        @if($item->tel != null)<i class="icon-mobile-phone icon-large"></i>@endif
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
    </div>
  <div class="col-md-4" id="container-main-right">
         <div class="panel panel-default hidden-xs">
          <div class="panel-body small text-center ">
              <p><strong>今天是 {{ date("Y年m月d日") }} 祝您一切顺利！</strong></p>
              <div><img width="100" src="qrcode.png"></div>
              <a href="/post" class="btn btn-primary" role="button"><i class="icon-pencil"></i> 快速发布信息</a>
              <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary" role="button"><i class="icon-search"></i> 查找我的信息</a>              
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
            {{-- @foreach ($blog_articles as $item)
            <li class="list-group-item"><a target="_blank" href="http://www.ja168.net/blog/?p={{ $item->id }}">{{$item->post_title}}</a></li>  
            @endforeach             --}}
          </div>
        </div>
  </div>
</div>
@endsection