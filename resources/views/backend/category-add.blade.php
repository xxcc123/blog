@extends('backend.master')

@section('title','Blog | Category Add')

@section('content-header')
    <section class="content-header">
        <h1>
            Category
            <small>Category Add</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Category</li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
    <div class="col-lg-11">
        <form action="{{route('category.store')}}" method="post">
            {{csrf_field()}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">New Category</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Category Name</label>
                        <input class="form-control" name="category_name" placeholder="Category Name:">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                    <a href="{{route('category.list')}}" class="btn btn-default"><i class="fa fa-times"></i> Discard</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </form>
    </div>
    </section>
@endsection
