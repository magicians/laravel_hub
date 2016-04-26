@extends('layouts.profile')
@section('infoArea')

    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{{action('ProfileController@index',['id'=>$userInfo->id])}}">发表的主题</a></li>
        <li role="presentation"><a href="{{action('ProfileController@replies',['id'=>$userInfo->id])}}">回贴</a></li>
        <li role="presentation" class="active">
            @if(Auth::Guard('web')->check() && $userInfo->id == Auth::Guard('web')->user()->id)
                <a href="{{ action('ProfileController@showMessages') }}">站内消息
                    @if(Auth::Guard('web')->user()->messages()->where('isread','=','0')->count()>0)
                        <span class="badge">{{ Auth::Guard('web')->user()->messages()->where('isread','=','0')->count() }}</span>
                    @endif
                </a></li>
        <li role="presentation"><a href="{{ action('ProfileController@showUpdateForm') }}">更新个人资料</a></li>
        @endif
    </ul>
    <div class="panel panel-default navbox">
        <div class="panel-body">
            <div class="media">
                <div class="media-left">
                    <a href="{{ action('ProfileController@index',['id'=>$message->from_user_id]) }}">
                        <img class="media-object img-thumbnail"
                             src="{{ url($user->findOrfail($message->from_user_id)->avatar) }}" width="48">
                    </a>
                </div>
                <div class="media-body">
                    <a href="{{ action('ProfileController@deleteMessage',['id'=> $message->id]) }}"
                       class="btn btn-danger btn-sm pull-right" role="button">删除此消息</a>
                    <p class="media-heading">From <a
                                href="{{ action('ProfileController@index',['id'=>$message->from_user_id]) }}">{{ $user->findOrfail($message->from_user_id)->name }}</a>
                    </p>
                    <p class="media-meta">Received at {{ $message->created_at }}</p>


                    <p class="margintop-30">{!! $parser->makeHtml($message->message) !!}</p>
                </div>
            </div>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-comments-o"></i> 回复消息</div>
                <div class="panel-body">
                    {!! Form::open(['url'=> action('ProfileController@replyMessage',['id'=>$message->id])]) !!}
                            <!--- Message Field --->
                    <div class="form-group">
                        {!! Form::label('message', 'Message Title:',array('class'=>'sr-only')) !!}
                        {!! Form::textarea('message',null, ['class' => 'form-control','placeholder'=>'请输入消息内容,支持Markdown语法 :-)']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('message_id',$message->id, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('user_id',$message->from_user_id, ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::submit('回复',['class'=>'btn btn-primary pull-right']) !!}

                    {!! Form::close() !!}
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible margintop-10" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    {{ $errors->first() }}
                </div>
            @endif
        </div>
    </div>
@endsection