@extends('system.layouts.form')
@section('inputs')
    @if (isset($item))
        {{ Form::hidden('id', $item->id, ['class' => 'form-control']) }}
    @endif


    <x-system.form.form-group-space
        :input="['name' => 'title', 'label' => 'Notification Title','default'=> old('title') ?? $item->title ?? old('title'), 'error' => $errors->first('title'),'label-required'=>'true']" />

    <x-system.form.form-group-space :input="['label' => 'Information Content','label-required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.text-area
                :input="['name'=>'body','label' => 'Information Content','default'=>  old('body') ?? $item->body ?? old('body'), 'error' => $errors->first('body')]" />
        </x-slot>
    </x-system.form.form-group-space>


    <x-system.form.form-group-space
        :input="['name' => 'name_of_registrant', 'label' => ' Name of Registrant ','default'=>  old('name_of_registrant') ?? $item->name_of_registrant ?? old('name_of_registrant'), 'error' => $errors->first('name_of_registrant'),'label-required'=>'true']" />

    {{-- <x-system.form.form-group :input="['label' => 'Flag','required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.radio
                :input="['name' => 'flag','class'=>'col-sm-3 col-form-label ', 'options' => $flag, 'default' => old('flag') ?? $item->flag ?? old('flag'),'id'=>'flag','error' => $errors->first('flag') ?? null]" />
        </x-slot>
    </x-system.form.form-group> --}}

    <x-system.form.form-group-space :input="['label' => 'Flag','label-required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.input-radio
                :input="['name' => 'flag','options' => $flag,'default' => old('flag') ?? $item->flag ?? old('flag'),'error' => $errors->first('flag') ?? null]"/>
        </x-slot>
    </x-system.form.form-group-space>



    <div class="form-group row" id="contractor">
        <label for="contractor_id" class="col-sm-3 col-form-label ">
            {{ translate('Receiver Contractors') }} <span style="color: red">**
        </label>

        <div class="col-sm-6">
            <div @if($errors->has('contractor_id')) class="error-msg" @endif >
                @if($errors->has('contractor_id'))
                <img src="{{asset('images/image.svg')}}">
                @endif
            {{ Form::select('contractor_id[]', $contractors, isset($contractor) ? $contractor : null, ['class' => 'form-control contractor', 'multiple' => 'multiple']) }}
            @error('contractor_id')
                <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{ translate($message) }}</p>
            @enderror
            </div>
        </div>
    </div>
    <div class="form-group row" id="admin">
        <label for="building_admin_id" class="col-sm-3 col-form-label ">
            {{ translate('Receiver Building Admin') }} <span style="color: red">**
        </label>
        <div class="col-sm-6">
            <div @if($errors->has('building_admin_id')) class="error-msg" @endif >
                @if($errors->has('building_admin_id'))
                <img src="{{asset('images/image.svg')}}">
                @endif
            {{ Form::select('building_admin_id[]', $buildingAdmins, isset($selected) ? $selected : null, ['class' => 'form-control admin', 'multiple' => 'multiple']) }}
            @error('building_admin_id')
                <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{ translate($message) }}</p>
            @enderror
            </div>
        </div>
    </div>
    @section('actionButtons')

    <div class="col-sm-3 col-form-label guide ">

    </div>
    <div class="col-sm-6">
        <button type="submit" class="btn btn-primary" id="addVideoButton">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            {{ !isset($item) ? translate('Create') : translate('Update') }}
        </button>
        <a href="{{ url($indexUrl) }}" class="btn btn-secondary">
            <em class="far fa-window-close"></em> {{ translate('Cancel') }}
        </a>

    </div>
@stop
    {{-- @endif --}}

@endsection

@section('notificationtext')
    <div class="notification" style="text-align: right">
        <span style="color: red;">**{{translate('Any one of them is required')}}<span>

    </div>
@endsection


@section('scripts')
    <script>
        $('.admin').select2({
            placeholder: `{{ translate('Select Receiver Building Admin') }}`

        });
        $('.contractor').select2({
            placeholder: `{{ translate('Select Receiver Contractors') }}`
        });

        $('input:radio[name="flag"]').change(function() {
            if ($(this).val() == '1') {
                $('#contractor').hide();
                $('#admin').hide();
                $('.contractor').removeAttr("required", "required");
                $('.admin').removeAttr("required", "required");
            } else {

                $('#contractor').show();
                $('#admin').show();
            }

        });
        var length = $('.is-invalid').length;
        var flag = "{{ old('flag') }}";
        if ((length > 0 && flag == 1) || flag == 1) {
            $('#contractor').hide();
            $('#admin').hide();
        }

        document.getElementById("addVideoButton").onclick = function() {
            this.disabled = true;
            $('#Formid').submit();
            return true;
        }

    </script>


@endsection
