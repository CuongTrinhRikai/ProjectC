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

                                <a class="btn btn-secondary pull-right btn-sm"
                                    href="{{url()->previous()}}">
                                    <i class="fa fa-backward"></i> {{ translate('Back') }}</a>
                            </div>
                        </div>
                    </div><!-- ends page-head -->

                    <div class="content-display clearfix custom-border">
                        <div class="panel panel-default custom-padding">
                            <div class="panel-body">

                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-2 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Mansion ID') }} :
                                    </label>
                                    <div class="col-sm-9" style="word-wrap: break-word;">
                                        {{ $items->mansion_id ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-2 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Mansion Name') }} :
                                    </label>
                                    <div class="col-sm-9" style="word-wrap: break-word;">
                                        {{ $items->mansion_name ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-2 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Mansion Address') }} :
                                    </label>
                                    <div class="col-sm-9" style="word-wrap: break-word;">
                                        {{ $items->address ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-2 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Mansion Phone') }} :
                                    </label>
                                    <div class="col-sm-9" style="word-wrap: break-word;">
                                        {{ $items->mansion_phone ?? '-' }}
                                    </div>
                                </div>

                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-2 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Contractor') }} :
                                    </label>
                                    <div class="col-sm-9" style="word-wrap: break-word;">
                                        {{ $items->contractor->company_name . '' . '(' . $items->contractor->contractorId . ')' ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-2 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Instructor') }} :
                                    </label>
                                    <div class="col-8 list-group d-flex flex-row flex-wrap"
                                        style="word-wrap: break-word;">
                                        @if ($items->mansionGuide->isempty())

                                        <span class="dash" style="margin-left: 16px;">-</td>
                                        @else
                                            @foreach ($items->mansionGuide as $guide)

                                                <li class="list-group-item w-50 list-group-item-action word_break">
                                                    {{ $guide->name . '' . '(' . $guide->employee_number . ')' ?? '-' }}</li>
                                            @endforeach
                                        @endif
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
