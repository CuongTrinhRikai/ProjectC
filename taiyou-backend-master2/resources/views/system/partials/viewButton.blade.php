@if(hasPermission($indexUrl.'/'.$item->id.'/show', 'get'))
    <a href="{{url($indexUrl.'/'.$item->id.'/show')}}"style="white-space: nowrap;margin:2px" class="btn btn-info btn-sm"><em class="fas fa-eye"></em> {{translate('View')}}</a>
@endif
