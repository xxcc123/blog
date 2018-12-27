@extends('backend.master')

@section('title','Blog | User List')


@section('content-header')
    <section class="content-header">
        <h1>
            User
            <small>User List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User</li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class=''>
                            <form class="col-md-3" action="{{route('user_search')}}" method="get">
                                {{csrf_field()}}
                                <div class="input-group">
                                    <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Name/Email"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>

                            <form class="col-md-5" action="{{route('user')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <label class="pull-left" for="file">Filename:</label>
                                <input class="pull-left" type="file" name="file" id="file" />
                                <input class="pull-left btn btn-sm btn-primary" type="submit" name="submit" value="Submit" />
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Operation</th>
                            </tr>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user['id']}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>{{$user['created_at']}}</td>
                                <td>
                                    <a href="{{route('user_detail',$user['id'])}}" class="btn btn-sm btn-primary"><i class="fa fa-envelope-o"></i> Details</a>
                                    <a href="{{route('user_destroy',$user['id'])}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <div class="page">
            <div class="pull-left">
                Count：{{ $users->count() }}
            </div>
            <div class="pull-right">
                {{ $users->links() }}
            </div>
        </div>
    </section>

@endsection