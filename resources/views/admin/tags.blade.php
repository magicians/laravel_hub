@extends('layouts.admin')

@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item" href="{{ action('AdminController@home') }}">管理用户</a>
                    <a class="list-group-item" href="{{ action('AdminController@messageManagement') }}">管理消息</a>
                    <a class="list-group-item" href="{{ action('AdminController@announce') }}">社区公告</a>
                    <a class="list-group-item active" href="{{ action('AdminController@tags') }}">管理节点（标签)</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-hacker-news"></i> 新建节点（标签）</div>
                    <div class="panel-body">
                        {!! Form::open(['class'=>'form-inline']) !!}
                        <!--- Tagname Field --->
                        <div class="form-group">
                            {!! Form::label('tag_name', 'Tagname:',array('class'=>'sr-only')) !!}
                            {!! Form::text('tag_name',null, ['class' => 'form-control','placeholder'=>'节点名']) !!}
                        </div>
                        <!--- Taggroup Field --->
                        <div class="form-group">
                            {!! Form::label('tag_group', 'Taggroup:',array('class'=>'sr-only')) !!}
                            {!! Form::text('tag_group',null, ['class' => 'form-control','placeholder'=>'所属类别']) !!}
                        </div>
                        {!! Form::submit('添加',['class'=>'btn btn-primary form-control']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>

                <table class="table table-responsive table-striped table-hover">
                    <tr>
                        <th>名称</th>
                        <th>所属类别</th>
                        <th>操作 <span class="media-meta">删除不会有提示,请谨慎操作</span></th>
                    </tr>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->tag_name }}</td>
                            <td>{{ $tag->tag_group }}</td>
                            <td><a class="btn btn-primary btn-sm" type="button" role="button" href="{{ action('AdminController@editTags',['id'=>$tag->id]) }}">编辑</a>
                                <a class="btn btn-danger btn-sm" type="button" role="button" href="{{ action('AdminController@delTags',['id'=>$tag->id]) }}">删除</a></td>
                        </tr>
                    @endforeach
                </table>


            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-warning fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ $errors->first() }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
        </div>
    @elseif(Session::has('addTag_success'))
        <div class="alert alert-success alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-check-circle fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('addTag_success') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
        </div>
    @elseif(Session::has('updateTags_success'))
        <div class="alert alert-success alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-check-circle fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('updateTags_success') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
        </div>
    @elseif(Session::has('delTags_success'))
        <div class="alert alert-success alert-dismissible right-bottom-msg row" role="alert">
            <div class="col-md-1 paddingleft-2"><i class="fa fa-check-circle fa-3x"></i></div>
            <div class="col-md-8 paddingleft-30">{{ Session::get('delTags_success') }}</div>
            <div class="col-md-1 pull-right">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
        </div>
    @endif
@endsection