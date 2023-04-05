<div class="form-group row {{ isset($input['class']) ? $input['class'] : '' }}" id="{{ $input['groupId'] ?? '' }}" {{ isset($input['hidden']) ? 'hidden' : '' }} >
    <label for="{{ $input['name'] ?? '' }}" class="col-sm-3 col-form-label {{ isset($input['class']) ? $input['class'] : '' }} {{ (isset($input['required']) || isset($input['label-required'])) ? 'require' : '' }}">
        {{ isset($input['label']) ? translate($input['label']) : '' }}
    </label>
    <div class="{{ isset($input['fullWidth']) ? 'col-sm-10' : 'col-sm-6' }}">
        @if(isset($inputs))
            {{$inputs}}
        @else
            <x-system.form.input-normal :input="$input"/>
        @endif
    </div>
</div>
