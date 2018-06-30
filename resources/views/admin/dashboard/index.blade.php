@extends('admin.app')
@push('js')
<script type="text/javascript">
    $(document).ready(function(){
	$("#make-sitemap").click(function(){
		$.ajax({
           type:'POST',
           url:'/279497165/sitemap',
           data:'_token=<?php echo csrf_token() ?>',
    			beforeSend: function() {
            $("#msg").html("");
    				$("#sitemap").html("doing......");
    			},           
           success:function(data){
           		if(data)
           		{
           		$("#sitemap").html("生成Sitemap");
                $("#msg").html("<div class=\"alert alert-success\" role=\"alert\"><strong>提示!</strong> <a target='_blank' href='http://www.ja168.net/sitemap.xml'>查看sitemap</a>.</div>");
           		}
           }
        });
	});

  $("#clear-log").click(function(){
    $.ajax({
           type:'POST',
           url:'/279497165/clearlog',
           data:'_token=<?php echo csrf_token() ?>',
            beforeSend: function() {
              $("#msg").html("");
              $("#log").html("doing......");
            },           
           success:function(data){
              if(data)
              {
                $("#log").html("清空日志");
                $("#msg").html("<div class=\"alert alert-success\" role=\"alert\"><strong>提示!</strong> 日志清除成功.</div>");
              }
           }
        });
  });
  $("#clear-cache").click(function(){
    $.ajax({
           type:'POST',
           url:'/279497165/clearcache',
           data:'_token=<?php echo csrf_token() ?>',
            beforeSend: function() {
              $("#msg").html("");
              $("#cache").html("doing......");
            },           
           success:function(data){
              if(data)
              {
                $("#cache").html("清空缓存");
                $("#msg").html("<div class=\"alert alert-success\" role=\"alert\"><strong>提示!</strong> 缓存清除成功.</div>");
              }
           }
        });
  });
});
</script>
@endpush
@section('content-header')
    <section class="content-header">
        <h1>
            管理台
            <small>控制面板</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/279497165')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">控制面板</li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            @foreach($collects as $collect)
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box {{$collect['bck']}}" style="color: #fff">
                        <div class="inner">
                            <h3>{{$collect['count']}}<sup style="font-size: 20px">{{$collect['sup']}}</sup></h3>

                            <p>{{$collect['title']}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion {{$collect['icon']}}"></i>
                        </div>
                        <a href="{{url($collect['url'])}}" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endforeach
        </div>


        
        <div class="row">
            <section class="col-lg-7 connectedSortable">
                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-envelope"></i>

                        <h3 class="box-title">发送邮件</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="#" method="post">
                            <div class="form-group">
                                <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" placeholder="Subject">
                            </div>
                            <div>
                                <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer clearfix">
                        <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                            <i class="fa fa-arrow-circle-right"></i></button>
                    </div>
                </div>
            </section>

            <section class="col-md-3">
                    <!-- Application buttons -->
                    <div class="box">
                        <div class="box-header">
                        <h3 class="box-title">功能</h3>
                        </div>
                        <div class="box-body">
                        {{-- <p>Add the classes <code>.btn.btn-app</code> to an <code>&lt;a></code> tag to achieve the following:</p> --}}
                        <a class="btn btn-app" id="make-sitemap">
                            {{-- <span class="badge bg-green">300</span> --}}
                            <i class="fa fa-barcode"></i> <span id="sitemap">生成sitemap</span>
                        </a>
                        <a class="btn btn-app" id="clear-log">
                            {{-- <span class="badge bg-purple">891</span> --}}
                            <i class="fa fa-users"></i> <span id="log">清空日志</span>
                        </a>
                        <a class="btn btn-app" id="clear-cache">
                            {{-- <span class="badge bg-red">67</span> --}}
                            <i class="fa fa-inbox"></i> <span id="cache">清空缓存</span>
                        </a>
                        <a class="btn btn-app" href="{{ url('279497165/article?search=N') }}">
                            {{-- <span class="badge bg-red">67</span> --}}
                            <i class="fa fa-inbox"></i> <span>全部未审核信息</span>
                        </a>
                        <a class="btn btn-app" href="{{ url('279497165/comment?search=N') }}">
                            {{-- <span class="badge bg-red">67</span> --}}
                            <i class="fa fa-inbox"></i> <span>全部未审核评论</span>
                        </a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
            </section>

        </div>
    </section>
@endsection
