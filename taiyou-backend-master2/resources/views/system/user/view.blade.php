<!DOCTYPE html>
<html lang="ja">

@include('system.layouts.layoutHeader')
<body>
@include('system.partials.header')
<div class="page-wrapper">
    @include('system.partials.sidebar')
    <div class="page-contents clearfix">
        <div class="inner-content-fluid">
            <div class="custom-container-fluid">
                @section('breadcrumb')
                    @include('system.partials.breadcrumb')
                @show
                <div class="page-head clearfix">
                    <div class="row">
                        <div class="col-6">
                            <div class="head-title">

                                <h4 style="white-space: nowrap">{{ translate($title) }}</h4>

                            </div><!-- ends head-title -->

                        </div>
                        <div class="col-6" style="float:right">

                            <a class="btn btn-secondary pull-right btn-sm" href="{{URL::to(PREFIX.'/users')}}">
                                <i
                                        class="fa fa-backward"></i> {{translate('Back')}}</a>
                        </div>
                    </div>
                </div><!-- ends page-head -->

                <div class="content-display clearfix custom-border">
                    <div class="panel panel-default custom-padding">
                        <div class="panel-body">

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Full Name')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{$items->name ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Username')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{$items->username ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Email')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{$items->email ?? '-'}}
                                            </div>
                                        </div>
                                        {{--<div class="form-group row" id="">--}}
                                            {{--<label for="" class="col-sm-2 col-form-label" style="padding-top: 0px">--}}
                                                {{--Image :--}}
                                            {{--</label>--}}
                                            {{--<div class="col-sm-9">--}}
                                                {{--@if(isset($items->image))--}}
                                                {{--<img src="{{asset('uploads/users/'.$items->image)}}" alt="preview image" style="height:170px;width:200px;" >--}}
                                                {{--@else--}}
                                                    {{--<img src="{{asset('images/avatar.png')}}" alt="preview image" style="height:170px;width:200px;" >--}}
                                                    {{--@endif--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Role')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{translate($items->role->name) ?? '-'}}
                                            </div>
                                        </div>

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Company Name')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{translate($items->company->name) ?? '-'}}
                                            </div>
                                        </div>
                        </div>
                    </div><!-- panel -->
                </div><!-- ends content-display -->
            </div>
        </div><!-- ends custom-container-fluid -->
    </div><!-- ends page-contents -->
</div><!-- page-wrapper -->

@include('system.layouts.layoutFooter')
@include('system.layouts.editorScript')
@yield('scripts')
</body>

</html>



