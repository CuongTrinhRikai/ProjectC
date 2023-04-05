@if(hasPermission($indexUrl.'/'.$item->id.'/edit', 'get'))
  <a href="{{url($indexUrl.'/'.$item->id.'/edit')}}"style="white-space: nowrap;margin:2px" class="btn btn-primary btn-sm"><em class="fas fa-pencil-square-o"></em> {{translate('Edit')}}</a>
@endif
