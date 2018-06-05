@extends('home.layouts.master')

@section('title', $item->title . ' - 集安信息网')

@section('content')

@push('css')
<link rel="stylesheet" href="/static/home/css/detail.css">
@endpush

@push('js')
<script type="text/javascript">
$(document).ready(function(){
  document.oncontextmenu=function(e){return false;}
  $('[data-toggle="popover"]').popover()
  // 验证码切换
  $("#captchaImage").click(function(){
    this.src='/captcha?d='+Math.random();
  });

  // $.ajax({
  //          type:'POST',
  //          url:'/hits',
  //          beforeSend: function() {
  //               $("#hits").html("<span class=\"small\" id=\"loading\"><i class=\"icon-spinner icon-spin\"></i></span>");
  //          },           
  //          data:'_token=<?php echo csrf_token() ?>&id={{ $item->id }}',
  //          success:function(hits){
  //             $("#hits").html(hits);
  //          }
  //     });   

  //手机号码归属地跨域请求
  $.ajax({
        type:'GET',
        url:'http://tcc.taobao.com/cc/json/mobile_tel_segment.htm',
        data:{'tel':$("#telarea").attr('tel')},
        dataType:'jsonp',
        beforeSend: function(){
          $("#telarea").html('正在查询手机归属地'); 
        },
        success:function(data){
          if(!data.province){
            $("#telarea").html('电话归属地：查询失败');
          }else{
            $("#telarea").html('电话归属地：' + data.province);
          }
          
        },
        error:function(){
          $("#telarea").html('电话归属地：查询失败');
        }
  });
  // 跨域请求失败
  // $.ajax({ 
  //   type:'GET', 
  //   url:'http://ip.taobao.com/service/getIpInfo.php', 
  //   data:{'ip':'175.23.143.0'},
  //   dataType:'jsonp', 
  //   crossDomain: true,
  //   beforeSend: function(){ $(".iparea").html('正在查询IP地址归属地'); }, 
  //   success:function(data){ 
  //     console.log(data);
  //     // if(!data.data.city){
  //     //   $(".iparea").html('IP地址归属地：查询失败'); 
  //     // }else{ 
  //     //   $("#telarea").html('IP地址归属地：' + data.province); } 
  //     }, 
  //   error:function(){ 
  //     console.log();
  //     $(".iparea").html('IP地址归属地：查询失败');
  //   } 
  // });

  
  $('.iparea').each(function(){
    $.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' + $('.iparea').attr('ip'), function(){ 
      if(remote_ip_info.city){
        $('.iparea').html('所属地：' + remote_ip_info.country + remote_ip_info.city);
      }else{
        $('.iparea').html('所属地：' + remote_ip_info.country);
      }
    });
    // alert(this);
    
  });

  // $.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=218.192.3.42', function(){
  //   alert(remote_ip_info.city);
  // });

});

</script>
@endpush

<ol class="breadcrumb small">
  您的位置：<li><a href="/">首页</a></li>{!! $breadcrumb !!}
</ol>

