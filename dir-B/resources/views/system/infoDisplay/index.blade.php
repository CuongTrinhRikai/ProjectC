@extends('system.layouts.listing-without-create')
@section('header')

    <x-system.search-form :action="$indexUrl">
        <x-slot name="inputs">

            <x-system.form.form-inline-group :input="['name' => 'keyword', 'placeholder' => 'Keyword', 'default' => Request::get('keyword')]"></x-system.form.form-inline-group>
            <div class="col-auto mb-2" id="date">
                <label class="sr-only" for="date"></label>
                <input autocomplete="off" class="bootstrap-datetimepicker form-control"  value="{{Request::get('date')}}" id="date" placeholder="Choose Date" name="date">
                <input type="hidden" name="from" id="from-date" value="{{Request::get('from')}}">
                <input type="hidden" name="to" id="to-date" value="{{Request::get('to')}}">
            </div>
            <div class="col-sm-2">
                <div class="form-group select__2__wrapper" style="margin-top: 8px">

                    <select name="mansion_name" id="mansionName" class='form-control col-sm-auto select2' style="height: 40px ">
                        <option value="">{{translate('Select Mansion Name')}}</option>

                        @foreach ($mansions as  $value)

                            <option value='{{ $value->id }}' @if (Request::get('mansion_name') == $value->id) selected @endif>
                                {{ $value->mansion_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group select__2__wrapper" style="margin-top: 8px">

                    <select name="building_id" id="buildingId" class='form-control col-sm-auto select2'>
                        <option value="">{{translate('Select Building ID')}}</option>

                        @foreach ($buildings as  $value)

                            <option value='{{ $value->id }}' @if (Request::get('building_id') == $value->id) selected @endif>
                                {{ $value->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group select__2__wrapper" style="margin-top: 8px">
                    <select name="contractor_name" id="contractorName" class='form-control col-sm-auto select2' style="height: 40px ">
                        <option value="">{{translate('Select Contractor Name')}}</option>


                        @foreach ($contractors as  $value)
                            <option value='{{ $value->id }}' @if (Request::get('contractor_name') == $value->id) selected @endif>
                                {{ $value->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </x-slot>

    </x-system.search-form>
@endsection
@section('table-heading')
    <tr>
        <th scope="col" style="white-space: nowrap">{{translate('S.N')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Check-In')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Check-Out')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Mansion Name')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Contractor Name')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Building Admin ID')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Latitude')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Longitude')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Business Category')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Action')}}</th>
    </tr>
@endsection
@section('table-data')
    @php $pageIndex = pageIndex($items); @endphp
    @foreach($items as $key=>$item)
        <tr>
            <td>{{SN($pageIndex, $key)}}</td>

            <td>{{ $item->check_in == null ? $item->check_in : japaneseDateTime($item->check_in) }}</td>

            @if($item->check_out == null)
                <td>-</td>
            @else
                <td>{{japaneseDateTime($item->check_out)}}</td>
            @endif
            <td style="white-space: normal;">{{ $item->mansion->mansion_name }}</td>
            <td>{{ $item->mansion->contractor->company_name }}</td>
            <td>{{ Illuminate\Support\Str::limit($item->buildingAdmin->username, 15) }}</td>
            <td>{{ $item->latitude }}</td>
            <td>{{ $item->longitude }}</td>
            <td>{{ array_key_exists($item->business_category, getNameFromCode()) ? getNameFromCode()[$item->business_category] : $item->business_category}}</td>

            <td>
                @include('system.partials.viewButton')
                @include('system.partials.editButton')
                @include('system.partials.deleteButton')
            </td>

        </tr>
    @endforeach
@endsection

@section('scripts')

    <script type="text/javascript">

        $(function () {
            var chooseDate = "{{Request::get('date') ?? ''}}";
            $('.bootstrap-datetimepicker').daterangepicker({
//                singleDatePicker: true,
                autoclose: true,
                useCurrent: true,
                showDropDown: true,
                autoComplete: false,
                clearBtn: true,

                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: `{{translate('Clear')}}`,
                    applyLabel:  `{{translate('Apply')}}`,
                    daysOfWeek: [
                        "日",
                        "月",
                        "火",
                        "水",
                        "木",
                        "金",
                        "土"
                    ],
                    monthNames: [
                        "1月",
                        "2月",
                        "3月",
                        "4月",
                        "5月",
                        "6月",
                        "7月",
                        "8月",
                        "9月",
                        "10月",
                        "11月",
                        "12月"
                    ],
                },

            });

            $('.bootstrap-datetimepicker').on('apply.daterangepicker', function(ev, picker) {
                $('#from-date').val(picker.startDate.format('YYYY-MM-DD'));
                $('#to-date').val(picker.endDate.format('YYYY-MM-DD'));
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('input[name="date"]').val(chooseDate);
            $('input[name="date"]').attr("placeholder",`{{translate('Choose Date')}}`);
        });
        $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


    </script>


    <script>
        $(document).ready(function () {
            $('.select2').select2({});

        });
    </script>

@endsection
