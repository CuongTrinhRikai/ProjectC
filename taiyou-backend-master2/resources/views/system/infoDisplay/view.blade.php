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
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Check-In')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{ $items->check_in == null ? $items->check_in : japaneseDateTime($items->check_in) }}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px">
                                                {{translate('Check-Out')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{--{{ $items->check_out == null||'N/A' ? '-' : japaneseDateTime($items->check_out) }} --}}

                                                @if($items->check_out == null)
                                                -
                                                @else
                                                {{ japaneseDateTime($items->check_out)}}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Mansion Name')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{$items->mansion->mansion_name ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Contractor Name')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{$items->mansion->contractor->company_name ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                               {{translate('Building Admin ID')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{$items->buildingAdmin->username ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Latitude')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{$items->latitude ?? '-'}}
                                            </div>
                                        </div>

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-2 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Longitude')}} :
                                            </label>
                                            <div class="col-sm-9 word_break">
                                                {{$items->longitude ?? '-'}}
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



