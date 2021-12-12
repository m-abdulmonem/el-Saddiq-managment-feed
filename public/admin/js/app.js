$(function () {

    $("body").keyup(function (e) {
        if (e.altKey && e.keyCode === 67)
            window.open('Calculator:///');
        else if (e.altKey && e.keyCode === 78)
            window.location.href = "/clients/invoices/create";
    });

    $(".btn-calculator").click(function () {
        window.open('Calculator:///');
    });

    $('[data-toggle="tooltip"]').tooltip();

    $(".form-control").change(function () {
        if ($(this).val().length > 0 && $(this).hasClass("is-invalid")){
            $(this).removeClass("is-invalid").next(".alert").hide()
        }

    });

    /**
     * modal window events
     */
    $(".btn-close,.close").click(function () {
        if($(".modal-form").length > 0)
            ($(".modal-form").find("button[type=submit]").data("update"))
                ? $(`#item-${$("#id").val()}`).removeSpanner()
                :$(".btn-add").removeSpanner();
    });


    /**
     * Set file uploaded in [img-el]
     */
    $(".upload").change(function() {
        previewImg(this, validate(this));
    });

});


function ajaxApi(options) {
    let defaults = {
        url: "",
        data: {},
        type : "get",
        create: false,
        success: function (data) {

        },
        notFound: ""
    },settings;

    settings= $.extend(defaults,options);
   // contentType: false,
   //  cache: false,
   //  processData: false,
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },

        url: settings.url,
        data: settings.data,
        type: settings.type,
        dataType: "json",
        success: function (res) {
            if(typeof settings.success == 'function') {
                settings.success(res);
            }
        },
        statusCode: {
            403: function (xhr) {
                swal("عفوا لاتملك صلاحية الدخول",{
                    'icon' : "error",
                    'timer' : 2500
                })
            },
            422: function (xhr) {
                let errors = JSON.parse(xhr.responseText).errors;
                $.each(errors,function (k,v) {
                    $(`#${k}`).addClass("is-invalid").parent()
                        .children(".alert")
                        .text( JSON.stringify( v[0] ).replace(/["]/g,"") )
                        .show()
                })
            },
            404: function (xhr) {
                if (typeof  settings.notFound == 'function'){
                    settings.notFound()
                }else {
                    swal(settings.notFound,{
                        'icon' : "error",
                        'timer' : 2500
                    });
                }
            },
            500: function (xhr) {
                swal(xhr.responseJSON.message,{
                    'icon' : "error",
                    'timer' : 2500
                });
            }
        }
    })
}

/**
 * Preview img before upload it
 *
 * @param input
 * @param img
 */
function previewImg(input,img) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $(img).attr('src', e.target.result).show();
        };

        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Validate Preview Image Selector
 *
 * @param selector
 * @returns {null|*|undefined|jQuery}
 */
function validate(selector) {
    return  $(selector).parent().prev().attr('id')
        ? '#' + $(selector).parent().prev().attr('id')
        : $(selector).parent().prev().attr('class')
            ? '.' + $(selector).parent().prev().attr('class')
            : '.preview-img';
}

