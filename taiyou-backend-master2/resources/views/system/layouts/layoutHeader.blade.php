<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="msapplication-TileColor" content="#ffffff">
<link href="{{ asset('images/favicon.png') }}" rel="shortcut icon">
<meta name="theme-color" content="#ffffff">
<meta name="csrf" content="{{csrf_token()}}">

<title>{{ translate($title) ?? 'EkCms' }}</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/f0dad6a07d.js" crossorigin="anonymous"></script>
<link href="{{ asset('compiledCssAndJs/css/system.css')}}" rel="stylesheet" media="screen">
<link href="{{ asset('toast/jquery.toast.min.css')}}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script src="{{asset('tinymce/tinymce.min.js')}}"></script>

</head>
