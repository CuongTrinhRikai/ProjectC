
  {{-- <button type="button" class="btn btn-info btn-sm btn-delete"
          data-href="{{url($indexUrl.'/'.$item->id)}}">
          <em class="fas fa-trash"></em> {{ translate('tokenReset') }}
  </button> --}}
  <a href="{{url('/system/building/reset-token'.'/'.$item->id)}}" class="btn btn-info btn-sm" style="white-space: nowrap;"><em class="fas fa-refresh"></em> {{translate('Reset Token')}}</a>

