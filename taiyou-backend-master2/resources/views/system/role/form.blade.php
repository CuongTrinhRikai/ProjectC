@extends('system.layouts.form')
@section('inputs')
<x-system.form.form-group :input="['name'=> 'name', 'label'=>'Role Name', 'required' => 'true', 'default'=> $item->name ?? old('name'), 'error' => $errors->first('name')]" />
<x-system.form.form-group :input="['name'=> 'permissions', 'label'=>'Permissions', 'required' => 'true']">
  <x-slot name="inputs">
    @error('permissions')
    <p class="text-danger">{{translate($message)}}</p>
    @enderror
    @foreach(modules() as $module)
    @if(isset($item))
    @include('system.role.edit')
    @else
    @include('system.role.create')
    @endif
    @endforeach
  </x-slot>
</x-system.form.form-group>
@endsection