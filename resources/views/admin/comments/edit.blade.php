@extends('admin.app')
@section('other-css')

@endsection
@section('content-header')
    <h1>
        内容管理
        <small>文章</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="{{url('/279497165/comment')}}">内容管理</a></li>
        <li class="active">编辑信息</li>
    </ol>
@stop

@section('content')
    <h2 class="page-header">编辑信息</h2>
    <div class="box box-primary">
        <form method="POST" action="/279497165/comment/{{ $item->id }}" accept-charset="utf-8" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            <div class="nav-tabs-custom">
                <div class="tab-content">

                    <div class="tab-pane active">
                        
                        <div class="form-group">
                            <label>正文
                                <small class="text-red">*</small>
                            </label>
                                <textarea class="textarea" placeholder="" name="content"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $item->content }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">发布文章</button>

                </div>
            </div>
        </form>
    </div>
@stop

@section('other-js')

@endsection

