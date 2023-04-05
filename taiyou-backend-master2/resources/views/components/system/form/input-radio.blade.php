@foreach($input['options'] as $key => $radioOption)
<div class="form-check {{ isset($input['stacked']) ? '' : 'form-check-inline' }}">
  <input class="form-check-input flag {{ isset($input['error']) && $input['error'] !== "" ? 'is-invalid' : '' }}" type="radio"
         id="{{ $input['name'] }}-{{ $radioOption['value'] }}"
         value="{{ $radioOption['value'] }}"
         @if($input['default'] == $radioOption['value'])
         checked
         @endif
         name="{{ $input['name'] }}" {{ isset($input['disabled']) ? 'disabled' : '' }} >
  <label class="form-check-label" for="{{ $input['name'] }}-{{ $radioOption['value'] }}">{{ translate($radioOption['label'] ?? $radioOption['key']) }}</label>

</div>
@endforeach
@if(isset($input['error']))<div class="invalid-feedback" @if(isset($input['error'])) style="display: block !important;" @endif>{{ translate($input['error']) }}</div>@endif

@if(isset($input['helpText']))
  <small class="form-text text-muted">{{ translate($input['helpText']) ?? '' }}</small>
@endif


