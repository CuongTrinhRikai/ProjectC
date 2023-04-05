<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="{{ asset('jscolor/jscolor.js')}}"></script>
<script src="{{ asset('compiledCssAndJs/js/system.js')}}"></script>
<script src="{{ asset('toast/jquery.toast.min.js')}}"></script>
<script src="{{ asset('js/axios.js')}}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(function() {
    var check = `{{$errors->first('success')}}`;
    if (check !== "") {
      $.toast({
        heading: `{{translate('success')}}`,
        text: `{{$errors->first('success')}}`,
        showHideTransition: 'plain',
        icon: 'success',
        position: 'top-right',
      });
    }

    let sideBarState = localStorage.getItem('sidebarToggle')
    if (sideBarState == 1) {
      $(".page-wrapper").addClass('toggle-page')
    }
  })

  $(".toggle-button").on('click', function() {
    let sideBarState = localStorage.getItem('sidebarToggle')
    if (sideBarState == 0) localStorage.setItem('sidebarToggle', 1)
    if (sideBarState == 1) localStorage.setItem('sidebarToggle', 0)
    $(".page-wrapper").toggleClass("toggle-page")
  })

  $('.daterange').daterangepicker({
    autoUpdateInput: false,
    locale: {
      cancelLabel: 'Clear'
    }
  });

  $('.daterange').on('apply.daterangepicker', function(ev, picker) {
    $('#from-date').val(picker.startDate.format('YYYY-MM-DD'));
    $('#to-date').val(picker.endDate.format('YYYY-MM-DD'));
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('.datepicker').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoUpdateInput: false,
    locale: {
      format: 'YYYY-MM-DD'
    }
  }, function(start, end, label) {});
</script>
