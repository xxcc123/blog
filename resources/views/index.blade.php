@extends('master')


@section('heading')
    <header class="intro-header" style="background-image: url('img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="site-heading">
                        <h1>Dawn Blog</h1>
                        <span class="subheading">This is Dawn personal blog</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
            @forelse($artisans as $artisan)
                <div class="post-preview">
                    <a href="{{route('show',base64_encode($artisan['id']))}}">
                        <h2 class="post-title">
                            {{$artisan['title']}}
                        </h2>
                        <h3 class="post-subtitle">
                            {!! substr($artisan["content"],0,200) !!}
                        </h3>
                    </a>
                    <p class="post-meta">发布时间 ：{{$artisan['updated_at']}}</p>
                    <p class="post-meta">
                        <span>
                        @if (count($artisan['comments']) > 0)
                            <i class="fa fa-comment fa-icon-sm"></i>{{count($artisan['comments'])}}条评论
                        @else
                            暂无评论
                        @endif
                        </span>
                        <span class="pull-right">
                            所属分类：{{$artisan['category']['category_name'] or '-'}}
                        </span>
                        <span class="pull-right" style="margin-right: 10%">
                            阅读数：{{$artisan['read_num'] or '-'}}
                        </span>
                    </p>
                </div>
                <hr>
            @empty
                <div class="post-preview">
                    暂无分类文章
                </div>
            @endforelse
            <!-- Pager -->
            <div class="clearfix">
                <div class="float-right">{{ $artisans->links()  }}</div>
            </div>
        </div>
    </div>


@endsection