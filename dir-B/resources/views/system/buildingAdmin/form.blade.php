@extends('system.layouts.form')
@section('inputs')
    @if(isset($item))
        {{ Form::hidden('id',$item->id,['class'=>'form-control']) }}
    @endif
    <x-system.form.form-group-space :input="['name' => 'username', 'label' => 'Building Admin ID','default'=> old('username') ?? $item->username ?? old('username'), 'error' => $errors->first('username'),'label-required'=>'true']" />
    <x-system.form.form-group-space :input="['name' => 'name', 'label' => 'Building Admin Name','default'=>  old('name') ?? $item->name ?? old('name'), 'error' => $errors->first('name'),'label-required'=>'true']" />
    <x-system.form.form-group-space :input="[ 'name' => 'contractor_id', 'label'=> 'Contractor','label-required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.input-select :input="[ 'name' => 'contractor_id', 'label'=> 'Contractor','default' => old('contractor_id') ?? $item->contractor_id ?? old('contractor_id') , 'options' => $contractors, 'placeholder' => 'Select a Contractor', 'error' => $errors->first('contractor_id')]" />
        </x-slot>
    </x-system.form.form-group-space>
    <div class="form-group row" id="">
        <label for="mansion_id" class="col-sm-3 col-form-label ">
            {{translate('Mansion')}} <span style="color: red">*</span>
        </label>
        <div class="col-sm-6">
            <div @if($errors->has('mansion_id')) class="error-msg" @endif>
                @if($errors->has('mansion_id'))
                    <img src="{{asset('images/image.svg')}}">
                @endif
                {{ Form::select('mansion_id[]',$mansions,isset($selectedmansion)? $selectedmansion: null,['class'=>'form-control multiple', 'multiple' => 'multiple']) }}
                @error('mansion_id')
                <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group row" id="">
        <label for="business_category" class="col-sm-3 col-form-label ">
            {{translate('Business Category')}} <span style="color: red">*</span>
        </label>
        <div class="col-sm-6">
            <div @if($errors->has('business_category')) class="error-msg" @endif>
                @if($errors->has('business_category'))
                    <img src="{{asset('images/image.svg')}}">
                @endif
                {{ Form::select('business_category[]',$business,isset($selectedbusiness)? $selectedbusiness : null,['class'=>'form-control multiple-business', 'multiple' => 'multiple']) }}
                @error('business_category')
                <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>
                @enderror
            </div>
        </div>
    </div>

    @if(!isset($item))
    <x-system.form.form-group-space :input="[ 'name' => 'password', 'label'=> 'Password','label-required'=>true, 'type' => 'password', 'default' => old('password'), 'error' => $errors->first('password')]" />
    <x-system.form.form-group-space :input="[ 'name' => 'password_confirmation', 'label'=> 'Confirm Password','label-required'=>true, 'type' => 'password', 'default' => old('password_confirmation'), 'error' => $errors->first('password_confirmation')]" />
    @endif
    @section('actionButtons')
        <div class="offset-sm-2 col-sm-10 guide" style="margin-left: 25%">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> {{ !isset($item) ? translate('Create') : translate('Update')}}
            </button>
            <a href="{{url($indexUrl)}}" class="btn btn-secondary">
                <em class="far fa-window-close"></em> {{ translate('Cancel') }}
            </a>
        </div>
    @stop
@endsection

@section('scripts')
    <script>

        $(document).ready(function () {
            $('.multiple').select2({placeholder: `{{translate('select mansion')}}`});
            $('.multiple-business').select2({placeholder: `{{translate('select business category')}}`});
        });
    </script>
@endsection

