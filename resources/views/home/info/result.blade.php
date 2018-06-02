@extends('home.layouts.master')

@section('title', '供求信息发布 - 集安信息网')

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
$(document).ready(function(){
	$("#captchaImage").click(function(){
		this.src='/captcha?d='+Math.random();
	});
});
</script>
@endpush
<ol class="breadcrumb small">
  <li><a href="/">首页</a></li>
  <li class="active">供求信息发布</li>
</ol>
<div class="row">
  <div  class="col-md-12">
		<div class="jumbotron text-center">
			  <br />
			  <h4>{{ $message }}</h4>
		  <br />
		  <p>
			  <a href="/post" class="btn btn-default" role="button">&nbsp;&nbsp;继续发布&nbsp;&nbsp;</a>
			  <a href="/" class="btn btn-default" role="button">&nbsp;&nbsp;返回首页&nbsp;&nbsp;</a>
		  </p>

		</div>
    </div>
</div>

@endsection