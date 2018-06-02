@extends('home.layouts.master')

@section('title', '搜索 - 集安信息网')

@section('content')

@push('css')
<link rel="stylesheet" href="/bootstrap-select/css/bootstrap-select.min.css">
<style type="text/css">
	html {
    	overflow-y:scroll;
	}
</style>
@endpush

@push('js')
<script type="text/javascript" src="/bootstrap-select/js/bootstrap-select.min.js"> </script>
<script type="text/javascript" src="/bootstrap-filestyle/src/bootstrap-filestyle.min.js"> </script>
<script type="text/javascript">

</script>
@endpush
<ol class="breadcrumb small">
  <li><a href="/">首页</a></li>
  <li class="active">搜索结果</li>
</ol>
<div class="row">
 	<div  class="col-md-12">
		<div class="list-group">
            @forelse ($items as $info)
			<a target="_blank" href="/info-{{ $info->id }}.html" class="list-group-item">
			<h4 class="list-group-item-text"><span><i class="icon-caret-right"></i> {{$info->title}}</span></h4>
			<span class="list-group-item-text small">{{ str_limit($info->content, 65)}}</span><span class="pull-right">{{ $info->created_at_new }}</span>
			</a>
			@empty
			未查到信息
            @endforelse
		</div>
    </div>
</div>

@endsection