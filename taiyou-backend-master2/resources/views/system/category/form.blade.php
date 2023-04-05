@extends('system.layouts.form')
@section('inputs')
<x-system.form.form-group :input="['name' => 'name','required'=>'true', 'label' => 'Category Name','default'=> $item->name ?? old('name'), 'error' => $errors->first('name')]" />
<x-system.form.form-group :input="['name' => 'attributes', 'required'=>'true', 'label' => 'Category Attribute','default'=> $item->attributes ?? old('attributes'), 'error' => $errors->first('attributes')]" />
<x-system.form.form-group :input="['label' => 'Category Description']">
    <x-slot name="inputs">
    <x-system.form.text-area :input="['name'=>'description', 'label' => 'Description', 'editor' => true, 'error' => $errors->first('description')]" />
    </x-slot>
</x-system.form.form-group>
<x-system.form.form-group :input="['label' => 'Status']">
    <x-slot name="inputs">
        <x-system.form.input-radio :input="['name' => 'status', 'options' => $status, 'default' => $item->status ?? 1]" />
    </x-slot>
</x-system.form.form-group>
@endsection