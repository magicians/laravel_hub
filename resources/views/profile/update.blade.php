@extends('layouts.profile')
@section('infoArea')
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{{action('ProfileController@index',['id'=>$userInfo->id])}}">发表的主题</a></li>
        <li role="presentation"><a href="{{action('ProfileController@replies',['id'=>$userInfo->id])}}">回贴</a></li>

        @if(Auth::Guard('web')->check() && $userInfo->id == Auth::Guard('web')->user()->id)
            <li role="presentation"><a href="{{action('ProfileController@favourites',['id'=>$userInfo->id])}}">收藏</a></li>
            <li role="presentation"><a href="{{ action('ProfileController@showMessages') }}">站内消息
                    @if(Auth::Guard('web')->user()->messages()->where('isread','=','0')->count()>0)
                        <span class="badge">{{ Auth::Guard('web')->user()->messages()->where('isread','=','0')->count() }}</span>
                    @endif
                </a></li>
            <li role="presentation" class="active"><a href="{{ action('ProfileController@showUpdateForm') }}">更新个人资料</a></li>
        @endif
    </ul>
    <div class="panel panel-default navbox">
        <div class="panel-body">
            {!! Form::model($userInfo,['class'=>'form-horizontal']) !!}
                    <!--- Username Field --->
            <div class="form-group">
                {!! Form::label('name', '用户名',array('class'=>'control-label col-md-2')) !!}

                <div class="col-md-10">
                    {!! Form::text('name',null, ['class' => 'form-control','placeholder'=>'用户名']) !!}
                </div>

            </div>
            <!--- Password Field --->
            <div class="form-group">
                {!! Form::label('upassword', '密码',array('class'=>'control-label col-md-2')) !!}
                <div class="col-md-10">
                    {!! Form::password('upassword',['class' => 'form-control','placeholder'=>'密码']) !!}
                    <div class="media-meta">不更改密码请留空</div>
                </div>
            </div>
            <!--- Password Confirmation Field --->
            <div class="form-group">
                {!! Form::label('upassword_confirmation', '验证密码',array('class'=>'control-label col-md-2')) !!}
                <div class="col-md-10">
                    {!! Form::password('upassword_confirmation',['class' => 'form-control','placeholder'=>'验证密码']) !!}
                    <div class="media-meta">不更改密码请留空</div>
                </div>
            </div>
            <!--- Email Field --->
            <div class="form-group">
                {!! Form::label('email', '邮箱',array('class'=>'control-label col-md-2')) !!}
                <div class="col-md-10">
                    {!! Form::email('email',null, ['class' => 'form-control','placeholder'=>'邮箱']) !!}
                </div>
            </div>


            <hr>
            <div class="text-center">
                {!! Form::submit('更 新',['class'=>'btn btn-primary']) !!}
            </div>

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
    @elseif(Session::has('updateUser_success'))
        <div class="alert alert-success alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-check-circle fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('updateUser_success') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>

        </div>
    @endif
@endsection
