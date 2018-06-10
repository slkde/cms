@extends('admin.app')
@push('js')
<script>
    $(document).ready(function(){
        //审核
        $(".verify").click(function(){
            var verify = $(this);
            var value = verify.parent().attr('aval') == 'N' ? 'Y':'N' ;
            $.post("{{ url('/admin/comment/verify') }}",{'_token':'{{ csrf_token() }}','id':verify.parent().attr('aid'),'is_verify':value},function(data){
                if(data.static){
                    if(value == 'Y'){
                        verify.parent().attr({'aval':value});
                        verify.attr({'style':'font-size: 16px;color: ;'});
                        verify.children().attr({'title':'已审核'});
                    }else{
                        verify.parent().attr({'aval':value});
                        verify.attr({'style':'font-size: 16px;color: #dd4b39;'});
                        verify.children().attr({'title':'未审核'});
                    }
                }
            });
        });
        //删除
        $('.del').click(function(){
            var del = $(this);
            $.post("/admin/comment/" + del.parent().attr('aid'),{'_token':'{{ csrf_token() }}','_method':'delete'},function(data){
                if(data.static){
                    del.parent().parent().remove();
                }
            });
        });
        
    });

</script>

@endpush
@section('content-header')
    <h1>
        内容管理
        <small>文章</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li>评论管理</li>
        <li class="active">文章</li>
    </ol>
@stop

@section('content')
    {{-- <a href="{{url('admin/comment/create')}}" class="btn btn-primary margin-bottom"><i class="fa fa-paint-brush" style="margin-right: 6px"></i>撰写新文章</a> --}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">文章列表</h3>
            <div class="box-tools">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm pull-right" name="search"
                               style="width: 150px;" placeholder="{{ $s or '搜索内容' }}">
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
                    <th>评论信息</th>
                    <th>评论内容</th>
                    <th>发布时间</th>
                </tr>
                </thead>
                <!--tr-th end-->

                <tbody>
                @foreach($data as $comment)
                <tr>
                    <td aid="{{$comment->id}}" aval="{{ $comment->is_verify }}">
                        <a style="font-size: 16px;color: #dd4b39;" class="del" href="javascrtip:;"><i class="fa fa-fw fa-trash-o" title="删除"></i></a>
                        <a style="font-size: 16px" href="{{ url('/admin/comment/' . $comment->id . '/edit') }}"><i class="fa fa-fw fa-pencil" title="修改"></i></a>
                        <a style="font-size: 16px;{{ $comment->is_verify == 'N' ? 'color: #dd4b39;' :'' }}" class="verify" href="javascrtip:;"><i class="fa fa-fw fa-pie-chart" title="审核"></i></a>
                    </td>
                    <td class="text-muted"><a target="_blank" href="/info-{{$comment->article_id}}.html">{{ $comment->article->title or  $comment->article_id}}</a></td>
                    <td class="text-green">{{ $comment->content }}</td>
                    <td class="text-navy">{{ $comment->created_at }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{$data->appends(['search'=>$s])->links()}}
        </div>
    </div>
@stop

