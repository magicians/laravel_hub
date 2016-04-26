<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>宣城论坛</title>

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
<body>
@include('layouts.navbar')

<div class="container margintop-30">
    <div class="row">
        <div class="col-md-4">
            <!-- Start User Standard Info -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object img-thumbnail" src="{{ url($userInfo->avatar) }}" width="64">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $userInfo->name }}</h4>
                            <span class="font-color-999">第{{ $userInfo->id }}位用户</span><br>
                            <span class="font-color-999">Since {{ $userInfo->created_at->toDateString() }}</span>
                        </div>
                    </div>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="fa fa-group"><span>&nbsp;&nbsp;
                                @if($userInfo->admin == 1)
                                    <span class="label label-danger">Admin</span>
                                @else
                                    @if($userInfo->points > 1000000)
                                        <span class="label label-warning">VIP</span>
                                    @elseif($userInfo->points > 500000)
                                        <span class="label label-primary">Senior member</span>
                                    @else
                                        <span class="label label-default">Member</span>
                                    @endif
                                @endif
                            </span></i>
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-diamond">&nbsp;&nbsp;
                            <span class="label label-info">{{ $userInfo->gold }}</span><span
                                    class="sm-info"> Golds</span>
                        </i>
                    </li>
                </ul>

            </div>
            <!-- End User Standard Info -->

            <!-- Start User Additional Info -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-asterisk"> 信息汇总</i>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                        主题数： {{ $userInfo->discussions->count() }}
                    </li>
                    <li class="list-group-item">
                        回帖数： {{ $userInfo->comments->count() }}
                    </li>
                </ul>

            </div>
            <!-- End User Additional Info -->

            @yield('otherSideBar')

        </div>
        <div class="col-md-8">
            @yield('infoArea')
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{url('js/jquery-1.12.0.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/highlight.js')}}"></script>
<script>hljs.initHighlightingOnLoad();</script>
@yield('scripts')
</body>
</html>
