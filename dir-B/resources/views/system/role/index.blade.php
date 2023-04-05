@extends('system.layouts.listing')
@section('header')
<x-system.search-form :action="$indexUrl">
  <x-slot name="inputs">
    <x-system.form.form-inline-group :input="['name' => 'keyword', 'label' => 'Search keyword', 'default' => Request::get('keyword')]" />
  </x-slot>
</x-system.search-form>
@endsection

@section('table-heading')
<tr>
  <th scope="col">{{translate('S.N')}}</th>
  <th scope="col">{{translate('Role Name')}}</th>
  {{-- <th scope="col">{{translate('Action')}}</th> --}}
</tr>
@endsection

@section('table-data')
@php $pageIndex = pageIndex($items); @endphp
@foreach($items as $key=>$item)
<tr>
  <td>{{SN($pageIndex, $key)}}</td>
  <td>{{$item->name}}</td>
  {{-- <td>
    @if($item->isEditable($item->id))
    @include('system.partials.editButton')
    @endif

    @if($item->isDeletable($item->id))
    @include('system.partials.deleteButton')
    @endif

    @if(hasPermission('/users'))
    <a href="/{{PREFIX}}/users?role={{$item->id}}" class="nonelink"><span class="span-icon">
        <i class="fa fa-users" aria-hidden="true"></i>{{ $item->users->count()}}</span>
    </a>
    @endif
  </td> --}}
</tr>
@endforeach
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
      $("#addNew").hide();
   });
 </script>
 @endsection
