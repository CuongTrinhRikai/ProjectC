@extends('system.layouts.listing')
@section('header')
<x-system.search-form :action="url($indexUrl)">
    <x-slot name="inputs">
        <x-system.form.form-inline-group :input="['name' => 'keyword', 'label' => 'Search keyword', 'default' => Request::get('keyword')]" />
        <x-system.form.form-inline-group :input="['name' => 'role', 'label' => 'Role']">
            <x-slot name="inputs">
                <x-system.form.input-select :input="['name' => 'role', 'placeholder' => 'Select role', 'options' => $roles, 'default' => Request::get('role')]" />
            </x-slot>
        </x-system.form.form-inline-group>
    </x-slot>
</x-system.search-form>
@endsection

@section('table-heading')
<tr>
    <th scope="col">{{translate("S.N")}}</th>
    <th scope="col">{{translate('Name')}}</th>
    <th scope="col">{{translate('Role')}}</th>
    <th scope="col">{{translate('Action')}}</th>
</tr>
@endsection

@section('table-data')
@php $pageIndex = pageIndex($items); @endphp
@foreach($items as $key=>$item)
<tr>
    <td>{{SN($pageIndex, $key)}}</td>
    <td>{{ $item->name }}</td>
    <td>
        {{-- <a href="/{{PREFIX}}/roles?keyword={{$item->role->name}}" class="badge badge-secondary"> --}}
            {{-- <a href="" class="badge badge-secondary"> --}}
            {{ translate($item->role->name )}}
        {{-- </a> --}}
    </td>
    <td>
        @include('system.partials.viewButton')
        @include('system.partials.editButton')
        @include('system.partials.deleteButton')
        @if(hasPermission($indexUrl.'/reset-password/'.$item->id, 'post'))
        <x-system.general-modal :url="url($indexUrl.'/reset-password/'.$item->id)" :modalTitle="'Password Reset'" :modalId="'passwordReset'.$item->id"
        :modalTriggerButton="'Reset-Password'" :buttonClass="'btn-success'" :buttonIconClass="'fa-refresh'" :submitButtonTitle="'Reset'">
            <x-slot name="body">
                <input type="hidden" name="id" value="{{$item->id}}">
                @include('system.partials.errors')
                <div class="form-group row">
                    <div class="col-sm-5 col-form-label">
                        <label for="name" class="control-label">{{translate('New Password')}}</label> <span style="color:red;">*</span>
                    </div>
                    <div class="col-sm-7">
                        <input type="password" name="password" class="form-control" autocomplete="off" placeholder="{{translate("Enter your new password")}}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-5 col-form-label">
                        <label for="name" class="control-label">{{translate('Confirm Password')}}</label> <span style="color:red;">*</span>
                    </div>
                    <div class="col-sm-7">
                        <input type="password" name="password_confirmation" class="form-control" autocomplete="off" placeholder="{{translate("Enter your confirm password ")}}" required>
                    </div>
                </div>
            </x-slot>
        </x-system.general-modal>
        @endif
    </td>
</tr>
@endforeach
@endsection
@section('scripts')
<script>

    let error = `{{ $errors->first('password')}}`
    let oldId = `{{ old('id') }}`
    if (error !== "") {
        $('#passwordReset'+oldId).modal('show')
    }

//    $('.closed').click(function(){
//        $('.close').trigger('click');
//        $('#reset-form')[0].reset();
//    });

    $('.closed').click(function(){
        $('.close').trigger('click');
        $('#reset-form')[0].reset();

    });
    $('.exit').on('click', function () {

        $('.close').trigger('click');
        $('#reset-form')[0].reset();

    })

</script>
@endsection
