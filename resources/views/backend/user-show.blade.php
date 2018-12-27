@extends('backend.master')

@section('title','Blog | User Show')

@section('content-header')
    <section class="content-header">
        <h1>
            User
            <small>User Show</small>
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
            <form class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-6" style="top: 6px;">
                            {{$user['email']}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-6" style="top: 6px;">
                            {{$user['name']}}
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </form>
        </div>
    </div>
    </section>
@endsection