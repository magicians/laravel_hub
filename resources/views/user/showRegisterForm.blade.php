@extends('layouts.user')
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-2" style="position:absolute;top:0;bottom:0;left:0;right:0;margin:auto;height:240px;">
                {!! Form::open() !!}
                        <!--- Name Field --->
                <div class="form-group">
                    {!! Form::label('name', '用户名:',array('class'=>'sr-only')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'请输入用户名']) !!}
                    </div>
                </div>

                <!--- Email Field --->
                <div class="form-group">
                    {!! Form::label('email', 'Email:',array('class'=>'sr-only')) !!}
                    <div class='input-group'>
                        <span class='input-group-addon'><i class="fa fa-envelope-o"></i></span>
                        {!! Form::email('email', null, ['class' => 'form-control','placeholder'=>'请输入电子邮件']) !!}
                    </div>
                </div>

                <!--- Password Field --->
                <div class="form-group">
                    {!! Form::label('password', '密码:',array('class'=>'sr-only')) !!}
                    <div class='input-group'>
                        <span class='input-group-addon'><i class="fa fa-key"></i></span>
                        {!! Form::password('password', ['class' => 'form-control','placeholder'=>'请输入密码']) !!}
                    </div>
                </div>

                <!--- PasswordConfirm Field --->
                <div class="form-group">
                    {!! Form::label('password_confirmation', '确定密码:',array('class'=>'sr-only')) !!}
                    <div class='input-group'>
                        <span class='input-group-addon'><i class="fa fa-unlock"></i></span>
                        {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder'=>'请再输入一次密码']) !!}
                    </div>
                </div>
                <p class="pull-right"><a href="{{url('login')}}">转到登录</a></p>
                {!! Form::submit('马上注册',['class'=>'btn btn-primary form-control']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    @if($errors->any())
    <!--- 右下角显示错误提示 --->
    <div class="col-md-3" style="position: fixed;right:0;bottom: 0">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <i class="fa fa-exclamation-triangle fa-3x pull-left"></i>
            <p class="pull-left">{{$errors->all()[0]}}</p>
            <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <div style="clear:both"></div>
        </div>
    </div>
    @endif

@endsection