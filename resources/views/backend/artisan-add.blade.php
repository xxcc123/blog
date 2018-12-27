@extends('backend.master')

@section('title','Blog | Article Add')

@section('content-header')
    <section class="content-header">
        <h1>
            Article
            <small>Article Add</small>
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
                    <h3 class="box-title">Publish Artisan</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('artisan_store')}}" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputTitle3" class="col-sm-2 control-label">Title</label>

                            <div class="col-sm-10">
                                <input class="form-control" id="inputTitle3" name="title" placeholder="Title" type="text" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLabel3" class="col-sm-2 control-label">Label</label>

                            <div class="col-sm-10">
                                <input class="form-control" id="inputLabel3" name="label" placeholder="Label" type="text" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputContent3" class="col-sm-2 control-label">Content</label>

                            <div class="col-sm-10">
                                <div id="ueditor" class="edui-default">
                                    @include('vendor/UEditor/head')
                                </div>

                                {{--<textarea id="content" class="form-control" name="content" style="height: 300px">--}}

                                {{--</textarea>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCategory3" class="col-sm-2 control-label">Category：</label>

                            <div class="col-sm-10">
                                @foreach($categorys as $category)
                                    <input type="radio" name="category" value="{{$category['category_name']}}">{{$category['category_name']}}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{route('artisan.index')}}" type="submit" class="btn btn-default"><i class="fa fa-times"></i>Discard</a>
                        <button type="submit" class="btn btn-info pull-right"><i class="fa fa-envelope-o"></i> Release</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </section>
    <script id="ueditor"></script>
    <script>
        var ue=UE.getEditor("ueditor");
        ue.ready(function(){
            //因为Laravel有防csrf防伪造攻击的处理所以加上此行
            ue.execCommand('serverparam','_token','{{ csrf_token() }}');
        });
    </script>
@endsection
@section('after-scripts-end')
<script type="application/javascript">
    $(function () {
        //Add text editor
        $("#compose-textarea").wysihtml5();

        $(".form-group").click(function () {
            alert(11);
        })
    });
</script>
@endsection