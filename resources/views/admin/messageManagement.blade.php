@extends('layouts.admin')

@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item" href="{{ action('AdminController@home') }}">管理用户</a>
                    <a class="list-group-item active" href="{{ action('AdminController@messageManagement') }}">消息管理</a>
                    <a class="list-group-item" href="{{ action('AdminController@announce') }}">社区公告</a>
                    <a class="list-group-item" href="{{ action('AdminController@tags') }}">管理节点（标签)</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-comments"></i> 群发消息</div>
                    <div class="panel-body">
                        {!! Form::open(['url' => action('AdminController@doSendMessage')]) !!}
                                <!--- Message Field --->
                        <div class="form-group">
                            {!! Form::label('message', '消息:',array('class'=>'sr-only')) !!}
                            {!! Form::textarea('message',null, ['class' => 'form-control','placeholder'=>'群发消息给所有用户']) !!}
                        </div>
                        {!! Form::submit('发送',['class'=>'btn btn-primary form-control']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-cogs"></i> 其它操作</div>
                    <div class="panel-body">
                        <button class="btn btn-default" data-toggle="modal" data-target="#deleteAllMessage">删除所有消息</button>
                        <a class="btn btn-default" data-toggle="modal" data-target="#delUnreadMsg">删除所有未读消息</a>
                        <a class="btn btn-default" data-toggle="modal" data-target="#delReadMsg">删除所有已读消息</a>
                        <a class="btn btn-default" data-toggle="modal" data-target="#delMonthMsg">删除30天以前的消息</a>
                    </div>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger margintop-10" role="alert">{{ $errors->first() }}</div>
                @elseif(Session::has('sendMessage_success'))
                    <div class="alert alert-success margintop-10" role="alert">{{ Session::get('sendMessage_success') }}</div>
                @elseif(Session::has('delAllMsg_success'))
                    <div class="alert alert-success margintop-10" role="alert">{{ Session::get('delAllMsg_success') }}</div>
                @elseif(Session::has('delUnreadMsg_success'))
                    <div class="alert alert-success margintop-10" role="alert">{{ Session::get('delUnreadMsg_success') }}</div>
                @elseif(Session::has('delReadMsg_success'))
                    <div class="alert alert-success margintop-10" role="alert">{{ Session::get('delReadMsg_success') }}</div>
                @elseif(Session::has('delMonthMsg_success'))
                    <div class="alert alert-success margintop-10" role="alert">{{ Session::get('delMonthMsg_success') }}</div>
                @endif


            </div>
        </div>
    </div>

    <!-- Start Delete All Messages -->
    <div class="modal fade" role="dialog" aria-labelledby="deleteAllMessage" id="deleteAllMessage">
        <div class="modal-dialog modal-sm" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">删除所有消息</h4>
                </div>
                <div class="modal-body">
                    <p>确定要删除所有消息吗?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">否</button>
                    <a type="button" class="btn btn-primary" role="button" href="{{ action('AdminController@delAllMsg') }}">是</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Delete All Messages -->
    <!-- Start Delete Unread Messages -->
    <div class="modal fade" role="dialog" aria-labelledby="delUnreadMsg" id="delUnreadMsg">
        <div class="modal-dialog modal-sm" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">删除所有未读消息</h4>
                </div>
                <div class="modal-body">
                    <p>确定要删除所有未读消息吗</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">否</button>
                    <a type="button" class="btn btn-primary" href="{{ action('AdminController@delUnreadMsg') }}">是</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Delete Unread Messages -->
    <!-- Start Delete Read Message -->
    <div class="modal fade" role="dialog" aria-labelledby="delReadMsg" id="delReadMsg">
        <div class="modal-dialog modal-sm" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">删除所有已读消息</h4>
                </div>
                <div class="modal-body">
                    <p>确定要删除所有已读消息吗</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">否</button>
                    <a type="button" class="btn btn-primary" href="{{ action('AdminController@delReadMsg') }}">是</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Delete Read Message -->
    <!-- Start Del Month Message -->
    <div class="modal fade" role="dialog" aria-labelledby="delMonthMsg" id="delMonthMsg">
        <div class="modal-dialog modal-sm" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">删除30天以前的消息</h4>
                </div>
                <div class="modal-body">
                    <p>确定要删除30天以前的消息吗</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">否</button>
                    <a type="button" class="btn btn-primary" href="{{ action('AdminController@delMonthMsg') }}">是</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Del Month Message -->
@endsection