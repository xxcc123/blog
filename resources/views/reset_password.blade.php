@extends('master')

@section('heading')
    <header class="intro-header" style="height: 80px;background-color:#636b6f">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="page-heading">
                        <h1></h1>
                        <hr class="small">
                        <span class="subheading"></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
            <p></p>
            <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
            <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
            <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
            <form action="{{route('reset.passwords.post')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="email" value="{{$email}}">
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label>新密码</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" id="email" required data-validation-required-message="Please enter your password.">
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="form-group floating-label-form-group controls">
                        <label>确认密码</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password" id="email" required data-validation-required-message="Please enter your confirm password.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <br>
                <div>
                    <input class="btn btn-primary" type="submit" name="submit" value="确定">
                </div>

            </form>
        </div>
    </div>

@endsection

@section('home-script')
    {{--暂无使用--}}
    <script src="{{asset('js/jquery.min.js')}}"></script>

@endsection