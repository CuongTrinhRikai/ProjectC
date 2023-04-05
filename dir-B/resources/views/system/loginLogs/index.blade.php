@extends('system.layouts.listing')

@section('create')
@endsection

@section('header')
<x-system.search-form :action="url($indexUrl)">
    <x-slot name="inputs">
        <x-system.form.form-inline-group :input="['name'=>'range','class'=>'daterange','type'=>'text', 'label'=>'Select Date Range','default'=> Request::get('range'),'autoComplete'=>'off']" />
        <input type="hidden" name="from" id="from-date" value="{{Request::get('from')}}">
        <input type="hidden" name="to" id="to-date" value="{{Request::get('to')}}">
    </x-slot>
</x-system.search-form>
@endsection

@section('table-heading')
<tr>
    <th scope="col">{{translate("S.N")}}</th>
    <th scope="col" style="white-space: nowrap">{{translate("User")}}</th>
    <th scope="col" style="white-space: nowrap">{{translate('Ip Address')}}</th>
    <th scope="col" style="white-space: nowrap">{{translate('Time')}}</th>
    <th scope="col" style="white-space: nowrap">{{translate('ISP')}}</th>
    <th scope="col" style="white-space: nowrap">{{translate('Location')}}</th>
</tr>
@endsection

@section('table-data')
@php $pageIndex = pageIndex($items); @endphp
@foreach($items as $key=>$item)
<tr>
    <td>{{SN($pageIndex, $key)}}</td>
    <td>{{ $item->user->name ?? 'N/A'}}</td>
    <td>{{ $item->ip}}</td>
    <td>{{ localDateTime($item->created_at)}}</td>
    <td>
        Latitude : {{$item->lat}}<br>
        Longitude : {{$item->lon}}<br>
        City : {{$item->city}}<br>
        Country : {{$item->country}}<br>
    </td>
    <td>{{ $item->region_name }}</td>
</tr>
@endforeach
@endsection
