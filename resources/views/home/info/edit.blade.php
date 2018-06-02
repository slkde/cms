@extends('home.layouts.master')
@section('title', '修改信息 - 集安信息网')
@section('content')

@push('css')
<link rel="stylesheet" href="/static/home/bootstrap-select/css/bootstrap-select.min.css">
<style type="text/css">
.thumbnail {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: block;
    line-height: 1.42857;
    margin-bottom: 5px;
    padding: 4px;
    transition: border 0.2s ease-in-out 0s;
}
</style>
@endpush

@push('js')
<script type="text/javascript" src="/static/home/bootstrap-select/js/bootstrap-select.min.js"> </script>
<script type="text/javascript" src="/static/home/bootstrap-filestyle/src/bootstrap-filestyle.min.js"> </script>
<script type="text/javascript">
	function deletePhoto(infoId, photoId)
	{

		$.ajax({
           type:'POST',
           url:'/deletePhoto',
           data:'_token=<?php echo csrf_token() ?>&infoId=' + infoId + '&photoId=' + photoId,
           success:function(data){
              if (data) {
              	$("#photo" + data).remove();
              	window.location.reload();
              }
           }
        });
	}
$(document).ready(function(){
	// 验证码切换
	$("#captchaImage").click(function(){
		this.src='/captcha?d='+Math.random();
	});
	
	// 表单验证
	$("#postform").click(function(){
		var submitForm = true;
		$(this).attr('disabled','disabled');

		// 验证码较验
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
               async:false,
               url:'/checkCaptcha',
               data:'_token=<?php echo csrf_token() ?>&captcha=' + $("#captcha").val(),
               success:function(data){
                  if (data.result == false) {
                  		$("#msgCaptcha").html("验证码输入错误");
                  		$("#captcha-form-group").addClass('has-error');
                  		submitForm = false;
                  } else {
                  		$("#msgCaptcha").html('');
                  		$("#captcha-form-group").removeClass('has-error');
                  }
               }
	        });
		}
		$(this).removeAttr('disabled');
		return submitForm;
	});
});
</script>
@endpush
<ol class="breadcrumb small">
  <li><a href="/">首页</a></li>
  <li class="active">修改信息</li>
