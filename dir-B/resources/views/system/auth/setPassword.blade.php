@extends('system.layouts.masterGuest')
@section('content')
@php $routename = Route::current()->getName();@endphp
<div class="login-wrapper">
    <div class="login-inner-wrapper">
        <div class="login-sec">
            @if($routename == "change.password")
            <h4 style="color:{{getCmsConfig('cms theme color')}}">{{translate($title)}}</h4>
            @else
            <h1 style="color:{{getCmsConfig('cms theme color')}}">{{translate($title)}}</h1>
            @endif
            @include('system.partials.message')
            <div class="login-form">
                <form method="post" action="{{url(PREFIX.'/set-password')}}">
                    @csrf
                    <input type="hidden" name="token" value="{{$token}}">
                    @if($routename == "change.password")
                    <input type="hidden" name="email" value="{{$email}}">
                    @else
                    <div class="form-group login-group @error('email') has-error @enderror">
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" placeholder="Username" value="{{$email}}" readonly>
                            <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
                        </div>
                        @error('email')
                        <p class="invalid-text text-danger">{{translate($message)}}</p>
                        @enderror
                    </div>
                    @endif
                    <div class="form-group login-group @error('password') has-error @enderror">
                        <div class="input-group">
                            <input type="Password" name="password" class="form-control" placeholder="{{translate('Password')}}">
                            <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                        </div>
                        @error('password')
                        <p class="invalid-text text-danger">{{translate($message)}}</p>
                        @enderror
                    </div>
                    <div class="form-group login-group @error('password_confirmation') has-error @enderror">
                        <div class="input-group">
                            <input type="Password" name="password_confirmation" class="form-control" placeholder="{{translate('Confirm Password')}}">
                            <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                        </div>
                        @error('password_confirmation')
                        <p class="invalid-text text-danger">{{translate($message)}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn login-btn btn-block" style="background-color: {{getCmsConfig('cms theme color')}}">{{ isset($buttonText) ? translate($buttonText) : translate($title) }}</button>
                    </div>
                    @if($routename == "change.password")
                    <div class="form-group">
                        <a href="{{route('logout')}}" class="btn login-btn btn-danger btn-block" style="padding-top: 13px;">{{translate('Cancel')}}</a>
                    </div>
                    @endif
                </form>
            </div><!-- ends login-form -->
        </div><!-- ends login-sec -->
    </div>
</div><!-- login-wrapper -->
@endsection