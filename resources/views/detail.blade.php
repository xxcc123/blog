@extends('master')

@section('heading')
    <header class="intro-header" style="background-image: url('img/bg1.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="site-heading">
                        <h1>{{$artisan['title']}}</h1>
                        <span class="subheading">{{$artisan['label']}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
            <div class="post-preview">
                <p>{!! $artisan['content'] !!}</p>
                <p class="post-meta">发布时间 ：{{$artisan['updated_at']}}</p>
            </div>
            <div class="post-preview">
                <form action="{{route('comment.store')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$artisan['id']}}">
                    <div>
                        <label style="width: 10%;" class='pull-left' for="">评论：</label>
                        <p id="comment" class="post-meta" style="width: 90%">
                            <textarea id="textarea" style="width: 70%" class="post-meta" name="comment" id="comment" cols="55" rows="2">

                        </textarea>
                            <input id="submit" class="btn btn-primary pull-right" style="width: 18.89%;height:83px;" type="submit" name="submit" value="提交">
                        </p>
                    </div>

                </form>
            </div>
            <input type="hidden" name="session" value="{{$session}}">

            <div class="post-preview">
                @foreach($artisan['comments'] as $comment)
                <p style="border-top: 1px solid #c9cccf">

                    <span>
                        <span class='pull-left' for="" style="font-size: 14px;">{{$comment['user']['name']}}:</span>
                        <span style="margin-left: 20px">{{$comment['content']}}</span>
                    </span>
                    <span class="pull-right">{{$comment['created_at']}}</span>
                </p>
                @endforeach
            </div>
        </div>
    </div>
    <script src="{{asset('css/lib/jquery/jquery.js')}}"></script>
    <script type="application/javascript">
        $(function(){

            $('#submit').click(function(){
                var comment = $('#comment').val();
                console.log(comment);
                $.ajax({
                    type:'post',
                    url: "{{route('comment.store')}}",
                    data: {comment:comment},
                    async: false,
                    contentType: "text",
                    success:function (mes) {

                    }
                });
            });
        });
    </script>
@endsection

@section('home-script')
    <script type="application/javascript">
        $(function () {
            $('#comment').click(function () {
                var session = $('input[name="session"]').val();
                console.log(session);
                if (session == '') {
                    $('#login').remove();
                    $(this).parent().parent().append('<div id="login" style="color:red ">'+'请登录后在评论'+'</div>');
                    $('#submit').attr('disabled','disabled');
                }
            });
        });
    </script>
@endsection
