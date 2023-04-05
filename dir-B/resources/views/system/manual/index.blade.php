@extends('system.layouts.listing')
@section('header')
<x-system.search-form :action="$indexUrl">
    <x-slot name="inputs">
        <x-system.form.form-inline-group :input="['name' => 'keyword', 'placeholder' => 'Keyword', 'default' => Request::get('keyword')]"></x-system.form.form-inline-group>
        {{-- <div class="col-sm-">
            <div class="form-group" style="margin-top: 8px">

                <select name="group" id="group" class='form-control col-sm-auto'>
                        <option value="" selected >{{translate('Filter by Manual Type')}}</option>
                        @foreach ($sortBY as $key => $value)

                        <option value='{{ $key }}' @if ( Request::get('group')!= null && Request::get('group')==$key )   selected @endif>
                            {{ $value }}
                        </option>

                        @endforeach


                </select>
            </div>
        </div> --}}
        <x-system.form.form-inline-group :input="['name' => 'group', 'label' => 'group']">
            <x-slot name="inputs">
                <x-system.form.input-select :input="['name' => 'group', 'placeholder' => 'Filter by manual type', 'options' => $sortBY, 'default' => Request::get('group')]" />
            </x-slot>
        </x-system.form.form-inline-group>
    </x-slot>
</x-system.search-form>




@endsection

@section('table-heading')
<tr>
    <th scope="col">{{translate('S.N')}}</th>
    <th scope="col" style="width:17%;white-space:nowrap;" >{{translate('Manual Name')}}</th>
    <th scope="col" style="width:20%;white-space:nowrap;">{{translate('Manual ID')}}</th>
    <th scope="col" style="white-space:nowrap;">{{translate('Manual Type')}}</th>
    <th scope="col" style="white-space:nowrap;">{{translate('Mansion Name')}}</th>
    <th scope="col" style="white-space:nowrap;">{{translate('Status')}}</th>
    <th scope="col" style="white-space:nowrap;">{{translate('Action')}}</th>
</tr>
@endsection

@section('table-data')
@php $pageIndex = pageIndex($items); @endphp

@foreach($items as $key=>$item)
<tr>
    <td>{{SN($pageIndex, $key)}}</td>

    <td style="white-space: normal;"> {{ $item->name ?? '-'}}</td>

    <td>{{ $item->manual_id}}</td>
    @if ($item->manual_type == 1)

    <td>{{ translate('pdf') }}</td>
    @else
    <td>{{ translate('video') }}</td>
    @endif
    <td style="white-space: normal;">{{$mansions[$item->mansion_id] ?? '-'}}</td>
    <td>@include('system.partials.statusButtons', ['status' =>$item->flag, 'url' => '/system/update-manual-status/'.$item->id])</td>
    <td>
        @include('system.partials.viewButton')
        @include('system.partials.editButton')
        @include('system.partials.deleteButton')
    </td>
</tr>
@endforeach
@endsection
