@extends('layouts.profile')
@section('infoArea')
        <!-- Start Sidebar -->
<ul class="nav nav-tabs">
    <li role="presentation"><a href="{{action('ProfileController@index',['id'=>$userInfo->id])}}">发表的主题</a></li>
    <li role="presentation"><a href="{{action('ProfileController@replies',['id'=>$userInfo->id])}}">回贴</a></li>

    @if(Auth::Guard('web')->check() && $userInfo->id == Auth::Guard('web')->user()->id)
        <li role="presentation" class="active"><a href="{{action('ProfileController@favourites',['id'=>$userInfo->id])}}">收藏</a></li>
        <li role="presentation"><a
                    href="{{ action('ProfileController@showMessages') }}">站内消息
                @if(Auth::Guard('web')->user()->messages()->where('isread','=','0')->count()>0)
                    <span class="badge">{{ Auth::Guard('web')->user()->messages()->where('isread','=','0')->count() }}</span>
                @endif
            </a></li>
        <li role="presentation"><a href="{{ action('ProfileController@showUpdateForm') }}">更新个人资料</a></li>
    @endif
</ul>
<!-- End Sidebar -->
<div class="panel panel-default navbox">
    <ul class="list-group">
        @if(count($favourites))
            @foreach($favourites as $favourite)
                <li class="list-group-item paddingleft-20">
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-commenting-o fa-4x"></i>
                        </div>
                        <div class="media-body">
                            <h5>
                                <a href="{{action('PostController@show',['id' => $favourite->id])}}">{{ $favourite->title }}</a>
                            </h5>
                            <p class="media-meta">Posted
                                at {{ $favourite->created_at->diffForHumans() }}</p>
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
    @if(count($favourites))
        {{ $favourites->links() }}
    @endif
</div>
@endsection