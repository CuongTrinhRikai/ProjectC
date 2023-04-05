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
                                <em class="fa fa-backward"></em> {{translate('Back')}}</a>
                        </div>
                    </div>
                </div><!-- ends page-head -->

                <div class="content-display clearfix custom-border">
                    <div class="panel panel-default custom-padding">
                        <div class="panel-body">

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px">
                                                {{translate('Building Admin ID')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->username ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px">
                                                {{translate('Building Admin Name')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{$items->name ?? '-'}}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px">
                                                {{translate('Contractor')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{ $items->contractor->company_name.''.'('.$items->contractor->contractorId.')' ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px">
                                                {{translate('Mansion')}} :
                                            </label>
                                            <div class="col-8 list-group d-flex flex-row flex-wrap">

                                                    @php
                                                        $mansions=[];
                                                        $mansions = $items->buildingAdminMansion->pluck('mansion_name');

                                                    @endphp
                                                    @foreach ($mansions as $t)
                                                        <li class="list-group-item w-50 list-group-item-action word_break">{{$t ?? '-'}}</li>

                                                    @endforeach


                                            </div>
                                        </div>

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                                {{translate('Business Category')}} :
                                            </label>
                                            <div class="col-8 list-group d-flex flex-row flex-wrap">

                                                    @php
                                                    $businessName =[];
                                                    @endphp
                                                    @foreach($items->business_category as $value)
                                                    @php
                                                        $businessName[] = $business[$value];
                                                    @endphp
                                                    @endforeach

                                                    @foreach ($businessName as $t)
                                                    <li class="list-group-item w-50 list-group-item-action word_break">{{$t ?? '-'}}</li>

                                                    @endforeach


                                            </div>
                                       </div>

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label" style="font-weight: bold;padding-top: 0px">
                                                {{translate('Company name')}} :
                                            </label>
                                            <div class="col-sm-8 word_break">
                                                {{ $items->contractor->company->name }}
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



