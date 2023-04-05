@if(hasPermission($indexUrl.'/'.$item->id, 'delete'))
  <button style="white-space: nowrap;margin-left:2px;" type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="modal" data-target="#confirmDeleteModal"
          data-href="{{url($indexUrl.'/'.$item->id)}}">
          <em class="fas fa-trash"></em> {{ translate('Delete') }}
  </button>
@endif
