@extends('layouts.index')
@section('body')

    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-title font-14">
							<span><i class="fa fa-list"></i></span>&nbsp;&nbsp;帖子列表
                            <a href="{{ action('PostController@index') }}">
								<span class="pull-right"><i class="fa fa-bookmark"></i> 查看所有</span>
							</a>
                        </p>
                    </div>

                    <ul class="list-group">
                        @foreach($discussions as $discussion)
                            <li class="list-group-item">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object img-thumbnail"
                                                 src="{{url($discussion->user->avatar)}}" width="48">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <p class="media-heading">
                                            <a href="{{ action('PostController@show',['id' => $discussion->id]) }}">{{$discussion->title}}</a>
                                        </p>
                                        @if(count($discussion->comments))
                                            <p class="media-meta">Posted by <a
                                                        href="{{url('/user').'/'.$discussion->user->id}}">{{$discussion->user->name}}</a>
                                                .最后发表 <a
                                                        href="{{url('/user').'/'.$discussion->comments()->latest()->first()->user->id}}">{{ $discussion->comments()->latest()->first()->user->name }}</a>
                                                ・{{ $discussion->comments()->latest()->first()->created_at->diffForHumans() }}
                                                @if($discussion->top > 0)
                                                    <span class="label label-primary">置顶</span>
                                                @endif
                                                    <span class="label label-warning">精华</span>
                                                <span class="badge pull-right"
                                                      style="margin-top: -5px;">{{ $discussion->comments()->count() }}</span>
                                            </p>
                                        @else
                                            <p class="media-meta">Posted by <a
                                                        href="{{ action('ProfileController@index',['id'=>$discussion->user->id]) }}">{{$discussion->user->name}}</a>
                                                at {{ $discussion->created_at->diffForHumans() }}. *快抢沙发*
                                                @if($discussion->top > 0)
                                                    <span class="label label-primary">置顶</span>
                                                @endif
                                                    <span class="label label-warning">精华</span>
                                                <span class="badge pull-right" style="margin-top: -5px;">0</span>
                                            </p>

                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="paginate pull-right">
                    {{ $discussions->links() }}
                </div>
                <div class="clearfix"></div>
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-tags"></i> 节点导航</div>
                    <ul class="list-group">
                        @foreach($tags as $group_name => $tag_instance)
                            <li class="list-group-item" style="min-height: 40px;">
                                <div class="col-md-2">{{ $group_name }}</div>
                                <div class="col-md-10">
                                    @foreach($tag_instance as $in_tag)
                                        <span style="margin-right: 15px;"><a href="{{ action('PostController@tags',['name'=>$in_tag->tag_name]) }}">{{ $in_tag->tag_name }}</a></span>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <!-- Sidebar Start -->
            <div class="col-md-4">
                <a class="btn btn-primary btn-block marginbottom-30" role="button"
                   href="{{ action('PostController@create') }}">发表新帖子</a>
                <!-- Attention Start -->
                <div class="panel panel-default" id="announcement">
                    <div class="panel-heading"><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;社区公告</div>
                    <div class="panel-body">
                        @if(isset($announcement))
                            <p>{!! $announcement !!}</p>
                        @else
                            <p>暂无公告</p>
                        @endif
                    </div>
                </div>
                <!-- End Attention -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-title font-14"><span><i class="fa fa-line-chart"></i></span>&nbsp;&nbsp;热门帖子</p>
                    </div>
                    <ul class="list-group">
                        @if(isset($hot))
                            @for($i=0;$i<count($hot);$i++)
                                <li class="list-group-item">

                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <img class="media-object img-thumbnail"
                                                     src="{{ url($discuz->findOrfail($hot[$i]['hotPostId'])->user->avatar) }}"
                                                     width="48">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            @if(strlen($hot[$i]['hotPostTitle'])>50)
                                                <a class="media-heading"
                                                   href="{{ url('/post/'.$hot[$i]['hotPostId']) }}">{{ mb_substr($hot[$i]['hotPostTitle'],0,50).'...' }}</a>
                                            @else
                                                <a class="media-heading"
                                                   href="{{ url('/post/'.$hot[$i]['hotPostId']) }}">{{ $hot[$i]['hotPostTitle'] }}</a>
                                            @endif
                                            <br/>
                                            <div class="media-meta margintop-10">{{ $discuz->findOrfail($hot[$i]['hotPostId'])->user->name }}
                                                ・<span class="label label-danger">热度: {{ $hot[$i]['howHot'] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            @endfor
                        @endif
                    </ul>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-title font-14"><span><i class="fa fa-comments"></i></span>&nbsp;&nbsp;最新评论</p>
                    </div>
                    <ul class="list-group">
                        @foreach($newcomments as $newcomment)
                            <li class="list-group-item">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object img-thumbnail"
                                                 src="{{ url($newcomment->user->avatar) }}" width="48">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            @if(strlen($newcomment->comment)>30)
                                                <a href="{{url('/post').'/'.$newcomment->discussion->id.'#comment'.$newcomment->id}}">{{mb_substr($newcomment->comment,0,30).' ...'}}</a>
                                            @else
                                                <a href="{{url('/post').'/'.$newcomment->discussion->id.'#comment'.$newcomment->id}}">{{$newcomment->comment}}</a>
                                            @endif
                                        </div>
                                        <p class="media-meta">{{ $newcomment->user->name }}
                                            ・{{ $newcomment->created_at->diffForHumans() }}</p>
                                    </div>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-title font-14"><i class="fa fa-heart"></i>&nbsp;&nbsp;收藏夹</p>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item text-center height-115"><img src="{{ url('img/segmentfault.png') }}"
                                                                                alt="segmentfault"">
                        </li>
                        <li class="list-group-item text-center height-115"><img src="{{ url('img/cnodejs.png') }}"
                                                                                alt="cnodejs"></li>
                        <li class="list-group-item text-center height-115"><img src="{{ url('img/laravel.png') }}"
                                                                                alt="laravel" width="250px;"></li>
                    </ul>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-title font-14"><i class="fa fa-hashtag"></i>&nbsp;&nbsp;社区状态</p>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item">社区会员: {{ $users->count() }} 人</li>
                        <li class="list-group-item">主题数: {{ $discuz->count() }} 个</li>
                        <li class="list-group-item">回帖数: {{$comments->count()}} 条</li>
                    </ul>
                </div>

            </div>
        </div>


    </div>

@endsection
