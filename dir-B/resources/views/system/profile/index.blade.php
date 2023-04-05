@extends('system.layouts.form')
@section('inputs')
<x-system.form.form-group :input="[ 'name' => 'old_password', 'label'=> 'Old password','type' => 'password', 'required' => true, 'default' => old('old_password'), 'error' => $errors->first('old_password')]" />
<x-system.form.form-group :input="[ 'name' => 'password', 'label'=> 'New Password', 'required' => true, 'type' => 'password', 'default' => old('password'), 'error' => $errors->first('password')]" />
<x-system.form.form-group :input="[ 'name' => 'password_confirmation', 'label'=> 'Confirm Password', 'type' => 'password', 'required' => true, 'default' => old('password_confirmation'), 'error' => $errors->first('password_confirmation')]" />
@endsection