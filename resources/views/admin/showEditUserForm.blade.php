@extends('layouts.admin')

@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item active" href="{{ action('AdminController@home') }}">管理用户</a>
                    <a class="list-group-item" href="{{ action('AdminController@messageManagement') }}">管理消息</a>
                    <a class="list-group-item" href="{{ action('AdminController@announce') }}">社区公告</a>
                    <a class="list-group-item" href="{{ action('AdminController@tags') }}">管理节点（标签)</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-book"></i> 搜索结果</div>
                    <div class="panel-body">
                        {!! Form::model($userInfo,['url'=>action('AdminController@updateUser'),'method'=> 'put','class'=> 'form-horizontal']) !!}
                        {!! Form::hidden('id') !!}
                                <!--- UserName Field --->
                        <div class="form-group">
                            {!! Form::label('name', '用户名',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('name',null, ['class' => 'form-control','placeholder'=>'用户名']) !!}
                            </div>

                        </div>
                        <!--- Password Field --->
                        <div class="form-group">
                            {!! Form::label('userpassword', '密码',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('userpassword',null, ['class' => 'form-control','placeholder'=>'密码']) !!}
                                <span class="media-meta">不更改密码请留空</span>
                            </div>
                        </div>
                        <!--- Email Field --->
                        <div class="form-group">
                            {!! Form::label('email', '电子邮件',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::email('email',null, ['class' => 'form-control','placeholder'=>'邮件']) !!}
                            </div>
                        </div>

                        <!--- Avatar Field --->
                        <div class="form-group">
                            {!! Form::label('avatar', '头像',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('avatar',null, ['class' => 'form-control','placeholder'=>'头像']) !!}
                            </div>
                        </div>

                        <!--- Status Field --->
                        <div class="form-group">
                            {!! Form::label('status', '状态码',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('status',null, ['class' => 'form-control','placeholder'=>'状态码']) !!}
                                <span class="media-meta">该功能暂未开放,请保留默认值.</span>
                            </div>
                        </div>

                        <!--- Points Field --->
                        <div class="form-group">
                            {!! Form::label('points', '点数',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('points',null, ['class' => 'form-control','placeholder'=>'点数']) !!}
                            </div>
                        </div>

                        <!--- Gold Field --->
                        <div class="form-group">
                            {!! Form::label('gold', '金币',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('gold',null, ['class' => 'form-control','placeholder'=>'金币']) !!}
                            </div>
                        </div>

                        <!--- Admin Field --->
                        <div class="form-group">
                            {!! Form::label('admin', '前台管理员',['class'=> 'control-label col-md-2']) !!}
                            <div class="col-md-10">
                                {!! Form::text('admin',null, ['class' => 'form-control','placeholder'=>'前台管理员']) !!}
                                <span class="media-meta">1为前台管理员,0为普通权限用户</span>
                            </div>
                        </div>
                        {!! Form::submit('提交',['class'=>'btn btn-primary pull-right']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection