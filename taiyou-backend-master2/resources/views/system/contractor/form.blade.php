@extends('system.layouts.form')
@section('inputs')

    <x-system.form.form-group
        :input="['name' => 'company_name', 'label' => 'Contractor Company Name','placeholder'=> translate('Contractor Company Name'),'default'=> old('company_name') ?? $item->company_name ?? old('company_name'), 'error' => $errors->first('company_name'),'label-required'=>'true']" />
    <x-system.form.form-group
        :input="['name' => 'contractorId', 'label' => 'Contractor ID','default'=>old('contractorId') ??  $item->contractorId ?? old('contractorId'), 'error' => $errors->first('contractorId'),'label-required'=>'true']" />

    <div class="form-group row" id="">
        <label for="sales_staff" class="col-sm-2 col-form-label ">
           {{translate('Sales Staff')}}
        </label>
        <div class="col-sm-6">
            {{ Form::select('sales_staff[]',$sales_staff,isset($selected)? $selected : null,['class'=>'form-control sales_staff', 'multiple' => 'multiple']) }}
            @error('sales_staff')
            <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>
            @enderror
        </div>
    </div>
    <div class="form-group row" id="">
        <label for="sales_affair" class="col-sm-2 col-form-label ">
           {{translate('Sales Affair')}}
        </label>
        <div class="col-sm-6">
            {{ Form::select('sales_affair[]',$sales_affair,isset($selected)? $selected : null,['class'=>'form-control sales_affair', 'multiple' => 'multiple']) }}
            @error('Sales Affair')
            <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>
            @enderror
        </div>
    </div>
    <div class="form-group row" id="">
        <label for="company_general_affair" class="col-sm-2 col-form-label ">
           {{translate('Company General Affair')}}
        </label>
        <div class="col-sm-6">
            {{ Form::select('company_general_affair[]',$company_general_affair,isset($selected)? $selected : null,['class'=>'form-control company_general_affair', 'multiple' => 'multiple']) }}
            @error('company_general_affair')
            <p class="invalid-text text-danger" style="text-align: left;font-size: 80%">{{translate($message)}}</p>
            @enderror
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.sales_staff').select2({
                placeholder: `{{ translate('Select A Sales Staff') }}`
            });
            $('.sales_affair').select2({
                placeholder: `{{ translate('Select A Sales Affair') }}`
            });
            $('.company_general_affair').select2({
                placeholder: `{{ translate('Select A Company General Affair') }}`
            });
        });

    </script>
@endsection
