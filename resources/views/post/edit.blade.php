@extends('layouts.index')
@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">修改帖子</div>
                    <div class="panel-body">
                        {!! Form::model($postData,['method'=>'PATCH','url'=>url('/post').'/'.$postData->id]) !!}
                                <!--- Title Field --->
                        <div class="form-group">
                            {!! Form::label('title', '标题:',array('class'=>'sr-only')) !!}
                            {!! Form::text('title',null, ['class' => 'form-control']) !!}
                        </div>

                        <!--- Contents Field --->
                        <div class="form-group">
                            {!! Form::label('contents', '内容:',array('class'=>'sr-only')) !!}
                            {!! Form::textarea('contents',null, ['class' => 'form-control']) !!}
                        </div>

                        <!--- Tags Field --->
                        <div class="form-group">
                            {!! Form::label('tags', 'Tags:',array('class'=>'sr-only')) !!}
                            {!! Form::select('tags[]',$tags,$postData->tags()->lists('tags.id')->toArray(), ['class' => 'form-control','multiple'=>'multiple','id'=>'tags']) !!}
                        </div>

                        {!! Form::submit('修改帖子',['class'=>'btn btn-primary pull-right marginleft-10']) !!}
                        {!! Form::close() !!}
                        <button class="btn btn-danger pull-right" role="button" data-toggle="modal" data-target="#delete_dialog">删除帖子</button>
                    </div>
                </div>
                @if($errors->any())
                <div class="alert alert-warning">{{ $errors->first() }}</div>
                @endif

            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-credit-card"> 赞助商</i>
                    </div>
                    <div class="panel-body"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Validate Delete -->

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="delete_dialog" id="delete_dialog">
        <div class="modal-dialog modal-sm" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">确认操作</div>
                <div class="modal-body">确认要删除这个帖子吗?所有回复也将被删除.</div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">取消</button>
                    <a href="{{ action('PostController@delete',['id'=> $postData->id]) }}" class="btn btn-danger" type="button" role="button">删除</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Validate Delete -->
@endsection
@section('scripts')
    <script>
        $(function () {
            $('#tags').select2({
                language: "zh-CN",
                maximumSelectionLength: 3
            });
        })
    </script>
@endsection