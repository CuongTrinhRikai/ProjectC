@extends('system.layouts.listing')
@section('header')
    <x-system.search-form :action="$indexUrl">
        <x-slot name="inputs">
            <x-system.form.form-inline-group
                :input="['name' => 'keyword', 'placeholder' => 'Keyword', 'default' => Request::get('keyword')]">
            </x-system.form.form-inline-group>
        </x-slot>
    </x-system.search-form>
@endsection

@section('table-heading')
    <tr>
        <th scope="col" style="white-space: nowrap">{{ translate('S.N') }}</th>
        <th scope="col" style="white-space: nowrap">{{ translate('Mansion ID') }}</th>
        <th scope="col" style="white-space: nowrap">{{ translate('Mansion Name') }}</th>
        <th scope="col" style="white-space: nowrap">{{ translate('Mansion Address') }}</th>
        <th scope="col" style="white-space: nowrap">{{ translate('Contractor Name') }}</th>
        <th scope="col" style="white-space: nowrap">{{ translate('Instructor') }}</th>

        <th scope="col" style="white-space: nowrap;width:200px">{{ translate('Action') }}</th>
    </tr>
@endsection

@section('table-data')
    @php $pageIndex = pageIndex($items); @endphp

    @foreach ($items as $key => $item)

        <tr>

            <td>{{ SN($pageIndex, $key) }}</td>
            <td>{{ Illuminate\Support\Str::limit($item->mansion_id, 10, '...') }}</td>
            <td style="white-space: normal;">{{ $item->mansion_name }}</td>
            <td style="white-space: normal;">
                {{ $item->address }}
            </td>
            @if ($item->contractor_id != null)

                <td style="white-space: normal;">
                    {{ $item->contractor->company_name . '' . '(' . $item->contractor->contractorId . ')' ?? '-' }}
                </td>
            @else
                <td>-</td>

            @endif
            <td>
                @if ($item->mansionGuide->isempty())

                             -
                @else
                    @foreach ($item->mansionGuide as $mansionGuide)

                        <ul class="pl-2" style="white-space: normal">
                            <li>{{ $mansionGuide->name . '' . '(' . $mansionGuide->employee_number . ')' ?? '-' }}
                            </li>
                        </ul>
                    @endforeach
                @endif
            </td>
            <td>
                @include('system.partials.viewButton')
                @include('system.partials.editButton')
                @include('system.partials.deleteButton')
                @if (hasPermission($indexUrl . '/' . $item->id . '/qr-code', 'get'))
                    <a href="{{ url($indexUrl . '/' . $item->id . '/qr-code') }}" style="white-space: nowrap;margin:2px"
                        class="btn btn-secondary btn-sm"><em class="fas fa-qrcode"></em>
                        {{ translate('Generate QR Code') }}</a>
                @endif
            </td>

        </tr>

        <!-- Modal -->
        {{-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>rrr</p>
            </div>

        </div>

    </div>
</div> --}}
    @endforeach
@endsection