<div class="row">
    <div  class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            @if ($item->expireDays == '已经过期')
            <del><h3 class="text-center">{{ $item->title }}</h3></del>
            @else
            <h3 class="text-center">{{ $item->title }}</h3>
            @endif
            
            <p class="text-center small">
            @if($item->isMobile == 'YES')
              <div class="text-muted pull-left">
                编号：{{$item->id}}
                <i class="icon-time"></i> {{ date('Y-m-d', strtotime( $item->created_at)) }}
              </div>&nbsp;
              <div class="pull-right">          
                  <i class="icon-eye-open"></i> <span id="hits">{{ $item->hits }}</span>人次
              </div>
            @else
              <i class="icon-time"></i> 发布时间：{{ date('Y-m-d', strtotime( $item->created_at)) }}&nbsp;&nbsp;&nbsp;
              <i class="icon-time"></i> 有效时间：{{ $item->expireDays }}&nbsp;&nbsp;&nbsp;
              <i class="icon-eye-open"></i> 查看次数：<span id="hits">{{ $item->hits }}</span>人次
            @endif

            </p>
          </div>
          <div class="panel-body">
              <div class="lead">
              @if ($item->expireDays != '已经过期')
              <ul class="list-inline text-center">
              @foreach ($item->images() as $photo)                
              <li><a target="_blank" href="{{ $photo->file }}"><img class="img-rounded" width="120" src="{{ $photo->file }}" ></a></li>
              @endforeach
              </ul>
              @endif
              {!! nl2br($item->content) !!}
              </div>
              <p class="small text-warning text-right">友情提示：提高警惕，谨防诈骗！</p>
              <hr />
              <div class="row">
                <div class="col-md-6">
                            @if (strtotime ('+' . $item->expired_days . ' day', strtotime($item->created_at)) < time())
                              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <strong>该信息已经过期，联系方式已经被隐藏。</strong>
                              </div>
                            @else
                            <div class="panel panel-default">
                              <div class="panel-heading small"><i class="icon-caret-right"></i><strong>联系方式</strong></div>
                              <div class="panel-body">
                                    <p>
                                    @if ($item->linkman)
                                      <i class="icon-user"></i> 称呼：{{ $item->linkman }}  &nbsp;
                                      @endif
                                      <span class="text-muted small">{{ preg_replace('/(\d+)\.(\d+)\.(\d+)\.(\d+)/', "$1.$2.$3.*", $item->ip) }}</span>&nbsp;&nbsp;
                                      <span class="small iparea"  ip="{{ preg_replace('/(\d+)\.(\d+)\.(\d+)\.(\d+)/', "$1.$2.$3.0", $item->ip) }}"></span>
                                    </p>
                                    <p>
                                      <i class="icon-phone"></i> 电话：{{ $item->tel }}&nbsp;&nbsp;
                                      
                                      <span class="small" id="telarea" tel="{{ $item->tel }}" style="color:green">电话归属地：</span>
                                      
                                    </p>
                                    <p><i class="icon-building"></i> 区域：{{ $item->category->name }}</p>
                                    @if ($item->isMobile == 'YES')<a href="tel:{{ $item->tel }}" class="btn btn-primary btn-block" role="button" ><i class="icon-pencil"></i> 点击拔打电话</a>@endif
                                    <br />
                              </div>
                            </div>
                            @endif
                </div>
                <div class="col-md-6">
                        <div class="panel panel-default">
                          <div class="panel-heading small"><i class="icon-caret-right"></i><strong>管理信息</strong></div>
                          <div class="panel-body">
                                @if (Session::has("auth$item->id"))
                                <center>
                                <a href="{{ url('/post'. '/' . $item->id .'/edit') }}"  class="btn btn-default btn-sm" role="button">&nbsp;修&nbsp;改&nbsp;信&nbsp;息</a>

                                <a class="btn btn-default btn-sm" role="button" class="text-top small" tabindex="0" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" data-content="信息过期后会自动失效，无需手动删除。">&nbsp;删&nbsp;除&nbsp;信&nbsp;息</a>
                                </center>
                                @else
                                <form class="form-inline" action="/article/auth" method="post">
                                  <div class="form-group">
                                    <label class="sr-only">&nbsp;</label>
                                    <p class="form-control-static small">管理密码：</p>
                                  </div>
                                  <div class="form-group @if (Session::has('msgAuth')) has-error  @endif">
                                    <label for="passwd" class="sr-only">Password</label>
                                    <input type="text" class="form-control" id="passwd" name="password">
                                    <input type="hidden" name="id" value="{{ $item->id }}">                   
                                  </div>
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <button type="submit" class="btn btn-primary btn-sm">修改/删除</button>
                                  @if (Session::has('msgAuth'))
                                     <span class="text-warning small">{{ Session::get('msgAuth') }}</span>
                                  @endif
                                </form>
                                @endif
                          </div>
                        </div>
                </div>
              </div>
              @if ($item->expireDays != '已经过期' || !$item->comments->isEmpty())
              <div class="panel panel-default">
                <div class="panel-heading small"><i class="icon-caret-right"></i><strong>网友咨询</strong></div>
                <div class="panel-body">
                        @if (Session::has('message'))
                           <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        <div class="list-group small">
                          @forelse ($item->comments->where('is_verify','Y') as $index => $comment)
                              <div class="panel panel-info">
                                <div class="panel-heading">
                                  <div class="pull-left ip">{{ preg_replace('/(\d+)\.(\d+)\.(\d+)\.(\d+)/', "$1.$2.$3.0", $comment->ip) }}</div>&nbsp;&nbsp;
                                    <span class="hidden-xs"></span>
                                    {{ $comment->created_at }}&nbsp;
                                  <div class="pull-right">          
                                      <strong>{{ $index+1 }}</strong>楼
                                  </div>
                                </div>
                                <div class="panel-body">
                                    {{ $comment->content }}
                                </div>
                              </div>
                          @empty
                              <p>暂无留言</p>
                          @endforelse
                        </div>
                        @if ($item->expireDays != '已经过期')
                            <form class="small" role="form" action="/comment" method="post">
                              <div class="form-group @if($errors->has('content')) has-error  @endif" id="content-form-group">
                                <textarea class="form-control" rows="3" id="content" name="content">{{ old('content') }}</textarea>
                                <strong><p id="msgContent" class="text-warning small">@if($errors->has('content')){{ $errors->first('content') }}@endif</p></strong>
                                <span class="text-right help-block glyphicon glyphicon-hand-right">请遵守互联网法律法规，严禁造谣、诽谤、谩骂。</span>
                              </div>
                              <div class="form-group @if($errors->has('captcha')) has-error  @endif" id="captcha-form-group">
                                <label style="width: 100px;" for="exampleInputPassword2" >验证码：</label>
                                <input style="width: 160px;" type="text" class="form-control " id="captcha" name="captcha" autocomplete="off" maxlength="4">
                                <strong><p id="msgCaptcha" class="text-warning small">@if($errors->has('captcha')){{ $errors->first('captcha') }}@endif</p></strong>
                                <img id="captchaImage" src="{!! captcha_src() !!}">
                              </div>
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="article_id" value="{{ $item->id }}">
                              <button type="submit" id="saveComment" class="btn btn-primary btn-sm">咨询留言</button>
                            </form>
                        @endif                        
                </div>
              </div>
              @endif
          </div>
        </div>
    </div>
