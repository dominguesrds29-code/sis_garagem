<link rel="stylesheet" type="text/css" href="{{asset('assets/css/loader.css')}}"/>
<script src="{{asset('assets/js/loader.js')}}"></script>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,600,700">
<link rel="stylesheet" type="text/css" href="{{asset('bootstrap/css/bootstrap.min.css')}}"/>
@if($page_name != 'error404' && $page_name != 'error500' && $page_name != 'error503')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/scrollspyNav.css')}}"/>
@endif
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
@switch($page_name)

    @case('error404')
    {{-- Pages Error 404 --}}
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/error/style-400.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #content {
            width: 100%;
            margin-top: 0;
            margin-left: 0;
        }
    </style>
    @break

    @case('error500')
    {{-- Pages Error 500 --}}
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/error/style-500.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #content {
            width: 100%;
            margin-top: 0;
            margin-left: 0;
        }
    </style>
    @break

    @case('error503')
    {{-- Pages Error 503 --}}
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/error/style-503.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #content {
            width: 100%;
            margin-top: 0;
            margin-left: 0;
        }
    </style>
    @break

    @default
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/apex/apexcharts.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/animate/animate.css')}}"/>

    {{-- SweetAlert2 --}}
    <script src="{{asset('plugins/sweetalerts/promise-polyfill.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/sweetalerts/sweetalert.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}"/>

    {{-- Forms --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/switches.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}"/>

    {{-- Notification --}}
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">

    {{-- Alert --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/alert.css')}}">

    {{-- TagInput --}}
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/tagInput/tags-input.css')}}"/>

    {{-- Font Icons --}}
    <link rel="stylesheet" href="{{asset('plugins/font-icons/fontawesome/css/regular.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/font-icons/fontawesome/css/fontawesome.css')}}">

    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">

    {{-- Select2 --}}
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">

    {{--Auto omplete--}}
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/autocomplete/autocomplete.css')}}"/>

    {{-- Elements --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/avatar.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/breadcrumb.css')}}"/>

    {{-- Custom --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom.css')}}"/>
@endswitch
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
