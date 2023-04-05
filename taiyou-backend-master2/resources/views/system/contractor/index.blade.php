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
        <th scope="col" style="white-space: nowrap; width:100px">{{ translate('Contractor Company Name') }}</th>
        <th scope="col" style="white-space: nowrap; width:100px">{{ translate('Contractor ID') }}</th>
        <th scope="col" style="white-space: nowrap">{{ translate(' Sales Staff') }}</th>
        <th scope="col" style="white-space: nowrap">{{ translate('Sales Affair ') }}</th>
        <th scope="col" style="white-space: nowrap">{{ translate('Company General Affair') }}</th>
        <th scope="col" style="white-space: nowrap;width:250px">{{ translate('Action') }}</th>
    </tr>
@endsection

@section('table-data')
    @php $pageIndex = pageIndex($items); @endphp
    @foreach ($items as $key => $item)

        <tr>
            <td>{{ SN($pageIndex, $key) }}</td>
            <td style="white-space: normal;">{{ $item->company_name }}</td>
            <td style="white-space: normal;">{{ $item->contractorId }}</td>
            <td>
                @php
                    $salesstaffArray = [];
                @endphp
                @if ($item->contractorGuide->isempty())
                @else
                    @foreach ($item->contractorGuide as $contractorGuide)
                        @if ($contractorGuide->pivot->type == 0)
                            @php
                                array_push($salesstaffArray, $contractorGuide->pivot->type);
                            @endphp
                            <ul class="pl-2" style="white-space: normal;">
                                <li>{{ $contractorGuide->name . '' . '(' . $contractorGuide->employee_number . ')' ?? '-' }}
                                </li>
                            </ul>
                        @endif
                    @endforeach
                @endif
                @if (count($salesstaffArray) == 0)

                    <span class="dash" style="margin-left: 16px;">-
                @endif
            </td>

            <td>
                @php
                    $salesaffairArray = [];
                @endphp
                @if ($item->contractorGuide->isempty())


                @else
                    @foreach ($item->contractorGuide as $contractorGuide)
                        @if ($contractorGuide->pivot->type == 2)
                            @php
                                array_push($salesaffairArray, $contractorGuide->pivot->type);
                            @endphp
                            <ul class="pl-2" style="white-space: normal;">
                                <li>{{ $contractorGuide->name . '' . '(' . $contractorGuide->employee_number . ')' ?? '-' }}
                                </li>
                            </ul>
                        @endif
                    @endforeach
                @endif
                @if (count($salesaffairArray) == 0)

                    <span class="dash" style="margin-left: 16px;">-
                @endif
            </td>

            <td>
                @php
                    $company_general_affairArray = [];
                @endphp
                @if ($item->contractorGuide->isempty())


                @else
                    @foreach ($item->contractorGuide as $contractorGuide)
                        @if ($contractorGuide->pivot->type == 3)
                            @php
                                array_push($company_general_affairArray, $contractorGuide->pivot->type);
                            @endphp
                            <ul class="pl-2" style="white-space: normal">
                                <li>{{ $contractorGuide->name . '' . '(' . $contractorGuide->employee_number . ')' ?? '-' }}
                                </li>
                            </ul>
                        @endif
                    @endforeach
                @endif
                @if (count($company_general_affairArray) == 0)

                    <span class="dash" style="margin-left: 16px;">-
                @endif
            </td>
            <td>
                @include('system.partials.viewButton')
                @include('system.partials.editButton')
                @include('system.partials.deleteButton')
            </td>
        </tr>
    @endforeach
@endsection
