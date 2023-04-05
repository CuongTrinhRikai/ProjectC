@if($module['name'] !== 'Dashboard')
  <h4>@if(!$module['hasSubmodules']) <input type="checkbox" class="{{str_replace('/','',$module['permissions'][0]['route']['url'])}} module" data-module="{{str_replace('/','',$module['permissions'][0]['route']['url'])}}"> @endif {{ translate($module['name']) }}</h4>
  @if($module['hasSubmodules'])
    @foreach($module['submodules'] as $submodule)
    <h5><input type="checkbox" class="{{str_replace('/','',$submodule['permissions'][0]['route']['url'])}} module" data-module="{{str_replace('/','',$submodule['permissions'][0]['route']['url'])}}"> {{ translate($submodule['name']) }}</h5>
    @foreach($submodule['permissions'] as $permission)
    <label class="checkbox-inline">
      <input type="checkbox" class="{{str_replace('/','',$submodule['permissions'][0]['route']['url'])}}-sub permission" data-module="{{str_replace('/','',$submodule['permissions'][0]['route']['url'])}}-sub" value="{{json_encode($permission['route'], JSON_UNESCAPED_SLASHES)}}" name="permissions[]"
      @if(in_array(json_encode($permission['route'], JSON_UNESCAPED_SLASHES), old('permissions',[])))
             checked
        @endif> {{translate($permission['name'])}}
    </label>
    @endforeach
    @endforeach
  @else
    @if($module['permissions'])
      @foreach($module['permissions'] as $permission)
      <label class="checkbox-inline">
        <input type="checkbox" class="{{str_replace('/','',$module['permissions'][0]['route']['url'])}}-sub permission" data-module="{{str_replace('/','',$module['permissions'][0]['route']['url'])}}-sub"  value="{{json_encode($permission['route'], JSON_UNESCAPED_SLASHES)}}" name="permissions[]"
      @if(in_array(json_encode($permission['route'], JSON_UNESCAPED_SLASHES), old('permissions',[])))
             checked
        @endif> {{ translate($permission['name']) }}
      </label>
      @endforeach
    @endif
  @endif
  <hr>
@endif
