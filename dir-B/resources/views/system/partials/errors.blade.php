@if($errors->any())
@if(!($errors->first('alert-success') || $errors->first('alert-danger') || $errors->first('alert-warning') || $errors->first('success')))
<div class="alert alert-danger" role="alert" style="width: 100%;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    @foreach($errors->all() as $error)
    <p class="" style="margin-bottom: 0px;"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span>&nbsp;{{$error}}</p>
    @endforeach
</div>
@endif
@endif
