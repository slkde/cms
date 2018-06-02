@extends('home.layouts.master')
@section('title', '关于网站 - 集安信息网')
@section('content')

@push('css')
<style type="text/css">
	html {
    	overflow-y:scroll;
	}
</style>
@endpush
<ol class="breadcrumb small">
  <li><a href="/">首页</a></li>
  <li class="active">关于网站</li>
</ol>
<div class="row">
  <div  class="col-md-12">
  		<h3>关于网站</h3>
  		<hr />
  		<center><a href="/"><img width="350" alt="集安信息网" src="/uploads/homepage.png" class="img-thumbnail"></a></center>

  		<p><h4>您好，欢迎访问集安信息网！</h4></p>
  		<p>集安信息网开通于2011年7月，主要栏目设置：房产、人才、供求、车辆、交友、招生、出兑、服务、商家、资讯。</p>
  		<p>您可以免费浏览或发布各类信息，生活在集安就上集安信息网！</p>

  		<p>联系我们的方式 电话：155-0037-6323    扣扣：279497165    微信：279497165</p>
  </div>
</div>
@endsection