<!--     <div class="col-md-3 hidden-xs">
        AD
    </div> -->
</div>

@push('custom')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">您确定要删除该条信息吗？</h4>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">否</button>
        <button type="button" class="btn btn-primary btn-sm">是</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="report" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="report">您为何要举报该条信息？</h4>
      </div>
      <div class="modal-body small">
        
          <form class="form-inline" method="get" action="/search/">
            <center>
                <div id="searchInfoByTelForm" class="form-group">
                      <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> 虚假信息
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> 重复信息
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3"> 栏目错误
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3"> 电话冒用
                      </label>
                </div>             
                <p />
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary btn-sm">确认</button>
      </div>
            </center>
          </form>
          <script type="text/javascript">
              $(document).ready(function(){
                  $("#searchInfoByTel").click(function(){
                        var tel = $("#tel").val();
                        if ( (! /^[0-9]+\-?\d+$/.test(tel)) || (7 > tel.length || tel.length > 11) ) {
                            $("#msgSearch").html("<center><strong  class=\"text-warning\">电话号码输入错误</strong></center>");
                            $("#searchInfoByTelForm").addClass('has-error');
                            return false;
                        }
                        window.location.href = '/search/' + tel;
                  });
              });
          </script>

      </div>
    </div>
  </div>
</div>

@endpush


@endsection