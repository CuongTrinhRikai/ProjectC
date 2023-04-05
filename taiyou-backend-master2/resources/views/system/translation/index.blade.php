@extends('system.layouts.master')
@section('content')
@section('heading-contents')
<div class="col-sm-6">
    @if(hasPermission($indexUrl.'/download-sample'))
    <a style="margin-top: 7px;" class="btn @if(Request::get('group') !== null && strtolower(Request::get('group')) == 'frontend' ) btn-info @else btn-primary @endif pull-right btn-sm" href="{{url($indexUrl.'/download-sample')}}" style="margin-right:3px"><i class="fa fa-download" aria-hidden="true"></i> {{translate('Download Sample')}}</a>
    @endif
    @if(hasPermission($indexUrl.'/download/'.(Request::get('group') == null ? 'backend' : Request::get('group'))))
    <a style="margin-top: 7px; margin-right:2px; margin-left:2px" class="btn @if(Request::get('group') !== null && strtolower(Request::get('group')) == 'frontend' ) btn-info @else btn-primary @endif pull-right btn-sm" href="{{url($indexUrl.'/download/'.(Request::get('group') == null ? 'backend' : Request::get('group')))}}" style="margin-right:3px; margin-left:3px"><i class="fa fa-download" aria-hidden="true"></i> {{translate('Download excel for '.(Request::get('group') == null ? 'backend' : Request::get('group')))}}</a>
    @endif

    @if(hasPermission($indexUrl.'/upload/'.(Request::get('group') == null ? 'backend' : Request::get('group')), 'post'))
    <x-system.general-modal :url="url($indexUrl.'/upload/'.(Request::get('group') == null ? 'backend' : Request::get('group')))" :modalTitle="'Upload excel for '.(Request::get('group') == null ? 'backend' : Request::get('group'))" :modalId="'uploadExcelModal'" :modalTriggerButton="'Upload excel for '.(Request::get('group') == null ? 'backend' : Request::get('group'))"
     :buttonClass="(Request::get('group') !== null && strtolower(Request::get('group')) == 'frontend') ? 'btn-info pull-right' : 'btn-primary pull-right'"
        :buttonIconClass="'fa-upload'" :submitButtonTitle="'Upload'">
        <x-slot name="body">
            @include('system.partials.errors')
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label" style="white-space: nowrap">{{translate('Excel File')}}</label>
                <div class="col-sm-6">
                    <input type="file" name="excel_file" class="form-control" accept=".xls">
                </div>
            </div>
        </x-slot>
    </x-system.general-modal>
    @endif
</div>
@endsection
<div class="content-display clearfix">
    <div class="panel panel-default">
        <div class="panel-heading no-bdr">
            <x-system.search-form :action="url($indexUrl)">
                <x-slot name="inputs">
                    <x-system.form.form-inline-group :input="['name' => 'keyword','label' => 'Keyword', 'default' => Request::get('keyword')]" />
                    <x-system.form.form-inline-group :input="['name' => 'locale', 'label' => 'Locale']">
                        <x-slot name="inputs">
                            <x-system.form.input-select :input="['name' => 'locale', 'label' => 'Locale', 'options' => $locales, 'default' => Request::get('locale') ]" />
                        </x-slot>
                    </x-system.form.form-inline-group>
                    <x-system.form.form-inline-group :input="['name' => 'group', 'label' => 'Group']">
                        <x-slot name="inputs">
                            <x-system.form.input-select :input="['name' => 'group', 'label' => 'Group', 'options' => $groups, 'default' => Request::get('group')]" />
                        </x-slot>
                    </x-system.form.form-inline-group>
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
            <div class="table-responsive mt-3">
                <table id="example" class="table table-striped table-bordered" aria-describedby="translation table">
                    <thead>
                        <tr>
                            <th style="width: 5px;" scope="col">{{translate('S.N')}}</th>
                            <th scope="col" style="white-space:nowrap">{{translate('Item')}}</th>
                            <th scope="col" style="white-space:nowrap">{{translate('Text')}}</th>
                            <th style="width: 10%;white-space:nowrap" scope="col">{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $pageIndex = pageIndex($items); @endphp
                        @forelse($items as $key=>$item)
                        <tr>
                            <td>{{SN($pageIndex, $key)}}</td>
                            <td>{{$item->key}}</td>
                            <td>
                                @if(hasPermission($indexUrl.'/'.$item->id, 'put'))
                                <textarea name="text" class="form-control translation-content" rows="1" data-href="{{url('/'.PREFIX.'/translations/'.$item->id)}}" data-group="{{Request::get('group') ?? 'backend'}}" data-locale="{{Request::get('locale') ?? 'en'}}">{{$item->text[Request::get('locale')] ?? $item->text['en']}}</textarea>
                                @else
                                {{$item->text[Request::get('locale')] ?? $item->text['en']}}
                                @endif

                            </td>
                            <td>
                                @if(hasPermission($indexUrl.'/'.$item->id, 'delete'))
                                @include('system.partials.deleteButton')
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">{{translate('No Data Available')}}</td>
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
            <form method="post" action="{{url($indexUrl)}}">
                <div class="form-row align-items-center">
                    @csrf
                    <input type="hidden" name="group" value="{{ Request::get('group') ?? 'backend' }}" />
                    <x-system.form.form-inline-group :input="['name' => 'key','label' => 'Item', 'required' => true]" />
                    <button class="btn btn-primary" type="submit"><em class="fas fa-save"></em> {{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div><!-- panel -->
    @endif
</div><!-- ends custom-container-fluid -->
@endsection
@section('scripts')
<script>
    let error = `{{ $errors->first('excel_file')}}`
    if (error !== "") {
        $('#uploadExcelModal').modal('show')
    }
</script>
@endsection
