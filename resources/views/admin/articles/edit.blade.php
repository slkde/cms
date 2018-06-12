@extends('admin.app')
@section('other-css')
    {{-- <link rel="stylesheet" href="/static/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> --}}
    <link rel="stylesheet" href="/static/admin/plugins/bootstrap-select/css/bootstrap-select.min.css">
    <link href="/static/admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
@endsection
@section('content-header')
    <h1>
        内容管理
        <small>文章</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="{{url('/279497165/article')}}">内容管理</a></li>
        <li class="active">编辑信息</li>
    </ol>
@stop

@section('content')
    <h2 class="page-header">编辑信息</h2>
    <div class="box box-primary">
        <form method="POST" action="/279497165/article/{{ $item->id }}" accept-charset="utf-8" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            <div class="nav-tabs-custom">
                <div class="tab-content">

                    <div class="tab-pane active">
                        <div class="form-group">
                            <label>标题
                                <small class="text-red">*</small>
                            </label>
                            <input type="text" class="form-control" name="title" autocomplete="off"
                                   placeholder="{{ $item->title }}" maxlength="80">
                        </div>
                        <div class="form-group">
                            <label>联系人
                                <small class="text-red">*</small>
                            </label>
                            <input type="text" class="form-control" name="linkman" autocomplete="off"
                                   placeholder="{{ $item->linkman }}" maxlength="80">
                        </div>
                        <div class="form-group">
                            <label>栏目
                                <small class="text-red">*</small>
                            </label>
                            <!-- select -->
                            <div class="form-group">
                                <select class="form-control" name="category_id" id="category_id">
                                    <option @if(old( 'category_id')==1 ) selected="selected" @endif value="1" data-subtext="求租/出租/求购/中介/公寓/旅店/门市/商铺/摊位...">房产</option>
                                    <option @if(old( 'category_id')==2 ) selected="selected" @endif value="2" data-subtext="店员/营业员/经营/行政/人事/后勤/教师/教练/助教...">人才</option>
                                    <option @if(old( 'category_id')==3 ) selected="selected" @endif value="3" data-subtext="物品交换/手机/电脑/家电/工具/设备/材料...">供求</option>
                                    <option @if(old( 'category_id')==4 ) selected="selected" @endif value="4" data-subtext="装修/维修/家政/快递/物流/搬家/庆典/摄影/鲜花...">服务</option>
                                    <option @if(old( 'category_id')==5 ) selected="selected" @endif value="5" data-subtext="兴趣交友/征婚/寻亲/寻友...">交友</option>
                                    <option @if(old( 'category_id')==6 ) selected="selected" @endif value="6" data-subtext="新车/二手车/手续/摩托/电动/自行车/拼车/租车/代驾...">车辆</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="category_id" id="category_id_child">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>首页置顶
                                <small class="text-red">*</small>
                            </label>
                            <input autocomplete="off" type="text" class="form-control datetime" name="index_top_expired" value="{{ old('index_top_expired', $item->index_top_expired) }}">
                        </div>
                        <div class="form-group">
                            <label>分类置顶
                                <small class="text-red">*</small>
                            </label>
                            <input autocomplete="off" type="text" class="form-control datetime" name="category_top_expired" value="{{ old('category_top_expired', $item->category_top_expired) }}">
                        </div>
                        <div class="form-group">
                            <label>区域
                                <small class="text-red">*</small>
                            </label>
                            <select class="js-example-placeholder-single form-control" name="district_id" title="请选择" >
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 1 ) selected="selected" @endif value="1">市区/街道</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 2 ) selected="selected" @endif value="2">青石镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 3 ) selected="selected" @endif value="3">榆林镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 4 ) selected="selected" @endif value="4">花甸镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 5 ) selected="selected" @endif value="5">头道镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 6 ) selected="selected" @endif value="6">清河镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 7 ) selected="selected" @endif value="7">台上镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 8 ) selected="selected" @endif value="8">财源镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 9 ) selected="selected" @endif value="9">大路镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 10 ) selected="selected" @endif value="10">太王镇</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 11 ) selected="selected" @endif value="11">麻线乡</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 12 ) selected="selected" @endif value="12">凉水朝鲜族乡</option>
                                <option style="font-size:12px;" @if(old( 'district_id', $item->district_id) == 13 ) selected="selected" @endif value="13">其他</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>正文
                                <small class="text-red">*</small>
                            </label>
                                <textarea class="textarea" placeholder="" name="content"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $item->content }}</textarea>

                        </div>

                        <div class="form-group @if ($errors->has('images.0') || $errors->has('images.1') || $errors->has('images.2')) has-error @endif">
                            <label class="control-label">图片</label>
                            <div>
                                <input data-input="false" data-iconName="glyphicon icon-folder-open-alt" data-size="sm" data-buttonText="请选择" data-buttonName="btn-primary"
                                    class="filestyle" type="file" name="images[]"><br />
                                <input data-input="false" data-iconName="glyphicon icon-folder-open-alt" data-size="sm" data-buttonText="请选择" data-buttonName="btn-primary"
                                    class="filestyle" type="file" name="images[]"><br />
                                <input data-input="false" data-iconName="glyphicon icon-folder-open-alt" data-size="sm" data-buttonText="请选择" data-buttonName="btn-primary"
                                    class="filestyle" type="file" name="images[]"> @if($errors->has('images.0') || $errors->has('images.1') ||
                                $errors->has('images.2'))
                                <p class="text-warning small">上传失败，确认上传的文件为图像且图像小于1M</p> @endif
                                <div class="row">
                                    @foreach ($item->images as $photo)
                                    <div class="col-md-4 text-center" id="photo{{$photo->id}}">
                                        <a target="_blank" href="{{ $photo->file }}" class="thumbnail"><img width="100" src="{{ $photo->file }}" ></a>
                                        <button onclick="deletePhoto({{$photo->id}})" type="button" class="btn btn-default btn-xs">&nbsp;删&nbsp;除&nbsp;</button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>手机号码
                                <small class="text-red">*</small>
                            </label>
                            <input type="text" class="form-control" name="tel" autocomplete="off" placeholder="{{ $item->tel }}"
                                maxlength="80">
                        </div>
                        <div class="form-group">
                            <label>邮箱
                                
                            </label>
                            <input type="email" class="form-control" name="email" autocomplete="off" placeholder="{{ $item->email }}"
                                maxlength="80">
                        </div>
                        <div class="form-group">
                            <label>管理密码
                                <small class="text-red">*</small>
                            </label>
                            <input type="text" class="form-control" name="manage_passwd" autocomplete="off" placeholder="{{ $item->manage_passwd }}"
                                maxlength="80">
                        </div>
                        <div class="form-group">
                            <label>点击次数
                                <small class="text-red">*</small>
                            </label>
                            <input type="text" class="form-control" name="hits" autocomplete="off" placeholder="{{ $item->hits }}"
                                maxlength="80">
                        </div>
                        <div class="form-group">
                            <label>有效时间
                                <small class="text-red">*</small>
                            </label>
                            <input type="text" class="form-control" name="expired_days" autocomplete="off" placeholder="{{ $item->expired_days }}"
                                maxlength="80">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">发布文章</button>

                </div>
            </div>
        </form>
    </div>
