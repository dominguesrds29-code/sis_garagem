const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.options({
    processCssUrls: false
});

/*
    ========================
            Assets
    ========================
*/

mix.sass('resources/sass/assets/structure.scss', 'public/assets/css/')
    .sass('resources/sass/assets/loader.scss', 'public/assets/css/')
    .sass('resources/sass/assets/main.scss', 'public/assets/css/')
    .sass('resources/sass/assets/scrollspyNav.scss', 'public/assets/css/')

    // Authentication
    .sass('resources/sass/assets/authentication/form-1.scss', 'public/assets/css/authentication')
    .sass('resources/sass/assets/authentication/form-2.scss', 'public/assets/css/authentication')

    // Element
    .sass('resources/sass/assets/elements/alert.scss', 'public/assets/css/elements/')
    .sass('resources/sass/assets/elements/avatar.scss', 'public/assets/css/elements/')
    .sass('resources/sass/assets/elements/breadcrumb.scss', 'public/assets/css/elements/')

    // Forms
    .sass('resources/sass/assets/forms/bootstrap-form.scss', 'public/assets/css/forms/')
    .sass('resources/sass/assets/forms/custom-clipboard.scss', 'public/assets/css/forms/')
    .sass('resources/sass/assets/forms/switches.scss', 'public/assets/css/forms/')
    .sass('resources/sass/assets/forms/theme-checkbox-radio.scss', 'public/assets/css/forms/')

    // Pages
    .sass('resources/sass/assets/pages/error/style-400.scss', 'public/assets/css/pages/error/')
    .sass('resources/sass/assets/pages/error/style-500.scss', 'public/assets/css/pages/error/')
    .sass('resources/sass/assets/pages/error/style-503.scss', 'public/assets/css/pages/error/')

    // Tables
    .sass('resources/sass/assets/tables/table-basic.scss', 'public/assets/css/tables/')

    // Users
    .sass('resources/sass/assets/users/account-setting.scss', 'public/assets/css/users/')
    .sass('resources/sass/assets/users/user-profile.scss', 'public/assets/css/users/')

    // Widgets
    .sass('resources/sass/assets/widgets/modules-widgets.scss', 'public/assets/css/widgets/')

    /*
        ========================
                Plugins
        ========================
    */

    // Animate
    .sass('resources/sass/plugins/animate/animate.scss', 'public/plugins/animate/')

    // Autocomplete
    .sass('resources/sass/plugins/autocomplete/autocomplete.scss', 'public/plugins/autocomplete/')

    // Perfect Scrollbar
    .sass('resources/sass/plugins/perfect-scrollbar/perfect-scrollbar.scss', 'public/plugins/perfect-scrollbar/')

    // DataTable
    .sass('resources/sass/plugins/table/datatable/custom_dt_custom.scss', 'public/plugins/table/datatable/')
    .sass('resources/sass/plugins/table/datatable/custom_dt_html5.scss', 'public/plugins/table/datatable/')
    .sass('resources/sass/plugins/table/datatable/custom_dt_miscellaneous.scss', 'public/plugins/table/datatable/')
    .sass('resources/sass/plugins/table/datatable/custom_dt_multiple_tables.scss', 'public/plugins/table/datatable/')
    .sass('resources/sass/plugins/table/datatable/datatables.scss', 'public/plugins/table/datatable/')
    .sass('resources/sass/plugins/table/datatable/datatables-light.scss', 'public/plugins/table/datatable/')
    .sass('resources/sass/plugins/table/datatable/dt-global_style.scss', 'public/plugins/table/datatable/')
    .sass('resources/sass/plugins/table/datatable/dt-global_style-light.scss', 'public/plugins/table/datatable/')

    // SweetAlerts
    .sass('resources/sass/plugins/sweetalerts/sweetalert.scss', 'public/plugins/sweetalerts/')
    .sass('resources/sass/plugins/sweetalerts/sweetalert2.min.scss', 'public/plugins/sweetalerts/')

    // Tag Input
    .sass('resources/sass/plugins/tagInput/tags-input.scss', 'public/plugins/tagInput/')

    .scripts([
        'resources/assets/js/libs/jquery-3.1.1.min.js',
        'resources/bootstrap/js/popper.min.js',
        'resources/bootstrap/js/bootstrap.js',
    ], 'public/assets/js/libs/core.js')

    .scripts('resources/plugins/table/datatable/datatables.js', 'public/plugins/table/datatable/datatables.js')
    .scripts('resources/plugins/sweetalerts/sweetalert2.min.js', 'public/plugins/sweetalerts/sweetalert2.min.js')
    .scripts('resources/plugins/sweetalerts/sweetalert.js', 'public/plugins/sweetalerts/sweetalert.js')
    .scripts('resources/plugins/sweetalerts/promise-polyfill.js', 'public/plugins/sweetalerts/promise-polyfill.js')
    .scripts('resources/plugins/blockui/jquery.blockUI.min.js', 'public/plugins/blockui/jquery.blockUI.min.js')
    .scripts('resources/assets/js/authentication/form-1.js', 'public/assets/js/authentication/form-1.js')
    .scripts('resources/assets/js/authentication/form-2.js', 'public/assets/js/authentication/form-2.js')
    .scripts('resources/assets/js/loader.js', 'public/assets/js/loader.js')
    .scripts('resources/assets/js/ui-accordions.js', 'public/assets/js/ui-accordions.js')
    .scripts('resources/assets/js/scrollspyNav.js', 'public/assets/js/scrollspyNav.js')
    .scripts('resources/assets/js/app.js', 'public/assets/js/app.js')
    .scripts('resources/assets/js/custom.js', 'public/assets/js/custom.js')
    .scripts('resources/assets/js/set-plugins.js', 'public/assets/js/set-plugins.js')
    .scripts('resources/assets/js/quill-custom.js', 'public/assets/js/quill-custom.js')

    .styles('resources/bootstrap/css/bootstrap.min.css', 'public/bootstrap/css/bootstrap.min.css')
    .styles('resources/assets/css/plugins.css', 'public/assets/css/plugins.css')
    .styles('resources/assets/css/app.css', 'public/assets/css/app.css')
    .styles('resources/assets/css/elements/infobox.css', 'public/assets/css/elements/infobox.css')
    .styles('resources/assets/css/elements/custom-accordions.css', 'public/assets/css/elements/custom-accordions.css')

    .copyDirectory('resources/plugins/apex', 'public/plugins/apex')
    .copyDirectory('resources/plugins/blockui', 'public/plugins/blockui')
    .copyDirectory('resources/plugins/bootstrap-select', 'public/plugins/bootstrap-select')
    .copyDirectory('resources/plugins/select2', 'public/plugins/select2')
    .copyDirectory('resources/plugins/flatpickr', 'public/plugins/flatpickr')
    .copyDirectory('resources/plugins/font-icons', 'public/plugins/font-icons')
    .copyDirectory('resources/plugins/highlight', 'public/plugins/highlight')
    .copyDirectory('resources/plugins/perfect-scrollbar', 'public/plugins/perfect-scrollbar')
    .copyDirectory('resources/plugins/notification', 'public/plugins/notification')
    .copyDirectory('resources/plugins/input-mask', 'public/plugins/input-mask')
    .copyDirectory('resources/plugins/editors/quill', 'public/plugins/quill')
    .copyDirectory('resources/assets/css/error', 'public/assets/css/error')
    .copyDirectory('resources/assets/img', 'public/assets/img')

    .version()
;
