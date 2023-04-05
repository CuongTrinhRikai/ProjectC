@extends('system.layouts.form')
@section('inputs')
    <x-system.form.form-group
        :input="['name' => 'mansion_id', 'label' => 'Mansion ID','default'=> old('mansion_id') ?? $item->mansion_id ?? old('mansion_id'), 'error' => $errors->first('mansion_id'),'label-required'=>'true']" />

    <x-system.form.form-group
        :input="['name' => 'mansion_name', 'label' => 'Mansion Name','default'=>  old('mansion_name') ?? $item->mansion_name ?? old('mansion_name'), 'error' => $errors->first('mansion_name'),'label-required'=>'true']" />

    <x-system.form.form-group
        :input="['name' => 'address','label' => ' Mansion Address','default'=> old('address') ?? $item->address ?? old('address'), 'error' => $errors->first('address'),'label-required'=>'true']" />

    <x-system.form.form-group
        :input="['name' => 'mansion_phone','id'=>'mansionNum','label' => ' Mansion Phone','default'=>old('mansion_phone') ?? $item->mansion_phone ?? old('mansion_phone'), 'error' => $errors->first('mansion_phone'), 'type' =>'text','min'=>1,'inputmode'=>'numeric']" />

    <x-system.form.form-group :input="[ 'name' => 'contractor_id', 'label'=> ' Contractor','label-required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.input-select
                :input="[ 'name' => 'contractor_id', 'label'=> 'Contractor ID', 'default' => old('contractor_id') ?? $item->contractor_id ?? old('contractor_id') , 'options' => $contractors, 'placeholder' => 'Select Contractor', 'error' => $errors->first('contractor_id')]" />
        </x-slot>
    </x-system.form.form-group>

    <div class="form-group row" id="">
        <label for="instructor_id" class="col-sm-2 col-form-label ">
            {{ translate('Instructor') }}
        </label>
        <div class="col-sm-6">
            {{ Form::select('instructor_id[]', $instructor, isset($selected) ? $selected : null, ['class' => 'form-control multiple', 'multiple' => 'multiple']) }}
        </div>
    </div>

    <x-system.form.form-group
        :input="['name' => 'created_by','hidden'=> 'true', 'label' => ' created_by', 'error' => $errors->first('created_by')]" />
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.multiple').select2({
                placeholder: `{{ translate('Select Instructor') }}`
            });
        });
        $('#mansionNum').bind('keyup paste', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

    </script>
@endsection
