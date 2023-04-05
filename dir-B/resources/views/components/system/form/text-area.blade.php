<textarea class="form-control {{ isset($input['editor']) ? 'editor' : '' }} {{ (isset($input['error']) && $input['error'] !== "") ? 'is-invalid' : '' }}"
 id="{{ $input['id'] ?? $input['name'] }}" name="{{ $input['name'] }}" placeholder="{{ translate($input['placeholder'] ?? $input['label'] ?? '') }}" rows="{{ $input['rows'] ?? 4 }}"
 {{ isset($input['disabled']) ? 'disabled' : '' }} >{!! $input['default'] ?? '' !!}</textarea>
 @if(isset($input['helpText']))
  <small class="form-text text-muted">{{ translate($input['helpText']) ?? '' }}</small>
@endif
@if(isset($input['error']))<div class="invalid-feedback">{{ translate($input['error']) }}</div>@endif