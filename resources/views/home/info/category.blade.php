@extends('home.layouts.master')
@section('title', "集安信息网 - $category->name")
@section('content')

@push('js')
<script type="text/javascript">

$(document).ready(function(){

    var page = 1;
    $("#readmore").click(function () {
        page++;
        load_contents({{ $category->id }}, page);
    });

    function load_contents(cid, page){
        $.ajax({
          type: 'post',
          url: "/getinfo",
          data: "_token=<?php echo csrf_token() ?>&page=" + page + "&cid=" + cid,
          beforeSend: function() {
              $("#readmore").hide();
              $("#readmorecontainer").append("<span class=\"small\" id=\"loading\"><i class=\"icon-spinner icon-2x icon-spin\"></i>&nbsp;加载中......</span>");
          },
          success: function(html){
              if(html)
              {
                  $("#datalist").append(html);
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
<style type="text/css">
  .h4, h4 {
    font-size: 17px;
}
</style>
<ol class="breadcrumb small">您的位置：<li><a href="/">首页</a></li>{!! $breadcrumb !!}</ol>
<div class="row">
    <div  class="col-md-9">
        <div class="list-group" id="datalist">
            @foreach ($items as $info)
            <a target="_blank" href="/info-{{ $info->id }}.html" class="list-group-item" @if($info->category_top_expired > now() or $info->index_top_expired > now()) style="background-color: #fcf8e3" @endif>
                <h4 class="list-group-item-heading">
                    @if($info->category_top_expired > now() or $info->index_top_expired > now())<span class="label label-warning lb-md">顶</span>@else <i class="icon-caret-right"></i> @endif
                    <span @if($info->category_top_expired > now() or $info->index_top_expired > now()) style="color: #c81721;" @endif>
                    {{$info->title}}
                    </span>
                    @if($info->is_mobile == 'Y') <i class="icon-mobile-phone icon-large pull-right"></i>@endif
                </h4>
                <span class="list-group-item-text small text-muted">{{ str_limit($info->content, 80)}}</span>
                @if(date('Y-m-d',strtotime($info->created_at)) == date('Y-m-d'))
                    <span class="pull-right small">今天</span> 
                @else
                    <span class="pull-right small">{{ date('Y-m-d',strtotime($info->created_at)) }}</span>
                @endif
            </a>
            @endforeach
        </div>
        @if ($isShowMore == true) 
        <div align="center" id="readmorecontainer"><input id="readmore" class="btn btn-info btn-default btn-block" type="button" value=" 加载更多 "></div>
        @endif
    </div>
    <br class="visible-xs" />
    <div class="col-md-3">
        <div class="list-group small">
            <a href="#" class="list-group-item disabled">{{ $category->getparent ? $category->getparent->name : $category->name }}分类</a>
            @foreach ($categorys as $cat)
            <a href="{{ $cat->id }}" class="list-group-item {{ $category->id == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
         <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <center>广而告之！</center>
        </div>
    </div>
</div>
@endsection