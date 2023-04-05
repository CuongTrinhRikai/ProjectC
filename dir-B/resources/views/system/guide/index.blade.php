@extends('system.layouts.listing')
@section('header')
    <x-system.search-form :action="url($indexUrl)">
        <x-slot name="inputs">
            <x-system.form.form-inline-group
                :input="['name' => 'keyword', 'label' => 'Search keyword', 'default' => Request::get('keyword')]" />

            <div class="col-sm-">
                <div class="form-group" style="margin-top: 8px">

                    <select name="group" id="group" class='form-control col-sm-auto'>
                        <option value="">{{translate('Select Contact Guide Category')}}</option>

                        @foreach ($contact as $key => $value)

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
        <th scope="col"style="width: 50px;white-space:nowrap;" >{{ translate('S.N') }}</th>
        <th scope="col" style="width: 220px;white-space:nowrap;" >{{ translate('Contact Guide Category') }}</th>
        <th scope="col" style="width: 200px;white-space:nowrap;" >{{ translate(' Contact Guide Name') }}</th>
        <th scope="col" style="width: 250px;white-space:nowrap;" >{{ translate('Contact Guide Employee Number') }}</th>
        <th scope="col" style="width: 200px;white-space:nowrap;" >{{ translate('Line ID') }}</th>
        <th scope="col" style="width: 200px;white-space:nowrap;" >{{ translate('Mobile Number') }}</th>
        <th scope="col" style="width: 200px;white-space:nowrap;" >{{ translate('Email') }}</th>
        <th scope="col" style="width: 200px;white-space:nowrap;" >{{ translate('Status') }}</th>
        <th scope="col"  style="width: 224px;">{{ translate('Action') }}</th>
    </tr>
@endsection

@section('table-data')
    @php $pageIndex = pageIndex($items); @endphp

    @foreach ($items as $key => $item)

        <tr>
            <td>{{ SN($pageIndex, $key) }}</td>

            <td style="white-space: normal;">
                @if (isset($item->contact_category_id))
                    {{ $contact[$item->contact_category_id] ?? '-'}}
                @endif
            </td>

            <td style="white-space: normal;">{{ $item->name ?? '-'}}</td>

            <td style="white-space: normal;">{{ $item->employee_number }}</td>
            <td style="white-space: normal;">
                {{ $item->line_id }}

            </td>

            <td>{{Illuminate\Support\Str::limit($item->mobile_number, 11, '...') ?? '-'}}</td>

            <td>{{Illuminate\Support\Str::limit($item->email, 15, '...') ?? '-'}}</td>
            <td>
                <a class="btn btn-round btn-sm
                @if($item->status == 1)btn-success @else btn-danger @endif btn_glyph"
                   href="{{ URL::to(PREFIX.'/guides/change-status?id='.$item->id) }}" style="white-space: nowrap;">
                    @if($item->status == 1){{ translate('Active') }}
                    @else {{ translate('Inactive') }} @endif</a>
            </td>
            <td>
                @include('system.partials.viewButton')
                @include('system.partials.editButton')
                @include('system.partials.deleteButton')

            </td>
        </tr>
    @endforeach
@endsection
