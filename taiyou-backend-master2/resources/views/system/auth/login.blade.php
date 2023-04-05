@extends('system.layouts.masterGuest')
@section('content')
<div class="login-wrapper">
  <div class="login-inner-wrapper">
    <div class="login-sec">
      <h1 style="color:{{ getCmsConfig('cms theme color')}}">{{translate('Login')}}</h1>
      @include('system.partials.message')
      <div class="login-form">
        <form method="post" action="{{route('login')}}">
          @csrf
          <div class="form-group login-group  @error('email') has-error @enderror">
            <div class="input-group">
              <input type="text" name="email" class="form-control" placeholder="{{translate("Email/Username")}}" autocomplete="off">
              <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>

            </div>
            @error('email')
            <p class="invalid-text text-danger">{{translate($message)}}</p>
            @enderror
          </div>
          <div class="form-group login-group @error('password') has-error @enderror">
            <div class="input-group">
              <input type="Password" name="password" class="form-control" placeholder="{{translate("Password")}}">
              <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>

            </div>
            @error('password')
            <p class="invalid-text text-danger">{{translate($message)}}</p>
            @enderror
          </div>
          <h2>{{translate('You are current using IP')}} - <strong>{{Request::ip()}}</strong></h2>
          <div class="form-group">
            <button type="submit" class="btn login-btn btn-block" style="background-color:{{getCmsConfig('cms theme color')}}">{{translate('Login')}}</button>
          </div>
          <div class="form-group text-center">
            <a href="{{route('forgot.password')}}">{{translate('Forgot Password ?')}}</a>
          </div>
        </form>
      </div><!-- ends login-form -->
    </div><!-- ends login-sec -->
  </div>
</div><!-- login-wrapper -->
@endsection