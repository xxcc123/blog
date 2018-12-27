@extends('backend.master')

@section('title','Blog | Article Detail')

@section('content-header')
    <section class="content-header">
        <h1>
            Article
            <small>Article Detail</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Article</li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="col-md-13">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Artisan Detail</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('artisan.update',$artisan['id'])}}" method="post">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputTitle3" class="col-sm-2 control-label">Title</label>

                            <div class="col-sm-10">
                                <input class="form-control" id="inputTitle3" name="title" placeholder="Title" type="text" value="{{$artisan['title']}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLabel3" class="col-sm-2 control-label">Label</label>

                            <div class="col-sm-10">
                                <input class="form-control" id="inputLabel3" name="label" placeholder="Label" type="text" value="{{$artisan['label']}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputContent3" class="col-sm-2 control-label">Content</label>

                            <div class="col-sm-10">
                                {{--<div id="ueditor" class="edui-default">--}}
                                    @include('vendor/UEditor/head')
                                    <!-- 加载编辑器的容器 -->
                                        <script id="container" name="content" type="text/plain" style='width:100%;height:300px;'>
                                            {!! html_entity_decode($artisan->content) !!}
                                        </script>
                                        <!-- 实例化编辑器 -->
                                        <script type="text/javascript">
                                        var ue = UE.getEditor('container');
                                        ue.ready(function(){
                                            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                                        });
                                        </script>
                                {{--</div>--}}

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCategory3" class="col-sm-2 control-label">Category：</label>

                            <div class="col-sm-10">
                                @foreach($categorys as $category)
                                    @if ($category['category_name'] == $artisan['category']['category_name'])
                                        <input type="radio" name="category_id" value="{{$category['id']}}" checked>{{$category['category_name']}}
                                    @else
                                        <input type="radio" name="category_id" value="{{$category['id']}}">{{$category['category_name']}}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{route('artisan.index')}}" class="btn btn-default"><i class="fa fa-times"></i>Discard</a>
                        <button type="submit" class="btn btn-info pull-right"><i class="fa fa-envelope-o"></i> Sign in</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </section>

@endsection