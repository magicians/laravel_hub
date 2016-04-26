<nav class="navbar navbar-default" style="min-height: 45px;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">导航栏</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">Fanshub</a>
            <a class="navbar-brand" href="{{url('/shop')}}">粉丝商城</a>
            <a class="navbar-brand" href="{{url('/about')}}">关于</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
            {!! Form::open(['class'=>'navbar-form navbar-left','role'=>'search','url'=>'search','method'=>'get']) !!}
                    <!--- Search Field --->
            <div class="form-group">
                {!! Form::label('keywords', '查找:',array('class'=>'sr-only')) !!}
                <div class='input-group'>
                    {!! Form::text('keywords', null, ['class' => 'form-control','placeholder'=>'请输入关键字...','style'=>'width:300px']) !!}
                    <span class="input-group-btn"><button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button></span>
                </div>
            </div>
            {!! Form::close() !!}

            @if(Auth::Guard('web')->check())
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><span><i
                                        class="fa fa-user"></i></span>&nbsp;&nbsp;{{Auth::Guard('web')->user()->name}}
                            &nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ action('ProfileController@index',['id' => Auth::Guard('web')->user()->id ]) }}"><span><i
                                                class="fa fa-home"></i></span>&nbsp;个人中心</a></li>
                            <li><a href="{{ action('ProfileController@showMessages').'#sentMessage' }}"><span><i class="fa fa-comments-o"></i></span>&nbsp;发消息</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{url('/logout')}}"><span><i class="fa fa-sign-out"></i></span>&nbsp;登出</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::Guard('web')->user()->messages()->where('isread','=','0')->count()>0)
                        <li>
                            <a href="{{ action('ProfileController@showMessages')}}"><i class="fa fa-envelope-o danger-font fa-spin" id="unread"></i>  <span class="badge danger-background">{{ Auth::Guard('web')->user()->messages()->where('isread','=','0')->count() }}</span></a>
                        </li>
                    @endif

                </ul>
            @else
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{url('/register')}}">注册</a></li>
                    <li><a href="{{url('/login')}}">登录</a></li>
                </ul>
            @endif
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
