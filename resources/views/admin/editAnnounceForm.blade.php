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
                    <div class="panel-heading"><i class="fa fa-bullhorn"></i> 编辑公告</div>
                    <div class="panel-body">
                        {!! Form::model($announce,['method'=>'PUT','class'=>'form-horizontal']) !!}
                                <!--- Announcement Field --->
                        <div class="form-group">
                            {!! Form::label('announcement', '公告内容',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::textarea('announcement',null, ['class' => 'form-control ','placeholder'=>'公告内容']) !!}
                            </div>
                        </div>
                        <!--- Show Field --->
                        <div class="form-group">
                            {!! Form::label('show', '是否展示',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('show','0') !!}否
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        {!! Form::radio('show','1') !!}是
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            {!! Form::submit('更 新',['class'=>'btn btn-primary']) !!}
                            <button type="button" role="button" class="btn-danger btn" data-toggle="modal" data-target="#deleteAnnounce">删除此公告</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger margintop-10" role="alert">{{ $errors->first() }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" aria-labelledby="deleteAnnounce" id="deleteAnnounce">
        <div class="modal-dialog modal-sm" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">删除公告</h4>
                </div>
                <div class="modal-body">
                    <p>确认要删除此公告吗?此操作不可逆</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">否</button>
                    <a type="button" class="btn btn-primary" href="{{ action('AdminController@delAnnounce',['id'=> $announce->id]) }}">是</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection