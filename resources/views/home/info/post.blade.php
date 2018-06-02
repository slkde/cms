@extends('home.layouts.master')
@section('title', '供求信息发布 - 集安信息网')
@section('content')
@push('css')
<link rel="stylesheet" href="/bootstrap-select/css/bootstrap-select.min.css">
@endpush

@push('js')
<script type="text/javascript" src="/bootstrap-select/js/bootstrap-select.min.js"> </script>
<script type="text/javascript" src="/bootstrap-filestyle/src/bootstrap-filestyle.min.js"> </script>
<script type="text/javascript">
$(document).ready(function(){
	// 验证码切换
	$("#captchaImage").click(function(){
		this.src='/captcha?d='+Math.random();
	});

	// 表单验证
	$("#postform").click(function(){
		var submitForm = true;
		$("#postform").prop('disabled', true);
		$(this).html('信息提交中......');

		/* 栏目 */
		if(! $( "#category_id" ).val())
		{
			$("#msgCategoryId").html('请选择栏目');
			$("#category_id-form-group").addClass('has-error');
			submitForm = false;
		} else {
			$("#msgCategoryId").html('');
			$("#category_id-form-group").removeClass('has-error');
		}


		/* 检查标题长度 */
		var title = $('#title').val();
		if (title.length < 6) {
			$("#msgTitle").html('标题至少6个字，请用一句话概括信息。');
			$("#title-form-group").addClass('has-error');
			submitForm = false;
		} else {
			$("#msgTitle").html('');
			$("#title-form-group").removeClass('has-error');
		}

		/* 检查电话 */
		var tip   = $('#msgTel'), phone = $('#tel').val();
		var reg = /^1[3|4|5|7|8][0-9]\d{8}$/;
		if (! reg.test(phone)) {
			$("#tel-form-group").addClass('has-error');
			tip.html('手机号格式错误');
			submitForm = false;
		} else {
			tip.html('');
			$("#tel-form-group").removeClass('has-error');
		}

		/* 检查管理密码 */
		var ps = $('#ps').val();
		if (ps.length < 4) {
			$("#msgPs").html('至少四个字符');
			$("#ps-form-group").addClass('has-error');
			submitForm = false;
		} else {
			$("#msgPs").html('');
			$("#ps-form-group").removeClass('has-error');
		}

		/* 检查验证码 */ 
		var captcha = $("#captcha").val();
		if (! captcha) {
			$("#msgCaptcha").html("请输入验证码");
			$("#captcha-form-group").addClass('has-error');
			submitForm = false;
		} else if (captcha.replace(/ /g,'').length != 4) {
			$("#msgCaptcha").html("验证码输入错误");
			$("#captcha-form-group").addClass('has-error');
			submitForm = false;
		} else {
			$.ajax({
               type:'POST',
               url:'/checkCaptcha',
               data:'_token=<?php echo csrf_token() ?>&captcha=' + $("#captcha").val(),
               success:function(data){
                  if (data.result == false) {
                  		$("#msgCaptcha").html("验证码输入错误");
                  		$("#captcha-form-group").addClass('has-error');
                  		var submitForm = false;
                  } else {
                  		$("#msgCaptcha").html('');
                  		$("#captcha-form-group").removeClass('has-error');
                  }
               }
	        });
		}
		if(! submitForm)
		{
			$("#postMessage").html("<div style=\"font-size:14px;color:red;font-weight:bold\">有错误发生，请检查输入...</div>");
			$("#postform").prop('disabled', false);
			$(this).html("&nbsp;&nbsp;填 写 完 毕 ， 现 在 发 布&nbsp;&nbsp;");
			return false;
		} else {
			$("#info-form").submit();
			return true;
		}
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
    <div class="panel panel-info">
        <div class="panel-body">
           	<h4>发布信息</h4>
           	<div class="alert alert-warning alert-dismissible small hidden-xs" role="alert">
		      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

		      <p>①集安信息网采用信息审核制，信息需经审核且通过后才会显示，发布信息请遵守相关法律法规</p>
		      <p>②互联网违禁及其它有风险的信息不予审核，包括：出国劳务、移民、医疗药品、发票、贷款、信用卡、股票基金、现货期货、刷淘宝信誉等</p>
		      <p>③为保证良性秩序：禁止同一单位或个人用多个号码发布重复信息</p>
		    </div>
           	<hr />
		    <form id="info-form" class="form-horizontal" role="form" action="/post" method="post" enctype="multipart/form-data">
			    <div id="category_id-form-group" class="form-group @if($errors->has('category_id')) has-error  @endif">
					  <label for="category_id" class="col-md-2 control-label">栏目</label>
					  <div class="col-md-5">
								<select class="selectpicker show-tick" title="请选择" name="category_id" id="category_id">
								    <option @if(old('category_id') == 1 ) selected="selected"  @endif value="1" data-subtext="求租/出租/求购/中介/公寓/旅店/门市/商铺/摊位...">房产</option>
								    <option @if(old('category_id') == 2 ) selected="selected"  @endif value="2" data-subtext="店员/营业员/经营/行政/人事/后勤/教师/教练/助教...">人才</option>
								    <option @if(old('category_id') == 3 ) selected="selected"  @endif value="3" data-subtext="物品交换/手机/电脑/家电/工具/设备/材料...">供求</option>
								    <option @if(old('category_id') == 4 ) selected="selected"  @endif value="4" data-subtext="装修/维修/家政/快递/物流/搬家/庆典/摄影/鲜花...">服务</option>
								    <option @if(old('category_id') == 5 ) selected="selected"  @endif value="5" data-subtext="兴趣交友/征婚/寻亲/寻友...">交友</option>
								    <option @if(old('category_id') == 6 ) selected="selected"  @endif value="6" data-subtext="新车/二手车/手续/摩托/电动/自行车/拼车/租车/代驾...">车辆</option>
								</select>
                          <strong><p id="msgCategoryId" class="small text-warning">@if($errors->has('category_id')){{ $errors->first('category_id') }}@endif</p></strong>
					  </div>
				</div>

				  <div id="area_id-form-group" class="form-group @if($errors->has('area_id')) has-error  @endif">
				    <label for="area_id" class="col-md-2 control-label">区域</label>
				    <div class="col-md-10">
						<select class="selectpicker show-tick" title="请选择" name="area_id" id="area_id">
						  <option @if(! old('area_id')) selected="selected"  @endif @if(old('area_id') == 1 ) selected="selected"  @endif value="1">市区/街道</option>
						  <option @if(old('area_id') == 2 ) selected="selected"  @endif value="2">青石镇</option>
						  <option @if(old('area_id') == 3 ) selected="selected"  @endif value="3">榆林镇</option>
						  <option @if(old('area_id') == 4 ) selected="selected"  @endif value="4">花甸镇</option>
						  <option @if(old('area_id') == 5 ) selected="selected"  @endif value="5">头道镇</option>
						  <option @if(old('area_id') == 6 ) selected="selected"  @endif value="6">清河镇</option>
						  <option @if(old('area_id') == 7 ) selected="selected"  @endif value="7">台上镇</option>
						  <option @if(old('area_id') == 8 ) selected="selected"  @endif value="8">财源镇</option>
						  <option @if(old('area_id') == 9 ) selected="selected"  @endif value="9">大路镇</option>
						  <option @if(old('area_id') == 10 ) selected="selected"  @endif value="10">太王镇</option>
						  <option @if(old('area_id') == 11 ) selected="selected"  @endif value="11">麻线乡</option>
						  <option @if(old('area_id') == 12 ) selected="selected"  @endif value="12">凉水朝鲜族乡</option>
						  <option @if(old('area_id') == 13 ) selected="selected"  @endif value="13">其他</option>
						</select>
						@if($errors->has('area_id')) <p class="text-warning small"><strong>{{ $errors->first('area_id') }}</strong></p>  @endif
				    </div>
				  </div>

				  <div id="day-form-group" class="form-group @if($errors->has('day')) has-error  @endif">
				     <label for="day" class="col-md-2 control-label">有效期限</label>
				     <div class="col-md-2">	
						<div class="input-group">
						  <input type="text" class="form-control" maxlength="3" value="{{ old('day', 30) }}" name="day" id="day">
						  <span class="input-group-addon">天</span>
						  @if($errors->has('area_id')) <p class="text-warning small"><strong>{{ $errors->first('day') }}</strong></p>  @endif
						</div>
				    </div>
				    <div class="col-md-6">
						<span class="help-block small"> 可根据实际需要修改，留空为长期有效</span>
				    </div>
				  </div>

				  <div id="title-form-group" class="form-group @if($errors->has('title')) has-error  @endif">
				    <label for="title" class="col-md-2 control-label">标题</label>
				    <div class="col-md-5">
						<input autocomplete="off" value="{{ old('title') }}" type="text" class="form-control" placeholder="有好标题，才会有好效果！建议6个字以上。" name="title" id="title" maxlength="30">
                        <strong><span id="msgTitle" class="text-warning small">@if($errors->has('title')){{ $errors->first('title') }}@endif</span></strong>
				    </div>
				  </div>

				  <div id="content-form-group" class="form-group @if($errors->has('content')) has-error  @endif">
				    <label for="content" class="col-md-2 control-label">内容</label>
				    <div class="col-md-10">
						<textarea class="form-control" rows="5" name="content" id="content">{{ old('content') }}</textarea>
                        @if($errors->has('content'))<strong><p id="msgContent" class="text-warning small">{{ $errors->first('content') }}</p></strong>@endif
				    </div>
				  </div>

				  <div  id="linkman-form-group" class="form-group @if($errors->has('linkman')) has-error  @endif">
				    <label for="linkman" class="col-md-2 control-label">称呼</label>
				    <div class="col-md-2">
						<input autocomplete="off" type="text" class="form-control" id="linkman" name="linkman" value="{{ old('linkman') }}" maxlength="5">
						<strong><p id="msgLinkman" class="text-warning  small">@if($errors->has('linkman')){{ $errors->first('linkman') }}@endif</p></strong>
				    </div>
				  </div>

				  <div  id="tel-form-group" class="form-group @if($errors->has('tel')) has-error  @endif">
				    <label for="tel" class="col-md-2 control-label">手机</label>
				    <div class="col-md-2">
						<input autocomplete="off" type="text" class="form-control" name="tel" id="tel" value="{{ old('tel') }}" maxlength="11">
                        <strong><span id="msgTel" class="text-warning small">@if($errors->has('tel')){{ $errors->first('tel') }}@endif</span></strong>
				    </div>
				  </div>

				  <div  id="email-form-group" class="form-group @if($errors->has('email')) has-error  @endif">
				    <label for="email" class="col-md-2 control-label">邮箱</label>
				    <div class="col-md-2">
						<input autocomplete="off" type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" maxlength="15">
                        @if($errors->has('email'))<strong><p id="msgEmail" class="text-warning small">{{ $errors->first('email') }}</p></strong>@endif
				    </div>
				    <div class="col-md-6">
						<span class="help-block small">可选。</span>
				    </div>				    
				  </div>

				   <div class="form-group @if ($errors->has('images.0') || $errors->has('images.1') | $errors->has('images.2')) has-error @endif">
				    <label for="inputPassword3" class="col-md-2 control-label">图片</label>
				    <div class="col-md-2">
				    	<input data-input="false" data-iconName="glyphicon icon-folder-open-alt" data-size="sm" data-buttonText="请选择" data-buttonName="btn-primary" class="filestyle" type="file" name="images[]">
				    	@if($errors->has('images.0')) <p class="text-warning small">图像上传失败</p> @endif<br />
				    </div>
				    <div class="col-md-2">
				    	<input data-input="false" data-iconName="glyphicon icon-folder-open-alt" data-size="sm" data-buttonText="请选择" data-buttonName="btn-primary" class="filestyle" type="file" name="images[]">
				    	@if($errors->has('images.1')) <p class="text-warning small">图像上传失败</p> @endif<br />
				    </div>
				    <div class="col-md-2">
				    	<input data-input="false" data-iconName="glyphicon icon-folder-open-alt" data-size="sm" data-buttonText="请选择" data-buttonName="btn-primary" class="filestyle" type="file" name="images[]">
				    	@if($errors->has('images.2')) <p class="text-warning small">图像上传失败</p> @endif
				    </div>					
				  </div>
				  <div  id="ps-form-group" class="form-group @if($errors->has('ps')) has-error  @endif">
				    <label for="ps" class="col-md-2 control-label">管理密码</label>
				    <div class="col-md-2">
						<input autocomplete="off" type="text" class="form-control" name="ps" id="ps" value="{{ old('ps') }}" maxlength="15">
                        <strong><p id="msgPs" class="text-warning small">@if($errors->has('ps')){{ $errors->first('ps') }}@endif</p></strong>
				    </div>
				    <div class="col-lg-6">
						<span class="help-block small"><span class="text-danger"><strong>重要，至少四位！</strong></span>作为日后修改、取消信息的重要凭证，请牢记！</span>
				    </div>	
				  </div>
				  
				  <div  id="captcha-form-group" class="form-group  @if($errors->has('captcha')) has-error  @endif">
				    <label for="inputPassword3" class="col-md-2 control-label">验证码</label>
				    <div class="col-md-2">
						<input type="text" class="form-control" id="captcha" name="captcha" autocomplete="off" maxlength="4">
						<strong><p id="msgCaptcha" class="text-warning small">@if($errors->has('captcha')){{ $errors->first('captcha') }}@endif</p></strong>
						<img id="captchaImage" src="{!! captcha_src() !!}">
				    </div>
				    <div class="col-md-6">
						<span class="help-block small"><span class="text-danger"></span>看不清？请点击图片切换。</span>
				    </div>
				  </div>
					<p class="small text-center text-muted">
						提示：禁止同一单位或个人用多个号码发布重复信息，信息需经审核且通过后才会显示，发布信息请遵守相关法律法规。
					</p>
				  <div class="form-group">
				    <div class="col-md-offset-1 col-lg-md text-center" id="postFooter">
				      <input type="hidden" name="_token" value="{{ csrf_token() }}">
				      <button id="postform" type="submit" class="btn btn-primary btn-lg">&nbsp;&nbsp;填 写 完 毕 ， 现 在 发 布&nbsp;&nbsp;</button>
				      <div id="postMessage">&nbsp;</div>
				    </div>
				  </div>
			</form>
		</div>
      </div>
    </div>
</div>
@endsection