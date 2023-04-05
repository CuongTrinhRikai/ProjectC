@extends('system.layouts.form')
@section('inputs')

    @if (isset($item))

        {{ Form::hidden('id', $item->id, ['class' => 'form-control', 'id' => 'item_id']) }}
    @endif
    <x-system.form.form-group
        :input="['name' => 'manual_id','required'=>'true', 'label' => 'Manual ID','default'=> old('manual_id') ?? $item->manual_id ?? old('manual_id'), 'error' => $errors->first('manual_id')]" />
    <x-system.form.form-group
        :input="['name' => 'name','required'=>'true','id'=>'name', 'label' => 'Manual Name ','default'=> old('name') ?? $item->name ?? old('name'), 'error' => $errors->first('name')]" />

    <x-system.form.form-group :input="[ 'name' => 'contact_category_id', 'label'=> 'Mansion ']">
        <x-slot name="inputs">
            <x-system.form.input-select
                :input="[ 'name' => 'mansion_id', 'label'=> 'Mansion ID', 'default' => old('mansion_id') ?? $item->mansion_id ?? old('mansion_id') , 'options' => $mansions,'id'=>'mansion_id', 'class' => 'select2','placeholder' => 'すべての物件' ,'error' => $errors->first('mansion_id')]" />
        </x-slot>
    </x-system.form.form-group>
    {{-- <x-system.form.form-group :input="['label' => 'Manual Type','required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.input-radio
                :input="['name' => 'manual_type','options' => $manualtype, 'default' => $item->manual_type ?? 1,'error' => $errors->first('manual_type') ?? null]" />
        </x-slot>
        <div class="col-sm-5">
            <div class="invalid-manual-type"></div>
        </div>
    </x-system.form.form-group> --}}
    <div class="form-group row " id="">
        <label for="" class="col-sm-2 col-form-label  require">
           {{ translate('Manual Type') }}
        </label>
        <div class="col-sm-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input flag " type="radio" id="manual_type-1"
                 @if (isset($item->manual_type) && $item->manual_type == 1) checked
                @else
                        checked
                 @endif value="1" checked="" name="manual_type">
                <label class="form-check-label" for="manual_type-1">{{ translate('pdf') }}</label>

            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input flag " type="radio" id="manual_type-0" @if (isset($item->manual_type) && $item->manual_type == 0) checked @endif value="0"
                    name="manual_type">
                <label class="form-check-label" for="manual_type-0">{{ translate('video') }}</label>

            </div>
            @error('manual_type')
            <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>
            @enderror
            <div class="custom-error-manaultype invalid-manual-type"></div>
        </div>
    </div>

    @if (isset($item))
        <span id="old_filename" style="margin-left: 17%">{{ Illuminate\Support\Str::limit($item->filename, 25) }}</span>

    @endif
    <div class="form-group row">
        <label for="url" class="col-sm-2 col-form-label  require">
            {{ translate('File Upload') }}
        </label>
        <div class="col-sm-6">
            <div class="custom-file">
                <input type="file" class="custom-file-input " id="upload_file" accept="application/pdf,video/*" name="url">
                <label style="overflow:hidden " class="custom-file-label" for="upload_file"
                    data-browse="{{ translate('Browse') }}"></label>
            </div>
            <div class="invalid-feedback invalid-url"></div>
        </div>
    </div>



    {{-- <x-system.form.form-group :input="['label' => 'Status','required'=>'true']">
        <x-slot name="inputs">
            <x-system.form.input-radio
                :input="['name' => 'flag','required'=>'true', 'options' => $status, 'default' => $item->flag ?? 1]"/>
        </x-slot>
    </x-system.form.form-group>
            <div class="col-sm-5">
                <div class="invalid-flag"></div>
            </div> --}}
    <div class="form-group row " id="">
        <label for="" class="col-sm-2 col-form-label  require">
            {{ translate('Status') }}
        </label>
        <div class="col-sm-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input flag " type="radio" id="flag-1" @if (isset($item->flag) && $item->flag == 1) checked
                @else
                            checked @endif value="1" name="flag">
                <label class="form-check-label" for="flag-1">{{ translate('Active') }}</label>

            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input flag " type="radio" id="flag-0" @if (isset($item->flag) && $item->flag == 0) checked @endif value="0"
                    name="flag">
                <label class="form-check-label " for="flag-0">{{ translate('Inactive') }}</label>

            </div>

            <div class="custom-error invalid-flag "></div>
        </div>
    </div>



    <div class="form-group row  uploadProgress d-none">
        <div class="col-sm-2 col-form-label "></div>
        <div class="uploadProgress col-sm-6 d-none">
            <div class="progress " style="height:20px;">
                <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:0%; height:20px;"
                    role="progressbar"></div>
            </div>
            <span class="prepareUpload">{{ translate('Preparing Upload') }}....</span><span
                class="uploading d-none">{{ translate('Uploading') }}.... 0%</span>
            <small class="text-danger float-right"> *{{ translate('Please do not close or refresh tab') }}*.</small>
        </div>
        <div class="col-sm-5">
            <div class="invalid-progress"></div>
        </div>
    </div>

    <x-system.form.form-group :input="['name' => 'file_name','id'=>'file_name','hidden'=>'hidden' ]" />
    <x-system.form.form-group :input="['name' => 'original_name','id'=>'original_name','hidden'=>'hidden' ]" />

    <x-system.form.form-group
        :input="['name' => 'old_url','id'=>'old_url' ,'default'=> $item->url ?? old('url'),'hidden'=>'hidden' ]" />

    <x-system.form.form-group
        :input="['name' => 'old_filename','id'=>'old_filename' ,'default'=> $item->filename ?? old('filename'),'hidden'=>'hidden' ]" />




@endsection
@section('scripts')
    @include('system.manual.include.scripts')
@endsection
