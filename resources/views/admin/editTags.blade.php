@extends('layouts.admin')

@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item" href="{{ action('AdminController@home') }}">管理用户</a>
                    <a class="list-group-item" href="{{ action('AdminController@messageManagement') }}">管理消息</a>
                    <a class="list-group-item" href="{{ action('AdminController@announce') }}">社区公告</a>
                    <a class="list-group-item" href="{{ action('AdminController@tags') }}">管理节点（标签)</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-th-list"></i> 编辑节点（标签）列表</div>
                    <div class="panel-body">
                        {!! Form::model($tag,['url'=>action('AdminController@updateTags',['id'=>$tag->id]),'method'=>'put','class'=>'form-horizontal']) !!}
                                <!--- Tagname Field --->
                        <div class="form-group">
                            {!! Form::label('tag_name', '节点名称',array('class'=>'control-label col-md-2')) !!}
                            <div class="col-md-10">
                                {!! Form::text('tag_name',null, ['class' => 'form-control','placeholder'=>'节点名称']) !!}
                            </div>
                        </div>
                        <!--- Taggroup Field --->
                        <div class="form-group">
                            {!! Form::label('tag_group', '所属类别',array('class'=>'control-label col-md-2')) !!}
                            <div class="col-md-10">
                                {!! Form::text('tag_group',null, ['class' => 'form-control','placeholder'=>'所属类别']) !!}
                            </div>
                        </div>
                        {!! Form::submit('更 新',['class'=>'btn btn-primary form-control']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>


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
    @endif

@endsection