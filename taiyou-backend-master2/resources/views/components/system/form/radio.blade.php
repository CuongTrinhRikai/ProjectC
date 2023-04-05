
@foreach($input['options'] as $radioOption)

<div class="form-check {{ isset($input['stacked']) ? '' : 'form-check-inline' }}" style="margin-top: 8px">
  <input class="form-check-input {{ isset($input['error']) ? 'is-invalid' : '' }}" type="radio"
         id="{{ $input['name'] }}-{{ $radioOption['value'] }}"
         value="{{ $radioOption['value'] }}"
         @if($input['default'] == $radioOption['value'])
         checked
         @endif
         name="{{ $input['name'] }}" {{ isset($input['disabled']) ? 'disabled' : '' }} >
  <label class="form-check-label" for="{{ $input['name'] }}-{{ $radioOption['value'] }}">{{ ($radioOption['label'] ?? $radioOption['key']) }}</label>
</div>
@endforeach

@if(isset($input['helpText']))
  <small class="form-text text-muted">{{ translate($input['helpText']) ?? '' }}</small>
@endif
@if(isset($input['error']))<div class="invalid-feedback">{{ translate($input['error']) }}</div>@endif

