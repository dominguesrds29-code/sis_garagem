<link href="{{asset('assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('assets/js/loader.js')}}"></script>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

@if ($page_name != 'coming_soon' && $page_name != 'contact_us' && $page_name != 'error404' && $page_name != 'error500' && $page_name != 'error503' && $page_name != 'faq' && $page_name != 'helpdesk' && $page_name != 'maintenence' && $page_name != 'privacy' && $page_name != 'auth_boxed' && $page_name != 'auth_default')
<link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
@endif
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
@switch($page_name)
    @case('calendar')
      {{-- App Calendar --}}
      <link href="{{asset('plugins/fullcalendar/fullcalendar.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('plugins/fullcalendar/custom-fullcalendar.advance.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
      <link href="{{asset('plugins/flatpickr/custom-flatpickr.css')}}" rel="stylesheet" type="text/css">
      <link href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}" rel="stylesheet" type="text/css" />
      <style>

          .widget-content-area { border-radius: 6px; margin-bottom: 10px; }
          .daterangepicker.dropdown-menu {
              z-index: 1059;
          }

      </style>
      @break

    @case('chat')
      {{-- App chat --}}
      <link href="{{asset('assets/css/apps/mailing-chat.css')}}" rel="stylesheet" type="text/css" />
      @break

    @case('contacts')
    @case('listar_viaturas')
      {{-- App contacts --}}
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}">
      <link href="{{asset('plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('assets/css/apps/contacts.css')}}" rel="stylesheet" type="text/css" />
      @break

    @case('mailbox')
      {{-- App Mailbox --}}
      <link rel="stylesheet" type="text/css" href="{{asset('plugins/editors/quill/quill.snow.css')}}">
      <link href="{{asset('assets/css/apps/mailbox.css')}}" rel="stylesheet" type="text/css" />
      <script src="plugins/sweetalerts/promise-polyfill.js"></script>
      <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}" rel="stylesheet" type="text/css" />
      @break

    @case('notes')
      {{-- App Notes --}}
      <link href="{{asset('assets/css/apps/notes.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}" rel="stylesheet" type="text/css" />
      @break

    @case('notifications')
      {{-- Components snackbar --}}
      <link href="{{asset('assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}" rel="stylesheet" type="text/css" />
      @break

    @case('sweet_alerts')
      {{-- Component Sweetalert --}}
      <link href="{{asset('assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('plugins/animate/animate.css')}}" rel="stylesheet" type="text/css" />
      <script src="{{asset('plugins/sweetalerts/promise-polyfill.js')}}"></script>
      <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
      @break

    @case('alerts')
      {{-- Elements Alert --}}
      <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/alert.css')}}">
      <style>
          .btn-light { border-color: transparent; }
      </style>
      @break

    @case('error404')
      {{-- Pages Error 404 --}}
      <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('assets/css/pages/error/style-400.css')}}" rel="stylesheet" type="text/css" />
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
      <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('assets/css/pages/error/style-500.css')}}" rel="stylesheet" type="text/css" />
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
      <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('assets/css/pages/error/style-503.css')}}" rel="stylesheet" type="text/css" />
      <style>
        #content {
            width: 100%;
            margin-top: 0;
            margin-left: 0;
        }
      </style>
      @break

    @case('maintenence')
      {{-- Pages Maintenence --}}
      <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('assets/css/pages/error/style-maintanence.css')}}" rel="stylesheet" type="text/css" />
      <style>
        #content {
            width: 100%;
            margin-left: 0;
        }
      </style>
      @break

    @case('account_settings')
      {{-- User Account Settings --}}
      <link rel="stylesheet" type="text/css" href="{{asset('plugins/dropify/dropify.min.css')}}">
      <link href="{{asset('assets/css/users/account-setting.css')}}" rel="stylesheet" type="text/css" />
      @break

    @case('profile')
      {{-- User Profile --}}
      <link href="{{asset('assets/css/users/user-profile.css')}}" rel="stylesheet" type="text/css" />
      @break

    @default
        <script>console.log('No custom Styles available.')</script>
@endswitch
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
