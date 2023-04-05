@extends('system.layouts.master')
@section('content')
<div class="content-display clearfix">
    <div class="panel panel-default">
        <div class="panel-heading no-bdr">
            <x-system.search-form :action="url($indexUrl)">
                <x-slot name="inputs">
                    <x-system.form.form-inline-group :input="['name' => 'keyword', 'label' => 'Search keyword', 'default' => Request::get('keyword')]" />
                </x-slot>
            </x-system.search-form>
        </div>
    </div><!-- panel -->
    <div class="panel">
        <div class="panel-box">
            @include('system.partials.message')
        </div>
    </div>

    <div class="panel">
        <div class="panel-box">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" aria-describedby="config table">
                    <thead>
                        <tr>
                            <th style="width: 5px;" scope="col">{{translate('S.N')}}</th>
                            <th scope="col" style="white-space: nowrap">{{translate('Label')}}</th>
                            <th scope="col" style="white-space: nowrap">{{translate('Value')}}</th>
                            {{-- <th scope="col" style="width: 10%;white-space: nowrap">{{translate('Action')}}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php $pageIndex = pageIndex($items); @endphp
                        @forelse($items as $key=>$item)
                        <tr>
                            <td>{{SN($pageIndex, $key)}}</td>
                            <td>{{$item->label}}</td>
                            <td>
                                @if(hasPermission($indexUrl.'/'.$item->id, 'put'))
                                <form method="post" action="{{url($indexUrl.'/'.$item->id)}}" id="form{{$item->id}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @if($item->isTextArea($item->type))
                                    <textarea name='value' class='form-control' onchange="submit()">{{$item->value}}</textarea>
                                    @elseif($item->isFile($item->type))
                                    <div style="display:flex;">
                                        <img src="{{ asset('uploads/config/'.$item->value) }}" class="img-thumbnail mr-2" alt="{{$item->value}}" style="max-width:100px;">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="value" id="customFile{{$item->id}}" onchange="submit()" accept="image/*">
                                            <label class="custom-file-label" for="customFile{{$item->id}}">
                                                {{ translate('Choose file') }}
                                            </label>
                                        </div>
                                    </div>
                                    @elseif($item->isColorPicker($item->label))
                                    <input type='{{$item->type}}' placeholder='Value' name='value' value="{{$item->value}}" onchange="submit()" class='form-control {{ $item->isColorPicker($item->label) ? 'jscolor {hash:true}' : '' }}'>
                                    @else
                                    <input type='{{$item->type}}' placeholder='Value' name='value' value="{{$item->value}}" onchange="submit()" class='form-control'>
                                    @endif
                                </form>
                                @else
                                @if($item->isFile($item->type))
                                <img src="{{ asset('uploads/config/'.$item->value) }}" class="img-thumbnail mr-2" alt="{{$item->value}}" style="max-width:100px;">
                                @else
                                {{$item->value}}
                                @endif
                                @endif
                            </td>
                            {{-- <td>
                                @if(hasPermission($indexUrl.'/'.$item->id, 'delete') && ! $item->isDefault($item->id))
                                @include('system.partials.deleteButton')
                                @endif
                            </td> --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100%" class="text-center">{{translate('No data available')}}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @include('system.partials.pagination')
            </div>
        </div>
    </div><!-- panel -->

    @if(hasPermission($indexUrl, 'post'))
    <div class="panel panel-default">
        <div class="panel-heading no-bdr">
            <form method="post" class="form-inline" action="{{ url($indexUrl) }}" enctype="multipart/form-data">
                @csrf
                <x-system.form.form-inline-group :input="['name' => 'label', 'label' => 'Label', 'default' => old('label'), 'required' => true, 'error' => $errors->first('label')]" />
                <x-system.form.form-inline-group :input="['name' => 'type', 'label' => 'Type']">
                    <x-slot name="inputs">
                        <x-system.form.input-select :input="['name'=>'type', 'label'=>'Type', 'placeholder' => 'Select Type', 'default' => old('type'), 'options' => $types, 'error'=>$errors->first('type')]" />
                    </x-slot>
                </x-system.form.form-inline-group>

                <div id="dynamic-field-wrapper" class="d-none">
                    <x-system.form.form-inline-group :input="['name'=>'value', 'id' => 'text-value', 'label' => 'Value', 'groupId' => 'text-type', 'required' => true, 'default' => old('value'), 'error' => $errors->first('value')]" />
                    <x-system.form.form-inline-group :input="['name'=>'value', 'id' => 'number-value', 'label' => 'Value', 'groupId' => 'number-type', 'type'=>'number', 'required' => true, 'default' => old('value'), 'error' => $errors->first('value')]" />
                    <x-system.form.form-inline-group :input="['name'=>'value', 'label' => 'Select file', 'groupId' => 'file-type']">
                        <x-slot name="inputs">
                            <x-system.form.input-file :input="['name' => 'value', 'id' => 'file-value', 'label' => 'Select Image', 'accept' => 'image/*', 'required' => true, 'error' => $errors->first('value')]" />
                        </x-slot>
                    </x-system.form.form-inline-group>
                    <x-system.form.form-inline-group :input="['name'=>'value', 'label' => 'Value', 'groupId' => 'textarea-type']">
                        <x-slot name="inputs">
                            <x-system.form.text-area :input="['name' => 'value', 'id' => 'textarea-value', 'label' => 'Value', 'rows' => 2, 'required' => true, 'default' => old('value'), 'error' => $errors->first('value')]" />
                        </x-slot>
                    </x-system.form.form-inline-group>
                </div>
                <button class="btn btn-primary" type="submit"><em class="fas fa-save"></em> {{translate('Save')}}</button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
