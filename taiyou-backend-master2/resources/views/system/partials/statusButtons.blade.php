@if (Auth::user()->role_id == 3)
    @if ($status == 1)
        <a href="{{ $url }}" class="btn btn-success btn-sm status_button disabled  "
            data-status="{{ $status }} " style="white-space: nowrap">{{ translate('Publish') }}</a>
    @else
        <a href="{{ $url }}" class="btn btn-danger btn-sm status_button disabled"
            data-status="{{ $status }}" style="white-space: nowrap">{{ translate('Unpublish') }}</a>
    @endif
@else
    @if ($status == 1)
        <a href="{{ $url }}" class="btn btn-success btn-sm status_button   "
            data-status="{{ $status }} " style="white-space: nowrap">{{ translate('Publish') }}</a>
    @else
        <a href="{{ $url }}" class="btn btn-danger btn-sm status_button "
            data-status="{{ $status }}" style="white-space: nowrap">{{ translate('Unpublish') }}</a>
    @endif

@endif
