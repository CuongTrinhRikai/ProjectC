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
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Contractor Company Name') }} :
                                    </label>
                                    <div class="col-sm-8 word_break">
                                        {{ $items->company_name ?? '-' }}
                                    </div>
                                </div>

                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Contractor Id') }} :
                                    </label>
                                    <div class="col-sm-8 word_break">
                                        {{ $items->contractorId ?? '-' }}
                                    </div>
                                </div>

                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Sales Staff') }} :
                                    </label>
                                    <div class="col-8 list-group d-flex flex-row flex-wrap">
                                        @php
                                            $saleStaffArray = [];
                                        @endphp
                                        @if ($items->contractorGuide->isempty())

                                            {{-- <span class="dash" style="margin-left: 16px;">-</td> --}}
                                            @else
                                                @foreach ($items->contractorGuide as $saleStaff)

                                                    @if ($saleStaff->contact_category_id == 0)
                                                    @php
                                                            array_push($saleStaffArray, $saleStaff->contact_category_id);
                                                        @endphp
                                                        <li
                                                            class="list-group-item w-50 list-group-item-action word_break">
                                                            {{ $saleStaff->name . '' . '(' . $saleStaff->employee_number . ')' ?? '-' }}
                                                        </li>

                                                    @endif
                                                @endforeach
                                        @endif
                                        @if (count($saleStaffArray) == 0)

                                            <span class="dash" style="margin-left: 16px;">-</td>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Sales Affair') }} :
                                    </label>
                                    <div class="col-8 list-group d-flex flex-row flex-wrap">
                                        @php
                                            $saleAffairArray = [];
                                        @endphp
                                        @if ($items->contractorGuide->isempty())

                                            {{-- <span class="dash" style="margin-left: 16px;">-</td> --}}
                                            @else

                                                @foreach ($items->contractorGuide as $saleAffair)

                                                    @if ($saleAffair->contact_category_id == 2)
                                                        @php
                                                            array_push($saleAffairArray, $saleAffair->contact_category_id);
                                                        @endphp

                                                        <li
                                                            class="list-group-item w-50 list-group-item-action word_break">
                                                            {{ $saleAffair->name . '' . '(' . $saleAffair->employee_number . ')' ?? '-' }}
                                                        </li>

                                                    @endif
                                                @endforeach
                                        @endif
                                        @if (count($saleAffairArray) == 0)

                                            <span class="dash" style="margin-left: 16px;">-</td>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                        style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Company General Affair') }} :
                                    </label>
                                    <div class="col-8 list-group d-flex flex-row flex-wrap">
                                        @php
                                        $company_general_affairArray = [];
                                    @endphp
                                        @if ($items->contractorGuide->isempty())

                                            {{-- <span class="dash" style="margin-left: 16px;">-</td> --}}
                                            @else
                                                @foreach ($items->contractorGuide as $company_general_affair)

                                                    @if ($company_general_affair->contact_category_id == 3)
                                                    @php
                                                            array_push($company_general_affairArray, $company_general_affair->contact_category_id);
                                                        @endphp
                                                        <li
                                                            class="list-group-item w-50 list-group-item-action word_break">
                                                            {{ $company_general_affair->name . '' . '(' . $company_general_affair->employee_number . ')' ?? '-' }}
                                                        </li>

                                                    @endif
                                                @endforeach
                                        @endif
                                        @if (count($company_general_affairArray) == 0)

                                            <span class="dash" style="margin-left: 16px;">-</td>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row" id="">
                                    <label for="" class="col-sm-3 col-form-label"
                                           style="font-weight: bold;padding-top: 0px;white-space: nowrap">
                                        {{ translate('Company Name') }} :
                                    </label>
                                    <div class="col-sm-8 word_break">
                                        {{ $name_company ?? '-' }}
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
