@extends('home.layouts.master')

@section('title', '集安信息网')

@section('content')

@push('css')
<link rel="stylesheet" href="/static/home/bootstrap-select/css/bootstrap-select.min.css">
<style type="text/css">
	html {
    	overflow-y:scroll;
	}
</style>
@endpush

@push('js')
<script type="text/javascript" src="/static/home/bootstrap-select/js/bootstrap-select.min.js"> </script>
<script type="text/javascript" src="/static/home/bootstrap-filestyle/src/bootstrap-filestyle.min.js"> </script>
<script type="text/javascript">
// $(document).ready(function(){
// 	$("#captchaImage").click(function(){
// 		this.src='/captcha?d='+Math.random();
// 	});
// });
</script>
@endpush
<ol class="breadcrumb small">
  <li><a href="/">首页</a></li>
  <li class="active">提示信息</li>
</ol>
<div class="row">
  <div  class="col-md-12">
		<div class="jumbotron text-center">
				<br />
				<h4>找不到该页面</h4>
			  <h4>{{ Session::get('message') }}</h4>
		  <br />
		  <p>
			  <a href="/post" class="btn btn-default" role="button">&nbsp;&nbsp;发&nbsp;布&nbsp;信&nbsp;息&nbsp;&nbsp;</a>
			  
			  <a href="/" class="btn btn-default" role="button">&nbsp;&nbsp;返&nbsp;回&nbsp;首&nbsp;页&nbsp;&nbsp;</a>			  
		  </p>

		</div>
    </div>
</div>

@endsection