@extends('layouts.user')
@section('body')

    <div class="container">
            <div class="col-md-2" style="position:absolute;top:0;bottom:0;left:0;right:0;margin:auto;height:240px;">
                {!! Form::open() !!}
                <!--- Username Field --->
                <div class="form-group">
                    {!! Form::label('email', '邮箱:',array('class'=>'sr-only')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                        {!! Form::email('email',null, ['class' => 'form-control','placeholder'=>'请输入邮箱']) !!}
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

                <p class="pull-right marginleft-10">忘记密码?</p>
                <p class="pull-right"><a href="{{url('register')}}">转到注册</a></p>
                {!! Form::submit('登录',['class'=>'btn btn-primary form-control']) !!}
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
    @elseif(Session::has('login_faild'))
        <div class="col-md-3" style="position: fixed;right:0;bottom: 0">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <i class="fa fa-exclamation-triangle fa-3x pull-left"></i>
                <p class="pull-left">{{Session::get('login_faild')}}</p>
                <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div style="clear:both"></div>
            </div>
        </div>
    @endif
@endsection