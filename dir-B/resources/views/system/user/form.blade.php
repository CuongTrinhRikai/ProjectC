@extends('system.layouts.form')
@section('inputs')
<x-system.form.form-group :input="[ 'name' => 'name', 'label'=> 'Full Name','default' =>  old('name') ?? $item->name ?? old('name'), 'error' => $errors->first('name'),'label-required'=>'true']" />
<x-system.form.form-group :input="[ 'name' => 'username', 'label'=> 'Username','default' =>old('username') ?? $item->username ?? old('username'), 'error' => $errors->first('username'),'label-required'=>'true']" />
<x-system.form.form-group :input="[ 'name' => 'email', 'label'=> 'Email','default' =>old('email') ??  $item->email ?? old('email'), 'error' => $errors->first('email'),'label-required'=>'true']" />
{{--<div class="form-group row" id="">--}}
  {{--<label class="col-sm-2 col-form-label"> {{translate('Image')}}--}}
  {{--</label>--}}
  {{--<div class="col-sm-6">--}}
    {{--@if(isset($item->image))--}}
      {{--<img id="preview-image-before-upload" src="{{asset('uploads/users/'.$item->image)}}" alt="preview image" style="height:170px;width:200px;" >--}}
    {{--@else--}}
          {{--<img id="preview-image-before-upload" src="{{asset('images/avatar.png')}}" alt="preview image" style="height:170px;width:200px;" >--}}
    {{--@endif--}}
        {{--<input type="file" name="image" value="{{Request::old('image')}}" class="form-control" id="image" accept="image/*">--}}
        {{--@error('image')--}}
        {{--<p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>--}}
        {{--@enderror--}}
  {{--</div>--}}
{{--</div>--}}

{{--<x-system.form.form-group :input="[ 'name' => 'user_type', 'label'=> 'User Type', 'default' => $item->user_type ?? old('user_type'), 'error' => $errors->first('user_type')]" />--}}

<x-system.form.form-group :input="[ 'name' => 'role_id', 'label'=> 'Role','label-required'=>'true']">
  <x-slot name="inputs">
    <x-system.form.input-select :input="[ 'name' => 'role_id', 'label'=> 'Role','default' => old('role_id') ?? $item->role_id ?? old('role_id') , 'options' => $roles, 'placeholder' => 'Select role', 'error' => $errors->first('role_id')]" />
  </x-slot>
</x-system.form.form-group>

@if(!isset($item))
<x-system.form.form-group :input="[ 'name' => 'set_password_status', 'label'=> 'Set Password ?','label-required'=>'true']">
  <x-slot name="inputs">
    <x-system.form.input-radio :input="[ 'name' => 'set_password_status', 'label'=> 'Set Password',
    'default' => old('set_password_status') ?? 0, 'options' => [[ 'value' => '0', 'label' => 'Send Activation Link'], ['value' => '1', 'label'=>'Set Password']]]" />
  </x-slot>
</x-system.form.form-group>

<div class="d-none" id="password-inputs">
  <x-system.form.form-group :input="[ 'name' => 'password', 'label'=> 'Password','label-required'=>true, 'type' => 'password', 'default' => old('password'), 'error' => $errors->first('password')]" />
  <x-system.form.form-group :input="[ 'name' => 'password_confirmation', 'label'=> 'Confirm Password','label-required'=>true, 'type' => 'password', 'default' => old('password_confirmation'), 'error' => $errors->first('password_confirmation')]" />
</div>
@endif
@endsection

@yield('script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">

    $(document).ready(function (e) {


        $('#image').change(function(){

            let reader = new FileReader();

            reader.onload = (e) => {

                $('#preview-image-before-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);

        });

    });

</script>


