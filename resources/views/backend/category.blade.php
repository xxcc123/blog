@extends('backend.master')

@section('title','Blog | Category List')

@section('content-header')
    <section class="content-header">
        <h1>
            Category
            <small>Category List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Category</li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="">
                            <form class='col-md-3' action="{{route('category.search')}}" method="get">
                                {{csrf_field()}}
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Category Name" value="{{$default_search or ''}}"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-lg-2">
                                <a class="btn btn-sm btn-primary" href="{{route('category.create')}}"> New Category </a>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Category Name</th>
                                <th>Created At</th>
                                <th>Operation</th>
                            </tr>
                            @foreach($categorys as $value)
                                <tr>
                                    <td>{{$value['category_name']}}</td>
                                    <td>{{$value['created_at']}}</td>
                                    <td>
                                        {{--<a href="{{route('category.destroy',$value['id'])}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</a>--}}
                                        <form action="{{route('category.destroy',$value['id'])}}" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="delete">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class='fa fa-trash'></i></button>
                                            {{--<input class="btn btn-sm btn-danger" type="submit" name="destroy" value="">--}}
                                        </form>
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
                Count：{{ $categorys->count() }}
            </div>
            <div class="pull-right">
                {{ $categorys->links() }}
            </div>
        </div>
    </section>

@endsection