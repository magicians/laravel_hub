@extends('layouts.index')
@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-search"></i> 搜索结果 - 关键字: {{ $keywords }}</div>
                    <ul class="list-group">
                        @foreach($discussions as $discussion)
                            <li class="list-group-item">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="{{ action('ProfileController@index',['id'=>$discussion->user->id]) }}">
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
                                                @if($discussion->essential == 1)
                                                    <span class="label label-warning">精华</span>
                                                @endif
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
                                                @if($discussion->essential == 1)
                                                    <span class="label label-warning">精华</span>
                                                @endif
                                                <span class="badge pull-right" style="margin-top: -5px;">0</span>
                                            </p>

                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{ $discussions->appends(['keywords'=>$keywords])->links() }}
            </div>
        </div>
    </div>
@endsection