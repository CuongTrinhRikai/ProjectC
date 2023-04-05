@extends('system.layouts.form')

@section('inputs')

    @if (isset($item))

        {{ Form::hidden('id', $item->id, ['class' => 'form-control']) }}
    @endif
    <x-system.form.form-group-space :input="[ 'name' => 'contact_category_id', 'label'=> 'Contact Guide Category','label-required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.input-select
                :input="[ 'name' => 'contact_category_id', 'label'=> 'Contact Guide Category', 'default' => old('contact_category_id') ?? $item->contact_category_id ?? old('contact_category_id') , 'options' => $contact,'id'=>'contact' ,'error' => $errors->first('contact_category_id')]" />
        </x-slot>
    </x-system.form.form-group-space>

    <x-system.form.form-group-space
        :input="['name' => 'name','id'=>'name', 'label' => 'Contact Guide Name ','default'=> old('name') ?? $item->name ?? old('name'), 'error' => $errors->first('name'),'label-required'=>'true']" />


    <x-system.form.form-group-space
        :input="['name' => 'employee_number','id'=>'employeeNum', 'label' => 'Contact Guide Employee Number','default'=> old('employee_number') ?? $item->employee_number ?? old('employee_number')  , 'error' => $errors->first('employee_number'),'label-required'=>'true']" />

    <x-system.form.form-group-space
        :input="['name' => 'line_id','id'=>'lineId','class'=>'lineId', 'id' =>'lineId', 'label' => translate('Line Id'),'placeholder'=>'Line ID','default'=>old('line_id') ?? $item->line_id ?? old('line_id')    , 'error' => $errors->first('line_id'),'label-required'=>'true']" />

    <x-system.form.form-group-space
        :input="['name' => 'mobile_number','id'=>'mobileNum','class'=>'mobileNum','id'=>'mobileNum', 'label' => ' Contact Guide Mobile Number','default'=>old('mobile_number') ?? $item->mobile_number ?? old('mobile_number')   , 'error' => $errors->first('mobile_number'),'type'=>'text','min'=>1,'inputmode'=>'numeric','label-required'=>'true']" />

    <x-system.form.form-group-space
        :input="[ 'name' => 'email', 'label'=> 'Email','default' => old('email') ?? $item->email  ?? old('email')  , 'error' => $errors->first('email'),'class'=>'email','label-required'=>'true']" />

    <x-system.form.form-group-space :input="['label' => 'Status', 'label-required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.input-radio :input="['name' => 'status', 'options' => $status ?? '', 'default' => $item->status ?? 1]" />
        </x-slot>
    </x-system.form.form-group-space>

@section('actionButtons')

    <div class="col-sm-3 col-form-label guide ">

    </div>
    <div class="col-sm-6">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            {{ !isset($item) ? translate('Create') : translate('Update') }}
        </button>
        <a href="{{ url($indexUrl) }}" class="btn btn-secondary">
            <em class="far fa-window-close"></em> {{ translate('Cancel') }}
        </a>

    </div>
@stop

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.multiple').select2({
            placeholder: "Select a mansion",
        });
        $('#mobileNum').bind('keyup paste', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

</script>

<script>


    var toggleElements = function() {


        if ($('#contact').val() == 0) {
            $('.lineId').show();
            $('.mobileNum').show();
            $('.email').show();

        }

        if ($('#contact').val() == 1) {
            $('.lineId').show();
            $('.mobileNum').show();
            $('.email').hide();

            // $('.email').removeAttr("required", "required");
            // $('.mobileNum').attr("required", "required");
            // $('.lineId').attr("required", "required");
        }


        if ($('#contact').val() == 2) {

            $('.mobileNum').show();
            $('.email').show();
            $('.lineId').hide();

            // $('.lineId').removeAttr("required", "required");
            // $('.email').Attr("required", "required");
            // $('.mobileNum').attr("required", "required");
        }


        if ($('#contact').val() == 3) {
            $('.mobileNum').show();
            $('.email').show();
            $('.lineId').hide();

            // $('.lineId').removeAttr("required", "required");
            // $('.email').attr("required", "required");
            // $('.mobileNum').attr("required", "required");
        }

    }


    $('#contact').on('change', toggleElements);
    $(document).ready(toggleElements);

</script>
@endsection
