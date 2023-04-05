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
    <th>{{translate("S.N")}}</th>
    <th>{{translate("User")}}</th>
    <th>{{translate('Log Module')}}</th>
    <th style="width: 30%;">{{translate('Log Message')}}</th>
    <th>{{translate('Changes')}}</th>
</tr>
@endsection

@section('table-data')
@php $pageIndex = pageIndex($items); @endphp
@foreach($items as $key=>$item)
<tr>
    @php 
    $oldValues = $item->oldValues($item->properties);
    $newValues = $item->newValues($item->properties);
    @endphp
    <td>{{SN($pageIndex, $key)}}</td>
    <td>{{ $item->getNameFromDescription($item->description) }}</td>
    <td>{{ $item->getModuleName($item->subject_type)}}</td>
    <td>{!! $item->description !!}</td>
    <td>
        @if(count($item->properties) > 0)
        @if($oldValues !== 'N/A')
        <strong>Old values:</strong> <br>
        {!! $oldValues !!}
        <br>
        @endif
        <strong>{{$oldValues == 'N/A' ? 'Values:' : 'New Values:'}}</strong> <br>
        {!! $newValues !!}
        @else
        --
        @endif
    </td>
</tr>
@endforeach
@endsection