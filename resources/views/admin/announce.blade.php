@extends('layouts.admin')
@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item" href="{{ action('AdminController@home') }}">管理用户</a>
                    <a class="list-group-item" href="{{ action('AdminController@messageManagement') }}">消息管理</a>
                    <a class="list-group-item active" href="{{ action('AdminController@announce') }}">社区公告</a>
                    <a class="list-group-item" href="{{ action('AdminController@tags') }}">管理节点（标签)</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-bullhorn"></i> 发布公告</div>
                    <div class="panel-body">
                        {!! Form::open(['class'=>'form-horizontal']) !!}
                                <!--- Announcement Field --->
                        <div class="form-group">
                            {!! Form::label('announcement', '公告内容',['class'=> 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::textarea('announcement',null, ['class' => 'form-control','placeholder'=>'公告内容']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('show','是否展示',['class'=>'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('show','1') !!}
                                        展示
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('show','0') !!}
                                        不展示
                                    </label>
                                </div>
                            </div>
                        </div>
                        {!! Form::submit('发布公告',['class'=>'btn btn-primary form-control']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="panel panel-default">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th style="width: 40%">公告内容</th>
                            <th>是否展示</th>
                            <th>发布人</th>
                            <th>发布日期</th>
                            <th>最后更新</th>
                            <th></th>
                        </tr>
                        @foreach($announcements as $announcement)
                            <tr>
                                <td>{{ $announcement->announcement }}</td>
                                @if($announcement->show == 0)
                                    <td>否</td>
                                @else
                                    <td>是</td>
                                @endif
                                <td>{{ $announcement->user->name }}</td>
                                <td>{{ $announcement->created_at }}</td>
                                <td>{{ $announcement->updated_at }}</td>
                                <td><a type="button" role="button" class="btn btn-primary btn-sm" href="{{ action('AdminController@editAnnounce',['id'=> $announcement->id]) }}">编辑</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger margintop-10" role="alert">{{ $errors->first() }}</div>
                @elseif(Session::has('addAnnounce_success'))
                    <div class="alert alert-success margintop-10" role="alert">{{ Session::get('addAnnounce_success') }}</div>
                @elseif(Session::has('updateAnnounce_success'))
                    <div class="alert alert-success margintop-10" role="alert">{{ Session::get('updateAnnounce_success') }}</div>
                @elseif(Session::has('delAnnounce_success'))
                    <div class="alert alert-success margintop-10" role="alert">{{ Session::get('delAnnounce_success') }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection