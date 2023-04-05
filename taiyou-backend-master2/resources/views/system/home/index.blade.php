@extends('system.layouts.master')
@section('content')
<div class="page-head clearfix">
    <div class="row">
        <div class="col-9">
            {{-- <div class="head-title">
                <h4>{{translate('Dashboard')}}</h4>
            </div><!-- ends head-title --> --}}
        </div>
    </div>
</div><!-- ends page-head -->
<div class="panel panel-default">
    <div class="panel-body">
        @include('system.partials.message')
        {{-- {{translate('Welcome to your dashboard')}} --}}
        {{--@if(flashMessage('notification'))
  <span>{{ flashMessage('notification') }}</span>
        @endif--}}
    </div>
</div>
@endsection
