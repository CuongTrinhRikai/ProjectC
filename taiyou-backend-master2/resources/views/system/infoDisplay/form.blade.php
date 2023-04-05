@extends('system.layouts.form')
@section('inputs')

    <div class="form-group row " id="">
        <label for="check_in" class="col-sm-2 col-form-label  ">
            {{translate('Check-In')}}
        </label>
        <div class="col-sm-6">
            <input type="text" class="form-control bootstrap-datetimepicker" value="{{ old('check_in') ?? japaneseDateTime($item->check_in) }}" id="check_in" placeholder="Check-In" name="check_in">
            @error('check_in')
            <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>
            @enderror
        </div>
    </div>

    <div class="form-group row " id="">
        <label for="check_out" class="col-sm-2 col-form-label  ">
            {{translate('Check-Out')}}
        </label>
        <div class="col-sm-6">

            <input type="text" class="form-control bootstrap-datetimepicker1 @error('check_out') is-invalid @enderror" value="{{ $item->check_out == "" ?"":($item->check_out == "N/A" ? "N/A" : japaneseDateTime($item->check_out)) }}" id="check_out" placeholder="{{translate('Check-Out')}}" name="check_out" autocomplete="off" readonly="readonly" style="cursor:pointer; background-color: #FFFFFF">
            @error('check_out')
            <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>
            @enderror
        </div>
    </div>

    <x-system.form.form-group :input="['name' => 'mansion_name', 'label' => 'Mansion Name','default'=> old('mansion_name') ?? $item->mansion->mansion_name ?? old('mansion_name'), 'error' => $errors->first('mansion_name'), 'readonly'=>'true'] " />
    <x-system.form.form-group :input="['name' => 'contractor_name', 'label' => 'Contractor Name','default'=>  old('contractor_name') ?? $item->mansion->contractor->company_name ?? old('contractor_name'), 'error' => $errors->first('contractor_name'), 'readonly'=>'true']" />
    <x-system.form.form-group :input="['name' => 'building_admin_id', 'label' => 'Building Admin ID','default'=>  old('building_admin_id') ?? $item->buildingAdmin->username ?? old('building_admin_id'), 'error' => $errors->first('building_admin_id'), 'readonly'=>'true']" />
    <x-system.form.form-group :input="['name' => 'latitude', 'label' => 'Latitude','default'=> old('latitude') ?? $item->latitude ?? old('latitude'), 'error' => $errors->first('latitude'), 'readonly'=>'true']" />
    <x-system.form.form-group :input="['name' => 'longitude', 'label' => 'Longitude','default'=>  old('longitude') ?? $item->longitude ?? old('longitude'), 'error' => $errors->first('longitude'), 'readonly'=>'true']" />

@endsection

@section('scripts')

    <?php
    $validDate =  strtotime(japaneseDateTime($item->check_in));
    ?>
    <script type="text/javascript">

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }
        $(function () {
            var dateToday = '{{ date('Y-m-d', $validDate) }}';
            var strToDate =new Date(new Date().toLocaleString("en-US", {timeZone: "Asia/Tokyo"}));
            var fecha=  formatDate(strToDate);
            if(dateToday ==fecha)
            {
                var maxDate = strToDate;
            }
            else
            {

                var dates =new Date(dateToday);
                dates.setHours(23);
                dates.setMinutes(59);

                var maxDate = dates;
            }

            $('.bootstrap-datetimepicker').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                autoclose: true,
                useCurrent: false,
                showDropDown: true,
                autoComplete: false,

                locale: {

                    format: 'YYYY-MM-DD HH:mm',
                    cancelLabel:  `{{translate('Cancel')}}`,
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
                minDate: dateToday,
                maxDate: maxDate,

            });
        });
    </script>

    <script type="text/javascript">

        $(function () {

            var  oldDate= "{{  old('check_out') }}";
            if(oldDate == null || oldDate == "")
            {
                var chooseDate = "{{ $item->check_out == "" ?"":($item->check_out == "N/A" ? "N/A" : date('Y-m-d H:i',(strtotime(japaneseDateTime($item->check_out))))) }}";
            }
            else {
                var chooseDate = oldDate;
            }

            var dateToday = '{{ date('Y-m-d', $validDate) }}';
            var strToDate =new Date(new Date().toLocaleString("en-US", {timeZone: "Asia/Tokyo"}));
            var fecha=  formatDate(strToDate);
            if(dateToday ==fecha)
            {
                var maxDate = strToDate;
            }
            else
            {
                var dates =new Date(dateToday);
                dates.setDate(dates.getDate() + 1);
                dates.setHours(3);
                dates.setMinutes(59);

                var maxDate = dates;
            }
            if(chooseDate == null || chooseDate == "")
            {
                $('.bootstrap-datetimepicker1').daterangepicker({
                    autoUpdateInput: false,
                    defaultDate: false,
                    singleDatePicker: true,
                    timePicker: true,
                    timePicker24Hour: true,
                    autoClose: true,
                    useCurrent: false,
                    showDropDown: true,
                    autoComplete: false,
                    clearBtn: true,
                    startDate: maxDate,

                    locale: {
                        format: 'YYYY-MM-DD HH:mm',
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
                    minDate: dateToday,
                    maxDate: maxDate,

                });
                $(".bootstrap-datetimepicker1").on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm'));
                });
            }
            else
            {
                $('.bootstrap-datetimepicker1').daterangepicker({
                    autoUpdateInput: false,
                    defaultDate: false,
                    singleDatePicker: true,
                    timePicker: true,
                    timePicker24Hour: true,
                    autoClose: true,
                    useCurrent: false,
                    showDropDown: true,
                    autoComplete: false,
                    clearBtn: true,
                    //startDate: maxDate,

                    locale: {
                        format: 'YYYY-MM-DD HH:mm',
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
                    minDate: dateToday,
                    maxDate: maxDate,

                });
                $(".bootstrap-datetimepicker1").on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm'));
                });
            }

            $('input[name="check_out"]').val(chooseDate);

        });
        $('input[name="check_out"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>


    <script>
        $(document).ready(function () {
            $('.select2').select2({});

        });
    </script>

@endsection
