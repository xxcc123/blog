@extends('master')

@section('heading')
    <header class="intro-header" style="background-image: url('/me/img/contact-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="page-heading">
                        <h1>联系我</h1>
                        <hr class="small">
                        <span class="subheading">有问题吗?我有答案(可能).</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
            <p>想和我联系吗?填写下面的表格给我发个信息，我会在24小时内回复你!</p>
            <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
            <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
            <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
            <form action="{{route('contact.email')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>名字</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" id="name" required data-validation-required-message="Please enter your name.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>邮箱地址</label>
                        <input type="email" class="form-control" name="email" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>电话号码</label>
                        <input type="tel" class="form-control" name="phone_number" placeholder="Phone Number" id="phone" required data-validation-required-message="Please enter your phone number.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>消息</label>
                        <textarea rows="5" class="form-control" name="message" placeholder="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <br>
                <div id="success"></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary">发送</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('home-script')
    {{--暂无使用--}}
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script type="application/javascript">
        $('#send').click(function () {
            var name = $('input[name="name"]').val();
            var email = $('input[name="email"]').val();
            var phone_number = $('input[name="phone_number"]').val();
            var message = $('#message').val();
            console.log(name);
            console.log(email);
            console.log(phone_number);
            console.log(message);

            $.ajax({
                type:'post',
                url: "{{route('contact.email')}}",
                data: {name:name, email:email, phone_number:phone_number, message:message},
                async: false,
                success:function (mes) {

                }
            });
        })
    </script>
@endsection