</ol>
<div class="row">
  <div  class="col-md-12">
    <div class="panel panel-info">
        <div class="panel-body">
           	<h4>修改信息</h4>
           	<hr />

		    <form class="form-horizontal" role="form" action="info-modify-{{ $item->id }}.html" method="post" enctype="multipart/form-data">
			     <div id="form-group-category-id" class="form-group @if($errors->has('category_id')) has-error  @endif">
					  <label for="category_id" class="col-md-2 control-label">栏目</label>
					  <div class="col-md-5">
					  		<p class="form-control-static">{{ $item->category->name }}</p>
					  </div>
				</div>
				  <div id="form-group-area-id" class="form-group @if($errors->has('area_id')) has-error  @endif">
				    <label for="area_id" class="col-md-2 control-label">区域</label>
				    <div class="col-md-10">
						<select class="selectpicker show-tick" title="请选择" name="area_id" id="area_id">
						  <option @if(old('area_id',$item->area_id) == 1 ) selected="selected"  @endif value="1">市区/街道</option>
						  <option @if(old('area_id',$item->area_id) == 2 ) selected="selected"  @endif value="2">青石镇</option>
						  <option @if(old('area_id',$item->area_id) == 3 ) selected="selected"  @endif value="3">榆林镇</option>
						  <option @if(old('area_id',$item->area_id) == 4 ) selected="selected"  @endif value="4">花甸镇</option>
						  <option @if(old('area_id',$item->area_id) == 5 ) selected="selected"  @endif value="5">头道镇</option>
						  <option @if(old('area_id',$item->area_id) == 6 ) selected="selected"  @endif value="6">清河镇</option>
						  <option @if(old('area_id',$item->area_id) == 7 ) selected="selected"  @endif value="7">台上镇</option>
						  <option @if(old('area_id',$item->area_id) == 8 ) selected="selected"  @endif value="8">财源镇</option>
						  <option @if(old('area_id',$item->area_id) == 9 ) selected="selected"  @endif value="9">大路镇</option>
						  <option @if(old('area_id',$item->area_id) == 10 ) selected="selected"  @endif value="10">太王镇</option>
						  <option @if(old('area_id',$item->area_id) == 11 ) selected="selected"  @endif value="11">麻线乡</option>
						  <option @if(old('area_id',$item->area_id) == 12 ) selected="selected"  @endif value="12">凉水朝鲜族乡</option>
						  <option @if(old('area_id',$item->area_id) == 13 ) selected="selected"  @endif value="13">其他</option>
						</select>
						@if($errors->has('area_id')) <p class="text-warning small"><strong>{{ $errors->first('area_id') }}</strong></p>  @endif
				    </div>
				  </div>

				  <div id="form-group-day" class="form-group @if($errors->has('day')) has-error  @endif">
				     <label for="day" class="col-md-2 control-label">有效期限</label>
				     <div class="col-md-2">	
						<div class="input-group">
						  <input name="day" type="text" class="form-control" maxlength="2" value="{{ old('expired_days', $item->expired_days) }}">
						  <span class="input-group-addon">天</span>
						</div>
				    </div>
				  </div>

				  <div id="form-group-title" class="form-group @if($errors->has('title')) has-error  @endif">
				    <label for="title" class="col-md-2 control-label">标题</label>
				    <div class="col-md-5">
						<input value="{{ old('title', $item->title) }}" type="text" class="form-control" placeholder="有好标题，才会有好效果！建议10字以上。" name="title" id="title">
                        @if($errors->has('title'))<strong><p id="msgTitle" class="text-warning small">{{ $errors->first('title') }}</p></strong>@endif
				    </div>
				  </div>

				  <div id="form-group-content" class="form-group @if($errors->has('content')) has-error  @endif">
				    <label for="content" class="col-md-2 control-label">内容</label>
				    <div class="col-md-10">
						<textarea class="form-control" rows="10" name="content" id="content">{{ old('content', $item->content) }}</textarea>
                        @if($errors->has('content'))<strong><p id="msgContent" class="text-warning small">{{ $errors->first('content') }}</p></strong>@endif
				    </div>
				  </div>

				  <div  id="form-group-linkman" class="form-group @if($errors->has('linkman')) has-error  @endif">
				    <label for="linkman" class="col-md-2 control-label">联系人</label>
				    <div class="col-md-2">
						<input type="text" class="form-control" id="linkman" name="linkman" value="{{ old('linkman', $item->linkman) }}" maxlength="5">
						<strong><p id="msgLinkman" class="text-warning  small">@if($errors->has('linkman')){{ $errors->first('linkman') }}@endif</p></strong>
				    </div>
				  </div>

				  <div  id="form-group-tel" class="form-group @if($errors->has('tel')) has-error  @endif">
				    <label for="tel" class="col-md-2 control-label">手机号</label>
				    <div class="col-md-2">
						<input type="text" class="form-control" name="tel" id="tel" value="{{ old('tel', $item->tel) }}" maxlength="15">
                        @if($errors->has('tel'))<strong><p id="msgTel" class="text-warning small">{{ $errors->first('tel') }}</p></strong>@endif
				    </div>
				  </div>

				   <div class="form-group @if ($errors->has('images.0') || $errors->has('images.1') | $errors->has('images.2')) has-error @endif">
				    <label for="inputPassword3" class="col-md-2 control-label">图片</label>
				    <div class="col-md-4">
				    	@for ($i = count($item->photos); $i < 3; $i++)
<input data-input="false" data-iconName="icon-folder-open-alt" data-size="sm" data-buttonText="请选择" data-buttonName="btn-primary" class="filestyle" type="file" name="images[]"><br />
						@endfor
						@if($errors->has('images.0') || $errors->has('images.1') || $errors->has('images.2')) <p class="text-warning small">上传失败，确认上传的文件为图像且图像小于1M</p> @endif
						
						<div class="row">
							@foreach ($item->photos as $photo)
							<div class="col-md-4 text-center" id="photo{{$photo->id}}">
								<a target="_blank" href="{{ $photo->file }}" class="thumbnail"><img width="100" src="{{ $photo->file }}" ></a>
								<button onclick="deletePhoto({{$item->id}}, {{$photo->id}})" type="button" class="btn btn-default btn-xs">&nbsp;删&nbsp;除&nbsp;</button>
							</div>
						    @endforeach
						</div>
				    </div>

				  </div>

				  <div  id="form-group-ps" class="form-group @if($errors->has('ps')) has-error  @endif">
				    <label for="ps" class="col-md-2 control-label">管理密码</label>
				    <div class="col-md-2">
						<input type="text" class="form-control" name="ps" id="ps" value="{{ old('ps', $item->manage_passwd) }}" maxlength="10">
                        @if($errors->has('ps'))<strong><p id="msgPs" class="text-warning small">{{ $errors->first('ps') }}</p></strong>@endif
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
				  <div class="form-group">
				    <div class="col-md-offset-1 col-lg-md text-center">
				      <input type="hidden" name="_token" value="{{ csrf_token() }}">
				      <input type="hidden" name="id" value="{{ $item->id }}">
				      <button id="postform" type="submit" class="btn btn-primary btn-lg">&nbsp;&nbsp;保 存 信 息&nbsp;&nbsp;</button>
				    </div>
				  </div>
			</form>
		</div>
      </div>
    </div>
</div>
@endsection