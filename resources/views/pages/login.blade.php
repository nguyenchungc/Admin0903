@extends('layout.layout')
@section('content')
<div class="card card-container">
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
        {{Session::get('error')}}
    </div>
    @endif
    <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
    <p id="profile-name" class="profile-name-card"></p>
    <form class="form-signin" method="post" action="/admin-login">
        @csrf
        <span id="reauth-email" class="reauth-email"></span>
        <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        
        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="login">Đăng nhập</button>
    </form><!-- /form -->
    <a href="#" class="forgot-password">
        Forgot the password?
    </a>
</div><!-- /card-container -->
@endsection