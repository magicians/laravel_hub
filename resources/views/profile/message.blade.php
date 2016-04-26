@extends('layouts.profile')
@section('infoArea')
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{{action('ProfileController@index',['id'=>$userInfo->id])}}">发表的主题</a></li>
        <li role="presentation"><a href="{{action('ProfileController@replies',['id'=>$userInfo->id])}}">回贴</a></li>
        @if(Auth::Guard('web')->check() && $userInfo->id == Auth::Guard('web')->user()->id)
            <li role="presentation"><a href="{{action('ProfileController@favourites',['id'=>$userInfo->id])}}">收藏</a></li>
            <li role="presentation" class="active">
                <a href="{{ action('ProfileController@showMessages') }}">站内消息
                    @if(Auth::Guard('web')->user()->messages()->where('isread','=','0')->count()>0)
                        <span class="badge">{{ Auth::Guard('web')->user()->messages()->where('isread','=','0')->count() }}</span>
                    @endif
                </a></li>
            <li role="presentation"><a href="{{ action('ProfileController@showUpdateForm') }}">更新个人资料</a></li>
        @endif
    </ul>
    <div class="panel panel-default navbox">
        <ul class="list-group">
            @if(count($messages))
                @foreach($messages as $message)
                    <li class="list-group-item">
                        <div class="media">
                            <div class="media-left">
                                <a href="{{ action('ProfileController@index',['id'=>$message->from_user_id]) }}">
                                    <img class="media-object img-thumbnail"
                                         src="{{ url($user->findOrfail($message->from_user_id)->avatar) }}"
                                         width="48px">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <a href="{{ action('ProfileController@readMessage',['id'=>$message->id]) }}">
                                        @if(strlen($message->message)>40)
                                            {{ mb_substr($message->message,0,40).'...' }}
                                        @else
                                            {{ $message->message }}
                                        @endif
                                    </a>
                                </h5>
                                <p class="media-meta">received at {{ $message->created_at }}.
                                    From
                                    <a href="{{ action('ProfileController@index',['id'=> $user->findOrfail($message->from_user_id)->id]) }}">{{ $user->findOrfail($message->from_user_id)->name }}</a>
                                    @if($message->isread == 0)
                                        <span class="label label-danger">未读</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <ul class="list-group paddingleft-10 paddingtop-20">
                    <li class="list-group-item">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-info-circle fa-4x"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">暂无数据</h4>
                                <div class="media-meta">NO DATA</div>
                            </div>
                        </div>
                    </li>
                </ul>
            @endif
        </ul>

    </div>
    <div>
        @if(count($messages))
            {{ $messages->links() }}
        @endif
    </div>
    <hr>

    <!-- Start Sent Message -->
    <a name="sentMessage"></a>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-comments-o"></i> 发送消息
        </div>
        <div class="panel-body">
            {!! Form::open([ 'url' => action('ProfileController@sentMessage') ]) !!}
                    <!--- UserName Field --->
            <div class="form-group">
                {!! Form::label('username', '收件人:',array('class'=>'sr-only')) !!}
                {!! Form::text('username',null, ['class' => 'form-control','placeholder'=>'收件人用户名']) !!}
            </div>
            <!--- Message Field --->
            <div class="form-group">
                {!! Form::label('message', 'Message:',array('class'=>'sr-only')) !!}
                {!! Form::textarea('message',null, ['class' => 'form-control','placeholder'=>'请输入消息内容,支持Markdown语法 :-)']) !!}
            </div>
            {!! Form::submit('发送',['class'=>'btn btn-primary pull-right']) !!}
            <div class="clearfix"></div>
            {!! Form::close() !!}
        </div>
    </div>
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-warning fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ $errors->first() }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>

        </div>
    @elseif(Session::has('user_id_not_found'))
        <div class="alert alert-danger alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-warning fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('user_id_not_found') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>

        </div>
    @elseif(Session::has('message_sent'))
        <div class="alert alert-success alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-check-circle fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('message_sent') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>

        </div>
    @elseif(Session::has('delete_success'))
        <div class="alert alert-success alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-check-circle fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('delete_success') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>

        </div>
        @endif
                <!-- End Sent Message -->
@endsection