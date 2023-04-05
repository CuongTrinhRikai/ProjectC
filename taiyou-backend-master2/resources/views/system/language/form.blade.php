@extends('system.layouts.form')
@section('inputs')
<x-system.form.form-group :input="['label'=>'Country', 'required'=>true]">
    <x-slot name="inputs">
    <x-system.form.input-select :input="['name'=>'country_id','placeholder'=>'Select Country', 'options' => $countriesOptions, 'required'=>true, 'default'=>old('country_id'), 'error'=>$errors->first('country_id')]"/>
    </x-slot>
</x-system.form.form-group>
<x-system.form.form-group :input="['label'=>'Language', 'required'=>true]">
    <x-slot name="inputs">
    <x-system.form.input-select :input="['name'=>'language_code','placeholder'=>'Select Language', 'options' => [], 'required'=>true, 'default'=>old('language_code'), 'error'=>$errors->first('language_code')]"/>
    </x-slot>
</x-system.form.form-group>
<x-system.form.form-group :input="['label'=>'Group', 'required'=>true]">
    <x-slot name="inputs">
    <x-system.form.input-select :input="['name'=>'group','placeholder'=>'Select Group', 'options' => $groups, 'required'=>true, 'default'=>old('group'), 'error'=>$errors->first('group')]"/>
    </x-slot>
</x-system.form.form-group>
@endsection