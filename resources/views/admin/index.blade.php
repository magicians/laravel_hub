<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理后台</title>

    <!-- Bootstrap -->
    <link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
    {{--<link href="{{url('css/bootstrap-theme.min.css')}}" rel="stylesheet">--}}
    <link href="{{url('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{url('css/css.css')}}" rel="stylesheet">
    <link href="{{url('css/highlight.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background: #eee">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 form-signin">
            {!! Form::open() !!}
                    <!--- Username Field --->
            <h2>管理 后台</h2>
            <div class="form-group">
                {!! Form::label('name', '用户名:',array('class'=>'sr-only')) !!}
                {!! Form::text('name',null, ['class' => 'form-control','placeholder'=>'用户名']) !!}
            </div><hr />
            <!--- Password Field --->
            <div class="form-group">
                {!! Form::label('password', 'Password:',array('class'=>'sr-only')) !!}
                {!! Form::password('password', ['class' => 'form-control','placeholder'=>'密码']) !!}
            </div>
            {!! Form::submit('登录',['class'=>'btn btn-primary form-control']) !!}
            {!! Form::close() !!}
            @if($errors->any())
                <div class="alert alert-danger margintop-30" role="alert">
                    <p>{{ $errors->first() }}</p>
                </div>
            @elseif(Session::has('login_error'))
                <div class="alert alert-danger margintop-30" role="alert">
                    <p>{{ Session::get('login_error') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{url('js/jquery-1.12.0.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{url('js/bootstrap.min.js')}}"></script>
</html>