@stop

@section('other-js')
    {{-- <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script src="/static/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
        $(function () {
            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();
        });
    </script> --}}



    <script type="text/javascript" src="/static/admin/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/static/admin/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
    <script type="text/javascript" src="/static/admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/static/admin/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    
    <script type="text/javascript">
        function deletePhoto(photoId)
    {
    
    	$.ajax({
           type:'POST',
           url:'/279497165/deletePhoto',
           data:'_token=<?php echo csrf_token() ?>&id=' + photoId,
           success:function(data){
              if (data.static) {
              	$("#photo" + photoId).parent().remove();
              	window.location.reload();
              }
           }
        });
    }
    function loadChild(id, currentId)
    {
    	$.ajax({
           type:'POST',
           url:'/getchilds',
           data:'_token=<?php echo csrf_token() ?>&id=' + id,
    
           success:function(data){
    		$.each(data, function(key, item) {
    			if(item.id == {{$item->category_id}})
    			{
    		        $('#category_id_child').append($("<option selected=\"selected\" style=\"font-size:12px;\"></option>") .attr("value",item.id) .text(item.name)).selectpicker('refresh'); 
    			} else {
    				$('#category_id_child').append($("<option style=\"font-size:12px;\"></option>") .attr("value",item.id) .text(item.name)).selectpicker('refresh'); 
    			}
    		});
           }
        });
    }
    $(document).ready(function(){
    	loadChild($('#category_id').val());
    
    	$('#category_id').change(function () {
    		$('#category_id_child').html('').selectpicker('refresh');
            loadChild($('#category_id').val());
    	});
    
    	// $('#update-bt').click(function () {
    	// 	$('#created_at').val($("#current-time").text());
    	// });
    
    	// $('#ip2area-bt').click(function () {
    	// 	$('#ip2area-bt').prop('disabled', true);
    
    	// 	$.ajax({
    	//        type:'POST',
    	//        url:'/ip2area',
        //   	   beforeSend: function() {
    	//           $("#msg_ip2area").html("<span class=\"small\" id=\"loading\"><i class=\"icon-spinner icon-spin\"></i>&nbsp;加载中......</span>");
    	//        }, 	       
    	//        data:'_token=<?php echo csrf_token() ?>&id={{$item->id}}&ip={{$item->ip}}',
    	//        success:function(data){
    	//        		$("#msg_ip2area").html(data.result);
    	//        		$('#ip2area-bt').prop('disabled', false);
    	//        }
    	//     });
    	// });
    
    	// $('#tel2area-bt').click(function () {
    	// 	$('#tel2area-bt').prop('disabled', true);
    
    	// 	$.ajax({
    	//        type:'POST',
    	//        url:'/tel2area',
        //   	   beforeSend: function() {
    	//           $("#msg_tel2area").html("<span class=\"small\" id=\"loading\"><i class=\"icon-spinner icon-spin\"></i>&nbsp;加载中......</span>");
    	//        }, 	       
    	//        data:'_token=<?php echo csrf_token() ?>&id={{$item->id}}&tel={{$item->tel}}',
    	//        success:function(data){
    	//        		$("#msg_tel2area").html(data.result);
    	//        		$('#tel2area-bt').prop('disabled', false);
    	//        }
    	//     });
    	// });
    	
    	$('.datetime').datetimepicker({
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
    		autoclose: 1,
    		todayHighlight: 1,
    		startView: 2,
    		minView: 2,
    		format: 'yyyy-mm-dd hh:ii:ss',
    		forceParse: 0
        });	
    
    	// $('.category_top_expired').datetimepicker({
        //     language:  'zh-CN',
        //     weekStart: 1,
        //     todayBtn:  1,
    	// 	autoclose: 1,
    	// 	todayHighlight: 1,
    	// 	startView: 2,
    	// 	minView: 2,
    	// 	format: 'yyyy-mm-dd hh:ii:ss',
    	// 	forceParse: 0
        // });
    });
    
    </script>
@endsection

