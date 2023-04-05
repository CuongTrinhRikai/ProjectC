@extends('system.layouts.masterGuest')
@section('title')
{{translate('Verify')}}
@endsection
@section('content')
<div class="login-wrapper">
  <div class="login-inner-wrapper">
    <div class="login-sec">
      <h1 style="color:{{getCmsConfig('cms theme color')}}">{{translate('Enter Verification Code.')}}</h1>
      <p>{{'We have sent you a verification code in your email.'}} <br> {{translate('Copy a 6-digit verification code and enter it below.')}}</p>
      @include('system.partials.message')
      <div class="login-form">
        <form method="post" action="{{route('verify.post')}}">
          @csrf
          <div class="form-group login-group">
            <div class="input-group  @error('code')
            has-error
            @enderror">
              <input type="text" name="code" class="form-control" placeholder="{{translate('Please Enter Verification Code.')}}" value="{{old('code')}}">
              <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
            </div>
            @error('code')
            <p class="invalid-text text-danger">{{translate($message)}}</p>
            @enderror
          </div>
          <div class="form-group">
            <button type="submit" class="btn login-btn btn-block" style="background-color:{{getCmsConfig('cms theme color')}}">{{translate('Verify')}}</button>
          </div>
          <div class="form-group">
            <a href="{{route('logout')}}" class="btn login-btn btn-danger btn-block" style="padding-top: 13px;">{{translate('Cancel')}}</a>
          </div>
          <div class="form-group">
            <h4>Didn't get email?</h4>
            <a href="{{route('verify.send.again')}}">{{translate('Send Again')}}</a>
          </div>
        </form>
      </div><!-- ends login-form -->
    </div><!-- ends login-sec -->
  </div>
</div><!-- login-wrapper -->

@endsection