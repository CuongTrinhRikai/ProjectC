<input type="{{ $input['type'] ?? 'text' }}" class="form-control {{ (isset($input['error']) && $input['error'] !== "") ? 'is-invalid' : '' }} {{ isset($input['class']) ? $input['class'] : '' }}"
value="{{$input['default'] ?? ''}}" id="{{$input['id'] ?? $input['name']}}" placeholder="{{ translate($input['placeholder'] ?? $input['label'] ?? '') }}" name="{{$input['name'] ?? ''}}"
{{isset($input['disabled']) ? 'disabled' : ''}} {{ isset($input['readonly']) ? 'readonly' : '' }} {{ isset($input['required']) ? 'required' : '' }} {{isset($input['min']) ? 'min='.$input['min'] : ''}} 
{{isset($input['autoComplete']) ? 'autocomplete=off' : ''}}>
@if(isset($input['helpText']))
  <small class="form-text text-muted">{{ translate($input['helpText']) ?? '' }}</small>
@endif
@if(isset($input['error']))<div class="invalid-feedback">{{ translate($input['error']) }}</div>@endif

