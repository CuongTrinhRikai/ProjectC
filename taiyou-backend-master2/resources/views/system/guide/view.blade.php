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

                            <a class="btn btn-secondary pull-right btn-sm" href="{{url()->previous()}}">
                                <i
                                        class="fa fa-backward"></i> {{translate('Back')}}</a>
                        </div>
                    </div>
                </div><!-- ends page-head -->

                <div class="content-display clearfix custom-border">
                    <div class="panel panel-default custom-padding">
                        <div class="panel-body">

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px; white-space: nowrap">
                                                {{translate('Contact Guide Category')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                @if (isset($items->contact_category_id))
                                                    {{ $contact_category[$items->contact_category_id] }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px; white-space: nowrap">
                                                {{translate('Contact Guide Name')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->name ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px; white-space: nowrap">
                                                {{translate('Contact Guide Employee Number')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->employee_number ?? '-'}}
                                            </div>
                                        </div>
                                        @if(isset($items->line_id))
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px; white-space: nowrap">
                                                {{translate('Line Id')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->line_id ?? '-'}}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px; white-space: nowrap">
                                                {{translate('Contact Guide Mobile Number')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->mobile_number ?? '-'}}
                                            </div>
                                        </div>
                                        @if(isset($items->email))
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px; white-space: nowrap">
                                                {{translate('Email')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->email ?? '-'}}
                                            </div>
                                        </div>
                                            @endif
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px; white-space: nowrap">
                                                {{translate('Status')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{ $items->status == 1 ? translate('Active') : translate('Inactive')}}
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



