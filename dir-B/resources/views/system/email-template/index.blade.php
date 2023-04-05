@extends('system.layouts.listing')
@section('create')
@show
@section('header')
<x-system.search-form :action="url($indexUrl)">
    <x-slot name="inputs">
        <x-system.form.form-inline-group :input="['name' => 'keyword', 'label' => 'Search keyword', 'default' => Request::get('keyword')]" />
    </x-slot>
</x-system.search-form>
@endsection

@section('table-heading')
<tr>
    <th scope="col">{{translate('S.N')}}</th>
    <th scope="col">{{translate('Title')}}</th>
    <th scope="col">{{translate('Code')}}</th>
    <th scope="col">{{translate('Action')}}</th>
</tr>
@endsection

@section('table-data')
@php $pageIndex = pageIndex($items); @endphp
@foreach($items as $key=>$item)
<tr>
    <td>{{SN($pageIndex, $key)}}</td>
    <td>{{$item->title}}</td>
    <td>{{$item->code}}</td>
    <td>
        @include('system.partials.editButton')
    </td>
</tr>
@endforeach
@endsection
