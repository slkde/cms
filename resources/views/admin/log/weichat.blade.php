@extends('admin.app') 
@section('content-header')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        访问日志
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/279497165')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">访问日志</li>
    </ol>
</section>
@endsection
 
@section('content')
<section class="content">
        <!-- /.col -->
        <dir class="row">
        <div class="">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">访问日志</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">

              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                  <pre>{{ $logs }}</pre>
                
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->

            <!-- /.box-footer -->

            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
    </div>
        <!-- /.col -->
</section>

@endsection