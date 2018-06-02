@extends('admin.app')
@section('content-header')
    <h1>
        内容管理
        <small>文章</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li>内容管理</li>
        <li class="active">信息管理</li>
    </ol>
@stop

@section('content')
    <a href="{{url('admin/article/create')}}" class="btn btn-primary margin-bottom"><i class="fa fa-paint-brush" style="margin-right: 6px"></i>撰写新文章</a>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">文章列表</h3>
            <div class="box-tools">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm pull-right" name="s_title"
                               style="width: 150px;" placeholder="搜索文章标题">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered">
                <tbody>
                <!--tr-th start-->
                <thead>
                <tr>
                    <th>操作</th>
                    <th>标题</th>
                    <th>作者</th>
                    <th>电话</th>
                    <th>所属分类</th>
                    <th>发布时间</th>
                    <th>IP</th>
                </tr>
                </thead>
                <!--tr-th end-->

                <tbody>
                    @foreach($data as $article)
                        <tr>
                            <td>
                                <a style="font-size: 16px" href="{{ url('/admin/article/' . $article->id . '/edit') }}"> <i class="fa fa-fw fa-pencil" title="修改"></i></a>
                                <a style="font-size: 16px;color: #dd4b39;" href="#"><i class="fa fa-fw fa-trash-o" title="删除"></i></a>
                            </td>
                            <td class="text-muted">{{ $article->title }}</td>
                            <td class="text-green">{{ $article->linkman }}</td>
                            <td class="text-navy">{{ $article->tel }}</td>
                            <td class="text-navy">{{ $article->category->name }}</td>
                            <td class="text-navy">{{ $article->created_at }}</td>
                            <td class="text-navy">{{ $article->ip }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

