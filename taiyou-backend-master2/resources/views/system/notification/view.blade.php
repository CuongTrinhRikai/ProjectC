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

                                    <h4>{{ translate($title) }}</h4>

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
                            <div class="panel-body" style="padding-right: 85px;">

                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px">
                                        {{ translate('Notification Title') }} :
                                    </label>
                                    <div class="col-sm-9" style="word-wrap: break-word;">
                                        {{ $items->title ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px">
                                        {{ translate('Information Content') }} :
                                    </label>
                                    <div class="col-sm-9" style="word-wrap: break-word;">
                                        {!! $items->body ?? '-' !!}
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px">
                                        {{ translate('Name of Registrant') }} :
                                    </label>
                                    <div class="col-sm-9 word_break">
                                        {{ $items->name_of_registrant ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px">
                                        {{ translate('Flag') }} :
                                    </label>
                                    <div class="col-sm-9">
                                        {{ $items->flag == 0 ? translate('Private') : translate('Public') }}
                                    </div>
                                </div>
                                @if ($items->flag == 0)
                                    {{-- @if ($items->notificationcontractor->count() > 0) --}}
                                    @if (isset($items->notificationcontractor))

                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label"
                                                style="font-weight: bold;padding-top: 0px;padding-right: 21px;">
                                                {{ translate('Receiver Contractors') }} :
                                            </label>
                                            <div class="col-9 list-group d-flex flex-row flex-wrap">
                                                @if ($items->notificationcontractor->isempty())

                                                    <span class="dash" style="margin-left: 16px;">-</td>
                                                    @else
                                                        @foreach ($items->notificationcontractor as $contractor)
                                                            <li
                                                                class="list-group-item w-50 list-group-item-action word_break">
                                                                {{ $contractor->company_name . '' . '(' . $contractor->contractorId . ')' ?? '-' }}
                                                            </li>

                                                        @endforeach
                                                @endif

                                            </div>
                                        </div>
                                    @endif


                                    @if (isset($items->notificationbuildingAdmin))
                                        <div class="form-group row" id="">
                                            <label for="" class="col-sm-3 col-form-label"
                                                style="font-weight: bold;padding-top: 0px">
                                                {{ translate('Receiver Building Admin') }} :
                                            </label>
                                            <div class="col-9 list-group d-flex flex-row flex-wrap">
                                                @php
                                                    $buildings = [];
                                                    $buildings = $items->notificationbuildingAdmin->pluck('name');

                                                @endphp
                                                @if ($items->notificationbuildingAdmin->isempty())

                                                    <span class="dash" style="margin-left: 16px;">-</td>
                                                    @else
                                                        @foreach ($items->notificationbuildingAdmin as $buildingAdmin)

                                                            <li
                                                                class="list-group-item w-50 list-group-item-action word_break">
                                                                {{ $buildingAdmin->name . '' . '(' . $buildingAdmin->username . ')' ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif
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
