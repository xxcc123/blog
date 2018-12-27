@extends('backend.master')

@section('title','Blog | User Detail')

@section('content-header')
    <section class="content-header">
        <h1>
            User
            <small>User Detail</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User</li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">User Detail</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('user_update',$user['id'])}}" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputImg3" class="col-sm-2 control-label">Image</label>

                            <div class="col-sm-6">
                                <img class="img-circle" style="width: 60px;height: 60px;" src="{{asset($user['img'])}}" alt="">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="email" value="{{$user['email']}}" id="inputEmail3" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName3" class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" id="inputName3" value="{{$user['name']}}" placeholder="Name">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{route('user')}}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-info pull-right">Save</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="application/javascript">
        $(function () {
            $('#upload_image').click(function () {
                var file = $('input[type="file"]').val();
                console.log(file);

                {{--$.ajax({--}}
                    {{--url: '{{route('upload.image')}}',--}}
                    {{--type:'post',--}}
                    {{--async: false,--}}
                    {{--data: {file:file},--}}
                    {{--success:function ($mes) {--}}
                        {{----}}
                    {{--}--}}
                {{--});--}}
            });
        });
    </script>
@endsection