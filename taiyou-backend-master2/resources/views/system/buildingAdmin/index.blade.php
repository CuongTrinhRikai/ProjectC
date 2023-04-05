@extends('system.layouts.listing')
@section('header')
    <x-system.search-form :action="$indexUrl">
        <x-slot name="inputs">
            <x-system.form.form-inline-group :input="['name' => 'keyword', 'placeholder' => 'Keyword', 'default' => Request::get('keyword')]"></x-system.form.form-inline-group>
        </x-slot>
    </x-system.search-form>
@endsection
@section('table-heading')
    <tr>
        <th scope="col" style="white-space: nowrap">{{translate('S.N')}}</th>
        <th scope="col" style="white-space: nowrap;">{{translate('Building Admin Name')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Building Admin ID')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Contractor')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Business Category')}}</th>
        <th scope="col" style="white-space: nowrap">{{translate('Action')}}</th>
    </tr>
@endsection
@section('table-data')
    @php $pageIndex = pageIndex($items); @endphp
    @foreach($items as $key=>$item)
        <tr>

            <td>{{SN($pageIndex, $key)}}</td>
            <td style="white-space: normal;">{{ $item->name }}</td>
            <td style="white-space: normal;">{{ $item->username }}</td>
            <td style="white-space: normal;">{{ $item->contractor->company_name.''.'('.$item->contractor->contractorId.')' ?? '-' }}</td>
            <td>
                @foreach($item->business_category as $value)
                    <ul class="pl-2" style="white-space: normal">
                        <li>{{ $business[$value] ?? '-' }}
                        </li>
                    </ul>
                @endforeach
            </td>
            <td>
                @section('delete')
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <form method="post">
                                <div class="modal-content">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{translate('Confirm Delete')}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{translate('Deleting the Building admin will remove the users check-in/check-out history. Are you sure you want to delete?')}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                                            <em class="glyph-icon icon-close"></em> {{translate('Cancel')}}
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-danger" id="confirmDelete">
                                            <em class="glyph-icon icon-trash"></em> {{translate('Delete')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @show

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
                                    <input type="password" name="password" class="form-control clearFields"  autocomplete="off" placeholder="{{translate("Enter your new password")}}" required>
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
                @if(hasPermission($indexUrl.'/reset-token/'.$item->id, 'get'))
                @include('system.partials.tokenButton')
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
