<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>

@if ($page_name != 'coming_soon' && $page_name != 'contact_us' && $page_name != 'error404' && $page_name != 'error500' && $page_name != 'error503' && $page_name != 'faq' && $page_name != 'helpdesk' && $page_name != 'maintenence' && $page_name != 'privacy' && $page_name != 'auth_boxed' && $page_name != 'auth_default')
<script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{asset('assets/js/scrollspyNav.js')}}"></script>
<script src="{{asset('plugins/highlight/highlight.pack.js')}}"></script>
<script src="{{asset('plugins/font-icons/feather/feather.min.js')}}"></script>
<script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
@endif
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@switch($page_name)
   @case('calendar')
      {{-- App Calendar --}}
      <script src="{{asset('plugins/fullcalendar/moment.min.js')}}"></script>
      <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
      <script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
      <script src="{{asset('plugins/fullcalendar/custom-fullcalendar.advance.js')}}"></script>
      @break

    @case('chat')
      {{-- App Chat --}}
      <script src="{{asset('assets/js/apps/mailbox-chat.js')}}"></script>
      @break

    @case('contacts')
    @case('listar_viaturas')
      {{-- App Contact --}}
      <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
      @break

    @case('mailbox')
      {{-- App Mailbox --}}
      <script src="{{asset('assets/js/ie11fix/fn.fix-padStart.js')}}"></script>
      <script src="{{asset('plugins/editors/quill/quill.js')}}"></script>
      <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
      <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
      <script src="{{asset('assets/js/apps/custom-mailbox.js')}}"></script>
      @break

    @case('notes')
      {{-- App Notes --}}
      <script src="{{asset('assets/js/ie11fix/fn.fix-padStart.js')}}"></script>
      <script src="{{asset('assets/js/apps/notes.js')}}"></script>
      @break

    @case('notifications')
      {{-- Compoents Snackbar --}}
      <script src="{{asset('assets/js/scrollspyNav.js')}}"></script>
      <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
      <script src="{{asset('assets/js/components/notification/custom-snackbar.js')}}"></script>
      <script>
          // Get the Toast button
          var toastButton = document.getElementById("toast-btn");
          // Get the Toast element
          var toastElement = document.getElementsByClassName("toast")[0];

          toastButton.onclick = function() {
              $('.toast').toast('show');
          }
      </script>
      @break

    @case('sweet_alerts')
      {{-- Components Sweetalerts --}}
      <script src="{{asset('assets/js/scrollspyNav.js')}}"></script>
      <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
      <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
      @break

    @case('account_settings')
      {{-- User Account Setting  --}}
      <script src="{{asset('plugins/dropify/dropify.min.js')}}"></script>
      <script src="{{asset('plugins/blockui/jquery.blockUI.min.js')}}"></script>
      <script src="{{asset('assets/js/users/account-settings.js')}}"></script>
      @break

    @default
    <script>console.log('No custom script available.')</script>
@endswitch
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
