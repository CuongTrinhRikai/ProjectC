@extends('system.layouts.masterGuest')
@section('content')
<div class="login-wrapper">
    <div class="login-inner-wrapper">
        <div class="login-sec">
            <h1 style="color:{{getCmsConfig('cms theme color')}}">{{translate('Forgot Password')}}</h1>
            @include('system.partials.message')
            <div class="login-form">
                <form method="post" action="{{route('post.forgot.password')}}">
                    @csrf
                    <div class="form-group login-group @error('email') has-error @enderror">
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" placeholder="{{translate('Email')}}" value="{{old('email')}}">
                            <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
                        </div>
                    </div>
                    @error('email')
                    <p class="invalid-text text-danger">{{translate($message)}}</p>
                    @enderror
                    <div class="form-group">
                        <button type="submit" class="btn login-btn btn-block" style="background-color:{{getCmsConfig('cms theme color')}}">{{translate('Submit')}}</button>
                    </div>
                </form>
            </div><!-- ends login-form -->
        </div><!-- ends login-sec -->
    </div>
</div><!-- login-wrapper -->
@endsection
