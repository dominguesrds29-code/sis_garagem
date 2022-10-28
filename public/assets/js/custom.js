/*
=========================================
|                                       |
|           Scroll To Top               |
|                                       |
=========================================
*/
$('.scrollTop').click(function() {
    $("html, body").animate({scrollTop: 0});
});


$('.navbar .dropdown.notification-dropdown > .dropdown-menu, .navbar .dropdown.message-dropdown > .dropdown-menu ').click(function(e) {
    e.stopPropagation();
});

/*
=========================================
|                                       |
|       Multi-Check checkbox            |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

    var checker = $('#' + clickchk);
    var multichk = $('.' + relChkbox);


    checker.click(function () {
        multichk.prop('checked', $(this).prop('checked'));
    });
}


/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

/*
    This MultiCheck Function is recommanded for datatable
*/

function multiCheck(tb_var) {
    tb_var.on("change", ".chk-parent", function() {
        var e=$(this).closest("table").find("td:first-child .child-chk"), a=$(this).is(":checked");
        $(e).each(function() {
            a?($(this).prop("checked", !0), $(this).closest("tr").addClass("active")): ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
        })
    }),
    tb_var.on("change", "tbody tr .new-control", function() {
        $(this).parents("tr").toggleClass("active")
    })
}

/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

    var checker = $('#' + clickchk);
    var multichk = $('.' + relChkbox);


    checker.click(function () {
        multichk.prop('checked', $(this).prop('checked'));
    });
}

/*
=========================================
|                                       |
|               Tooltips                |
|                                       |
=========================================
*/

$('.bs-tooltip').tooltip();

/*
=========================================
|                                       |
|               Popovers                |
|                                       |
=========================================
*/

$('.bs-popover').popover();


/*
================================================
|                                              |
|               Rounded Tooltip                |
|                                              |
================================================
*/

$('.t-dot').tooltip({
    template: '<div class="tooltip status rounded-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
})


/*
================================================
|            IE VERSION Dector                 |
================================================
*/

function GetIEVersion() {
  var sAgent = window.navigator.userAgent;
  var Idx = sAgent.indexOf("MSIE");

  // If IE, return version number.
  if (Idx > 0)
    return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));

  // If IE 11 then look for Updated user agent string.
  else if (!!navigator.userAgent.match(/Trident\/7\./))
    return 11;

  else
    return 0; //It is not IE
}

/*
================================================
|                MESSAGES                      |
================================================
*/

function showConfirm(title, text, type, okButton, cancelButton, route, method, reload = false) {
    Swal.fire({
        title: title,
        html: text,
        type: type,
        showCancelButton: true,
        confirmButtonText: okButton,
        cancelButtonText: cancelButton,
        confirmButtonColor: '#1abc9c',
        cancelButtonColor: '#dd4b39',
        reverseButtons: true,
        preConfirm: () => {
            return $.ajax({
                url: route,
                type: method,
                dataType: 'JSON',
            });
        },
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.value) {
            if(result.value.error){
                Swal.fire(result.value.error.title, result.value.error.text, result.value.error.type);
            } else {
                if(reload == true){
                    Swal.fire(result.value.message.title, result.value.message.text, result.value.message.type).then((result) => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire(result.value.message.title, result.value.message.text, result.value.message.type);
                    $('tr[id="' + result.value.id + '"]').fadeOut('slow', function () {
                        $(this).remove();
                    })
                }

            }
        }
    });
}

function showMessage(title, text, type) {
    Swal.fire({
        title: title,
        html: text,
        type: type
    });
}

/*
================================================
|                NOTIFICATIONS                      |
================================================
*/

function showNotification(text, color, position, actiontext, actiontextcolor, delay) {
    Snackbar.show({
        text: text,
        backgroundColor: color,
        pos: position,
        actionText: actiontext,
        actionTextColor: actiontextcolor,
        duration: delay
    });
}
