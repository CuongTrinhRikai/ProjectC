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
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Manual ID')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->manual_id ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Manual Name')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->name ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Mansion')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->mansions->mansion_name ?? '-'}}
                                            </div>
                                        </div>

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Manual Type')}} :
                                            </label>
                                            <div class="col-sm-8">
                                                {{$items->manual_type == 1 ? translate('Pdf') : translate('Video')}}
                                            </div>
                                        </div>

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('File Name')}} :
                                            </label>
                                            <div class="col-sm-8" style="word-wrap: break-word;">
                                                <a href="{{$url}}" target="_blank">{{$items->filename ?? '-'}}</a>

                                            </div>
                                        </div>

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Status')}} :
                                            </label>
                                            <div class="col-sm-8">
                                                {{$items->flag == 1 ? translate('Publish') : translate('UnPublish')}}
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



