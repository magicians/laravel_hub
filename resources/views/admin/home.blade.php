@extends('layouts.admin')

@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item active" href="{{ action('AdminController@home') }}">管理用户</a>
                    <a class="list-group-item" href="{{ action('AdminController@messageManagement') }}">消息管理</a>
                    <a class="list-group-item" href="{{ action('AdminController@announce') }}">社区公告</a>
                    <a class="list-group-item" href="{{ action('AdminController@tags') }}">管理节点（标签)</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-search"></i> 搜索条件</div>
                    <div class="panel-body">
                        {!! Form::open(['url'=>action('AdminController@searchUser'),'class'=> 'form-inline']) !!}
                                <!--- UID Field --->
                        <div class="form-group">
                            {!! Form::label('userid', 'UID:',array('class'=>'sr-only')) !!}
                            {!! Form::text('userid',null, ['class' => 'form-control','placeholder'=>'UID']) !!}
                        </div>
                        <!--- Username Field --->
                        <div class="form-group">
                            {!! Form::label('username', '用户名:',array('class'=>'sr-only')) !!}
                            {!! Form::text('username',null, ['class' => 'form-control','placeholder'=>'用户名']) !!}
                        </div>
                        <!--- UserEmail Field --->
                        <div class="form-group">
                            {!! Form::label('useremail', 'UserEmail:',array('class'=>'sr-only')) !!}
                            {!! Form::email('useremail',null, ['class' => 'form-control','placeholder'=>'Email']) !!}
                        </div>
                        {!! Form::submit('搜索',['class'=>'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection