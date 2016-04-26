@extends('layouts.index')

@section('body')
    <div class="container margintop-30">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-pagelines"></i> 发布帖子
                        <span class="pull-right" id="available_characters"></span>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['id'=> 'createForm']) !!}
                                <!--- Title Field --->
                        <div class="form-group">
                            {!! Form::label('title', '标题:',array('class'=>'sr-only')) !!}
                            {!! Form::text('title',null, ['class' => 'form-control','placeholder'=>'输入文章标题']) !!}
                        </div>

                        <!--- Contents Field --->
                        <div class="form-group">
                            {!! Form::label('contents', '内容:',array('class'=>'sr-only')) !!}
                            {!! Form::textarea('contents',null, ['class' => 'form-control','placeholder'=>'请输入文章内容,支持Markdown语法:-)']) !!}
                        </div>

                        <!--- Tag Field --->
                        <div class="form-group form-horizontal row">
                            {!! Form::label('tags', '标签',array('class'=>'control-label col-md-1')) !!}
                            <div class="col-md-11">
                                {!! Form::select('tags[]', $tags,null,['class'=>'form-control','multiple'=>'multiple','id'=>'tags_list']) !!}
                            </div>

                        </div>

                        {!! Form::submit('立即发布',['class'=>'btn btn-primary pull-right marginleft-10']) !!}
                        <button class="btn btn-default pull-right " id="preview" type="button" role="button">预览</button>
                        {!! Form::close() !!}

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-eye"></i> 预览</div>
                    <div class="panel-body">
                        <div><h4 id="discussion_preview_title"></h4></div>
                        <div><span id="discussion_preview_body"></span></div>
                    </div>
                </div>
                @if($errors->any())
                    <div class="alert alert-warning alert-dismissible margintop-30" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        {{$errors->all()[0]}}
                    </div>
                @endif
            </div>


            <!-- Start Sidebar -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-credit-card"></i> 赞助商</div>
                    <ul class="list-group text-center" style="margin-bottom: 20px">

                    </ul>
                </div>
            </div>
            <!-- End Sidebar -->


        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            var available = 15000 - $('#contents').val().length;
            if (available > 0) {
                $('#available_characters').html('还可以输入' + available + '个字');
            } else {
                $('#available_characters').html('已超出最大字数');
            }

            $('#preview').on('click', function () {
                var previewURL = '../post/preview/createDiscussion';
                var data = $('#createForm').serializeArray();
                $.ajax({
                            method: 'POST',
                            url: previewURL,
                            data: data,
                        }
                ).done(function (data) {
                    $('#discussion_preview_body').html(data);
                });
                $('#discussion_preview_title').html($('#title').val());
            });

            $('#contents').on('keyup', function () {
                var available = 15000 - $('#contents').val().length;
                if (available > 0) {
                    $('#available_characters').html('还可以输入' + available + '个字');
                } else {
                    $('#available_characters').html('已超出最大字数');
                }
            });
            $("#tags_list").select2({
                language: "zh-CN"
            });
            $("#tags_list").select2({
                maximumSelectionLength: 3
            });
        })
    </script>
@endsection