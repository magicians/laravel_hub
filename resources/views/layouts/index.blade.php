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
    <link href="{{url('css/highlight.css')}}" rel="stylesheet">
    <link href="{{url('css/select2.min.css')}}" rel="stylesheet">
    <link href="{{url('css/css.css')}}" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
@include('layouts.navbar')

@yield('body')
        <!-- Start Footer -->
<div id="footer" class="container marginbottom-100 margintop-30 media-meta">
    <p>
		{{--<i class="fa fa-heart-o"> Made by Jun & Junorz.com.</i><br>--}}
        {{--<i class="fa fa-code"> Powered by Laravel.</i><br>--}}
        <i class="fa fa-lightbulb-o"> Inspired by v2ex & ruby-china & PHPhub</i>
    </p>

</div>
<!-- End Footer -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{url('js/jquery-1.12.0.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/highlight.js')}}"></script>
<script src="{{url('js/select2.min.js')}}"></script>
<script src="{{url('js/i18n/zh-CN.js')}}"></script>
<script>hljs.initHighlightingOnLoad();</script>
@yield('scripts')
</body>
</html>
