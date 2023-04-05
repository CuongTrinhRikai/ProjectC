@props(['url', 'modalTitle', 'modalId', 'buttonClass', 'submitButtonTitle', 'modalTriggerButton', 'buttonIconClass'])

<button style="margin-top: 7px; white-space: nowrap;" type="button" class="btn {{$buttonClass}} mb-2 btn-sm" data-toggle="modal" data-target="#{{$modalId}}" style="margin-top:9px;">
@if(isset($buttonIconClass))<em class="fas {{$buttonIconClass}}"></em>@endif {{translate($modalTriggerButton)}}
</button>

<!-- Modal -->
<div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <form id="reset-form" method="post" action="{{$url}}" enctype="multipart/form-data">
      <div class="modal-content">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="{{ $modalId }}">{{translate($modalTitle)}}</h5>
          <button type="button" class=" exit" style="font-size: 1.5rem;background-color: transparent;border: 0;
  appearance: none; opacity: .5;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{$body}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default closed " data-dismiss="modal">{{translate('Close')}}</button>
          <button type="submit" class="btn {{$buttonClass}}">{{translate($submitButtonTitle)}}</button>
        </div>
      </div>
    </form>
  </div>
</div>

