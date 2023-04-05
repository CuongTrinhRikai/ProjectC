@extends('system.layouts.listing')
@section('header')
    <x-system.search-form :action="$indexUrl">
        <x-slot name="inputs">
            <x-system.form.form-inline-group
                :input="['name' => 'keyword', 'placeholder' => 'Keyword', 'default' => Request::get('keyword')]">
            </x-system.form.form-inline-group>
            <div class="col-sm-">
                <div class="form-group" style="margin-top: 8px">

                    <select name="group" id="group" class='form-control col-sm-auto'>
                        <option value="">{{translate('Select Flag')}}</option>

                        @foreach ($flagSearch as $key => $value)

                            <option value='{{ $key }}' @if( Request::get('group')!= null && Request::get('group')==$key )   selected @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-slot>
    </x-system.search-form>
@endsection
@section('table-heading')
    <tr>
        <th scope="col" style="white-space: nowrap;width:30px; ">{{ translate('S.N') }}</th>
        <th scope="col" style="white-space: nowrap; width:300px;">{{ translate('Notification Title') }}</th>
        <th scope="col" style="white-space: nowrap;width:500px;">{{ translate('Notification Content') }}</th>
        <th scope="col" style="white-space: nowrap;width:200px;">{{ translate('Name of Registrant') }}</th>
        <th scope="col" style="white-space: nowrap;width:200px;">{{ translate('Flag') }}</th>
        <th scope="col" style="white-space: nowrap;width:300px;">{{ translate('Action') }}</th>
    </tr>
@endsection
@section('table-data')
    @php $pageIndex = pageIndex($items); @endphp
    @foreach ($items as $key => $item)
    @php
    $contractor =$item->notificationcontractor->toArray();

    @endphp

    <tr>
            <td>{{ SN($pageIndex, $key) }}</td>
            <td style="white-space: normal;">{{ $item->title }}</td>
            <td>{!! Illuminate\Support\Str::limit($item->body, 50, '...')!!}</td>
            <td>{{$item->name_of_registrant }}</td>
            @if ($item->flag ==0)

            <td>{{translate('Private') }}</td>
            @else
            <td>{{translate('Public') }}</td>
            @endif
            <td>
                @section('delete')
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form method="post" id="formid">
                            <div class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">{{translate('Confirm Delete')}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{translate('Are you sure you want to delete?')}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                                        <em class="glyph-icon icon-close"></em> {{translate('Cancel')}}
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-danger" id="del-btn">
                                        <em class="glyph-icon icon-trash"></em> {{translate('Delete')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @show
                @include('system.partials.viewButton')
                @include('system.partials.deleteButton')
            </td>
    </tr>

    @endforeach
@endsection
@section('scripts')
<script>
document.getElementById("del-btn").onclick = function() {
    this.disabled = true;
    $('#formid').submit();
            return true;
    }
    </script>
@endsection
