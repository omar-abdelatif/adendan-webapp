{{-- ! Google font ! --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/aquawolf04/font-awesome-pro@5cd1511/css/all.css"/>
{{-- ! Font Awesome ! --}}
{{-- ! ico-font ! --}}
<link rel="stylesheet" href="{{asset('assets/css/vendors/icofont.css')}}">
{{-- ! Themify icon ! --}}
<link rel="stylesheet" href="{{asset('assets/css/vendors/themify.css')}}">
{{-- ! Feather icon ! --}}
<link rel="stylesheet" href="{{asset('assets/css/vendors/feather-icon.css')}}">
{{-- ! Plugins css start ! --}}
@yield('css')
<link rel="stylesheet" href="{{asset('assets/css/vendors/scrollbar.css')}}">
{{-- ! Bootstrap css ! --}}
<link rel="stylesheet" href="{{asset('assets/css/vendors/bootstrap.css')}}">
{{-- ! App css ! --}}
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
{{-- ! Responsive ! --}}
<link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
{{-- ! Datatables ! --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
{{-- ! Date Picker ! --}}
<link rel="stylesheet" href="{{asset('assets/css/vendors/date-picker.css')}}">
{{-- ! Include Css Files ! --}}
@yield('style')
{{-- ! Custom css ! --}}
<link rel="stylesheet" href={{asset('assets/css/custom.css')}}>
