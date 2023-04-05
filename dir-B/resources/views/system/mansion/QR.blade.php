

<div class="container" >
    <h2>{{translate('QRCode')}}</h2>
    <div class="card col-md-12" style="width:400px;align-items: center">
        <div style="text-align: center">
            {!! $qrcode !!}
        </div>
        <div class="card-body">
            <a href="{{url()->previous()}}" class="btn btn-primary">{{translate('Back')}}</a>
        </div>
    </div>
    <br>
</div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
