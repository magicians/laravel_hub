@extends('layouts.index')
@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-8">
                <!-- Start Post -->
                <div class="panel panel-default">
                    <div class="
                        @if($discussion->user->admin == 1)
                            progress-bar-warning progress-bar-striped
                        @endif
                            panel-heading">
                        <div class="media">
                            <div class="media-body">
                                <div class="media-heading"><h4>{{$discussion->title}}</h4>
                                </div>
                                @if(count($discussion->comments))
                                    <div class="media-meta">Posted by <a href="{{ url('/user/').'/'.$discussion->user->id }}">{{$discussion->user->name}}</a>. Last commented by <a
                                                href="{{ url('/user/').'/'.$discussion->comments()->latest()->first()->user->id }}">{{ $discussion->comments()->latest()->first()->user->name }}</a>・{{ $discussion->comments()->latest()->first()->created_at->diffForHumans() }}.
                                        @if($discussion->top > 0)
                                            <span class="label label-primary">置顶</span>
                                        @endif
                                        @if($discussion->essential == 1)
                                            <span class="label label-warning">精华</span>
                                        @endif
                                        <div class="nodecorate" style="display: inline">
                                            <a class="media-meta" href="{{ action('PostController@like',['id'=>$discussion->id]) }}"><i class="fa fa-thumbs-up"></i>赞</a> +{{ $discussion->like_count }}&nbsp;&nbsp;
                                            @if(count($isfavourite))
                                                <a class="media-meta" href="{{ action('PostController@favourite',['id'=>$discussion->id]) }}"><i class="fa fa-bookmark-o"></i> 取消收藏</a>
                                            @else
                                                <a class="media-meta" href="{{ action('PostController@favourite',['id'=>$discussion->id]) }}"><i class="fa fa-bookmark-o"></i> 收藏</a>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="media-meta">Posted by <a href="{{ url('/user/').'/'.$discussion->user->id }}">{{$discussion->user->name}}</a>.尚未有回复.
                                        @if($discussion->top > 0)
                                            <span class="label label-primary">置顶</span>
                                        @endif
                                        @if($discussion->essential == 1)
                                            <span class="label label-warning">精华</span>
                                        @endif
                                        <div class="nodecorate" style="display: inline">
                                            <a class="media-meta" href="{{ action('PostController@like',['id'=>$discussion->id]) }}"><i class="fa fa-thumbs-up"></i> 赞</a>+{{ $discussion->like_count }}&nbsp;&nbsp;
                                            @if(count($isfavourite))
                                                <a class="media-meta" href="{{ action('PostController@favourite',['id'=>$discussion->id]) }}"><i class="fa fa-bookmark-o"></i> 取消收藏</a>
                                            @else
                                                <a class="media-meta" href="{{ action('PostController@favourite',['id'=>$discussion->id]) }}"><i class="fa fa-bookmark-o"></i> 收藏</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="media-right">
                                <a href="{{ action('ProfileController@index',['id'=>$discussion->user->id]) }}">
                                    <img class="media-object img-thumbnail" src="{{url($discussion->user->avatar)}}" width="64">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        {!! $makeHtml->makeHtml($discussion->contents) !!}
                        <br>
                        <p class="media-meta">{!! $discussion->update_info !!}</p>
                    </div>
                </div>
                <!-- End Post -->

                <!-- Start Comments -->
                <div id="Comments_Area">
                    <div class="panel panel-default">
                        <div class="panel-heading">共收到 {{ $discussion->comments()->count() }} 条回复</div>

                        <ul class="list-group">
                            @foreach($comments as $comment)
                                <li class="list-group-item">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="{{ action('ProfileController@index',['id'=> $comment->user->id]) }}">
                                                <img class="media-object img-thumbnail" src="{{url($comment->user->avatar)}}" width="64">
                                            </a>
                                        </div>
                                        <div class="media-body nodecorate">
                                            <h5 class="media-heading">
                                                <a href="{{ action('ProfileController@index',['id'=> $comment->user->id]) }}"> {{$comment->user->name}}</a>
                                                <span class="media-meta"> {{ $comment->created_at->diffForHumans() }}・</span><a name="comment{{$comment->id}}" class="media-meta">#{{ $comment->floor }}</a>
                                            </h5>
                                            {!! $makeHtml->makeHtml($comment->comment) !!}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <hr>

                    <!--- Comment Input Field --->
                    @if(Auth::Guard('web')->check())
                        <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-comment"></i> 发表评论</div>
                            <div class="panel-body">
                                {!! Form::open(['url'=> url('/comment')]) !!}
                                {!! Form::hidden('discussion_id',$discussion->id) !!}

                                <div class="form-group">
                                    {!! Form::label('comment', '评论内容:',array('class'=>'sr-only')) !!}
                                    {!! Form::textarea('comment',null, ['class' => 'form-control','placeholder'=>'请输入评论内容']) !!}
                                </div>
                                {!! Form::submit('发表评论',['class'=>'btn btn-primary pull-right marginbottom-30']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>

                    @else
                        <a class="btn btn-block btn-primary marginbottom-30" role="button" href="{{url('/login')}}">登录参与评论</a>
                        @endif
                                <!-- End Comment Input Field -->

                </div>
                <!-- End Comments -->

            </div>

            <!-- Start Sidebar -->
            <div class="col-md-4">
                @if(Auth::check() && Auth::Guard('web')->user()->admin)
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-cogs"></i> 管理员操作</div>
                        <div class="list-group text-center">
                            <a class="list-group-item" href="{{action('PostController@edit',['id'=>$discussion->id])}}" role="button">修改帖子</a>
                            <a class="list-group-item" href="{{action('PostController@setEssential',['id'=>$discussion->id,'method'=> 'set'])}}" role="button">设为精华</a>
                            <a class="list-group-item" href="{{action('PostController@setEssential',['id'=>$discussion->id,'method'=> 'drop'])}}" role="button">取消精华</a>
                            <a class="list-group-item" href="{{action('PostController@setTop',['id'=>$discussion->id,'method'=> 'set'])}}" role="button">设为置顶</a>
                            <a class="list-group-item" href="{{action('PostController@setTop',['id'=>$discussion->id,'method'=> 'drop'])}}" role="button">取消置顶</a>
                        </div>
                    </div>
                @elseif(Auth::check() && Auth::Guard('web')->user()->id == $discussion->user->id)
                    <div class="marginbottom-30">
                        <a class="btn btn-primary btn-block" href="{{action('PostController@edit',['id'=>$discussion->id])}}" role="button">修改帖子</a>
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-clone"></i> 关联帖子</div>
                    <div class="list-group">
                        @if(isset($related_discussions))
                            @foreach($related_discussions as $related_discussion)
                                <a class="list-group-item" href="{{ action('PostController@show',['id'=>$related_discussion->id]) }}">{{ $related_discussion->title }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
            <!-- End Sidebar -->

        </div>
    </div>

    @if(Session::has('setEssential_success'))
        <div class="alert alert-success alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-check-circle fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('setEssential_success') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>
    @elseif(Session::has('setTop_success'))
        <div class="alert alert-success alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-check-circle fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('setTop_success') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>
    @elseif(Session::has('already_like_post'))
        <div class="alert alert-danger alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-close fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('already_like_post') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>
    @endif


@endsection