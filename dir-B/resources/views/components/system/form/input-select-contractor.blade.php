
<select name="{{ $input['name'] ?? '' }}" id="{{ $input['id'] ?? $input['name'] ?? ''}}"
class="form-control {{ (isset($input['error']) && $input['error'] !== "") ? 'is-invalid' : '' }}" {{ (isset($input['disabled']) && $input['disabled'] !== "") ? 'disabled' : '' }}
 {{ isset($input['multiple']) ? 'multiple' : '' }} {{ isset($input['required']) ? 'required' : '' }} data-prefix="{{PREFIX}}" data-url="{{url('/')}}">
    @if(isset($input['placeholder']))
    <option value="" >{{$input['placeholder']}}</option>
    @endif
    @if(isset($input['options']))

    @foreach($input['options'] as $key=>$value)

    <option value="{{$key}}" {{ $input['default'] == $key ? 'selected' : '' }}>{{ $value }}</option>
    @endforeach
    @endif
</select>
@if(isset($input['helpText']))
<small class="form-text text-muted">{{ translate($input['helpText']) ?? '' }}</small>
@endif
@if(isset($input['error']))<div class="invalid-feedback">{{ translate($input['error']) }}</div>@endif
