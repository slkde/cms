@extends('admin.app')
@push('js')
<script>
    $(document).ready(function(){
        //查询手机归属地
        $(".telarea").click(function(){
            var telarea = $(this);
            $.ajax({ 
                type:'GET', 
                url:'http://tcc.taobao.com/cc/json/mobile_tel_segment.htm', 
                data:{'tel':telarea.attr('tel')},
                dataType:'jsonp', 
                beforeSend: function(){ telarea.html('正在查询手机归属地'); }, 
                success:function(data){ 
                    if(!data.province){
                        telarea.html('归属地：查询失败'); 
                    }else{ 
                        telarea.html('归属地：' + data.province); } 
                }, 
                error:function(){ telarea.html('归属地：查询失败');} 
            });
        }
        // ,function(){
        //     $(this).html($(this).attr('tel'));
        // }
        );
        //审核
        $(".verify").click(function(){
            var verify = $(this);
            var value = verify.parent().attr('aval') == 'N' ? 'Y':'N' ;
            $.post("{{ url('/279497165/article/verify') }}",{'_token':'{{ csrf_token() }}','id':verify.parent().attr('aid'),'is_verify':value},function(data){
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
            $.post("/279497165/article/" + del.parent().attr('aid'),{'_token':'{{ csrf_token() }}','_method':'delete'},function(data){
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
        <li><a href="{{url('/279497165')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li>内容管理</li>
        <li class="active">信息管理</li>
    </ol>
@stop

@section('content')
    {{-- <a href="{{url('admin/article/create')}}" class="btn btn-primary margin-bottom"><i class="fa fa-paint-brush" style="margin-right: 6px"></i>撰写新文章</a> --}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">文章列表</h3>
            <div class="box-tools">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm pull-right" name="search"
                               style="width: 150px;" placeholder="{{ $s or '搜索标题或电话' }}">
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
                    <th>联系人</th>
                    <th>联系电话</th>
                    <th>所属分类</th>
                    <th>发布时间</th>
                    <th>IP</th>
                </tr>
                </thead>
                <!--tr-th end-->

                <tbody>
                    @foreach($data as $article)
                        <tr>
                            <td aid="{{$article->id}}" aval="{{ $article->is_verify }}">
                                <a style="font-size: 16px;color: #dd4b39;" class="del" href="javascrtip:;"><i class="fa fa-fw fa-trash-o" title="删除"></i></a>
                                <a style="font-size: 16px" href="{{ url('/279497165/article/' . $article->id . '/edit') }}"> <i class="fa fa-fw fa-pencil" title="修改"></i></a>
                                <a style="font-size: 16px;{{ $article->is_verify == 'N' ? 'color: #dd4b39;' :'' }}" class="verify" href="javascrtip:;"><i class="fa fa-fw fa-pie-chart" title="审核"></i></a>
                            </td>
                            <td class="text-muted"><a target="_blank" href="/info-{{$article->id}}.html">{{ $article->title }}</a></td>
                            <td class="text-green">{{ $article->linkman }}</td>
                            <td class="text-navy telarea" tel="{{ $article->tel }}">{{ $article->tel }}</td>
                            <td class="text-navy">{{ $article->category->name }}</td>
                            <td class="text-navy">{{ $article->created_at }}</td>
                            <td class="text-navy iparea">{{ $article->ip }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$data->appends(['search'=>$s])->links()}}
        </div>
    </div>
@stop

