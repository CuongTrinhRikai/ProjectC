<div class="col-auto mb-2" id="{{ $input['groupId'] ?? '' }}">
  <label class="sr-only" for="{{ $input['name'] ?? '' }}">{{ translate($input['label'] ?? '') }}</label>
  @if(isset($inputs))
  {{$inputs}}
  @else
  <x-system.form.input-normal :input="$input"/>
  @endif
</div>
