@extends('system.layouts.form')
@section('inputs')
<x-system.form.form-group :input="['name' => 'fromemail','type'=> 'email', 'required'=>'true', 'label' => 'From Email','default'=> old('fromemail'), 'error' => $errors->first('fromemail')]" />
<x-system.form.form-group :input="['name' => 'fromname','required'=>'true', 'label' => 'From Name','default'=> old('fromname'), 'error' => $errors->first('fromname')]" />
<x-system.form.form-group :input="['name' => 'toname','required'=>'true', 'label' => 'To Name','default'=> old('toname'), 'error' => $errors->first('toname')]" />
<x-system.form.form-group :input="['name' => 'toemail','type'=> 'email', 'required'=>'true', 'label' => 'To Email','default'=> old('toemail'), 'error' => $errors->first('toemail')]" />
<x-system.form.form-group :input="['name' => 'subject','required'=>'true', 'label' => 'Subject','default'=> old('subject'), 'error' => $errors->first('subject')]" />
<x-system.form.form-group :input="['label' => 'Body', 'required'=>'true']">
    <x-slot name="inputs">
        <x-system.form.text-area :input="['name'=>'body', 'label' => 'Body Text', 'editor' => true, 'error' => $errors->first('body')]" />
    </x-slot>
</x-system.form.form-group>
@endsection