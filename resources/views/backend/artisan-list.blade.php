@extends('backend.master')

@section('title','Blog | Article List')

@section('content-header')
    <section class="content-header">
        <h1>
            Article
            <small>Article List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Article</li>
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
                            <form class='col-md-3' action="{{route('artisan.search')}}" method="get">
                                {{csrf_field()}}
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Title" value="{{$default_search or ''}}"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>

                            <form class="col-md-4" action="{{route('artisan_excel_import')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="input-group">
                                    <input class="pull-left" type="file" name="file" id="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    <input class="pull-right btn btn-sm btn-primary" type="submit" name="submit" value="Import">
                                </div>
                            </form>
                            <div class="col-lg-2">
                                <a class="btn btn-sm btn-primary" href="{{route('artisan_create')}}"> Publish Article </a>
                            </div>
                            <a class="btn btn-sm btn-info" href="{{route('artisan_excel_export')}}">Export</a>
                            <a class="btn btn-sm btn-info" href="{{route('pdf')}}">生成PDF</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Title</th>
                                <th>Label</th>
                                {{--<th>Content</th>--}}
                                <th>State</th>
                                <th>Created At</th>
                                <th>Operation</th>
                            </tr>
                            @foreach($artisans as $value)
                                <tr>
                                    <td>{{$value['title']}}</td>
                                    <td>{{$value['label']}}</td>
{{--                                    <td>{!! mb_substr($value['content'],0,30) !!}...</td>--}}
                                    <td>
                                        @if($value['state'] == 0)
                                            <span class="btn btn-xs btn-info">待审核(check pending)</span>
                                        @elseif($value['state'] == 1)
                                            <span class="btn btn-xs btn-success">发布(Release)</span>
                                        @elseif($value['state'] == 2)
                                            <span class="btn btn-xs btn-primary">草稿(draft)</span>
                                        @elseif($value['state'] == 3)
                                            <span class="btn btn-xs btn-danger">审核未通过(Unapprove)</span>
                                        @endif
                                    </td>
                                    <td>{{$value['created_at']}}</td>
                                    <td>
                                        <a href="{{route('artisan.show',$value['id'])}}" class="btn btn-sm btn-primary"><i class="fa fa-envelope-o"></i> Details</a>
                                        <a href="{{route('artisan.destroy',$value['id'])}}" class="btn btn-sm btn-danger"><i class='fa fa-trash'></i></a>
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
                Count：{{ $artisans->count() }}
            </div>
            <div class="pull-right">
                {{ $artisans->links() }}
            </div>
        </div>
    </section>

@endsection