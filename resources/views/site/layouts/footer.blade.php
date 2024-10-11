
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        V3.1
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2017-2020 <a href="https://maadmin.com">MAAdmin.com</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<script>
    const formatter  = Intl.NumberFormat("ar-EG",{
        'style' : 'currency',
        currency: 'EGP',
        minimumFractionDigits: 2
    });
</script>
<!-- jQuery -->
<script src="{{ admin_assets("/jquery.min.js") }}" ></script>
<!-- Bootstrap 4 -->
<script src="{{ admin_assets("/bootstrap.bundle.min.js") }}"></script>
<script src="{{ admin_assets("/moment.min.js") }}"></script>
<script src="{{ admin_assets("/sweetalert.min.js") }}"></script>
<!-- toastr -->
<script src="{{ admin_assets("/toastr.min.js") }}"></script>
@stack("js")
<!-- AdminLTE App -->
<script src="{{ admin_assets("/adminlte.min.js") }}"></script>

<script src="{{ admin_assets("/app.js") }}"></script>

<script>
    setTimeout(function () {
        // notification(true)
    });
    setInterval(function () {
        $(".notify-list").empty();
        // notification()
    },(1000* 60 * 5));

    $("body").on("click",".btn-notify",function (e) {
        e.preventDefault();
        ajaxApi({
            url: `/ajax/users/mark/notification/${$(this).data("id")}`,
            type: "put",
            success :function (data) {
                if (data.code === 1){
                    $(this).remove();
                    $(".notify-count").text( (parseInt($(".notify-count").text()) - 1));

                    if (parseInt($(".notify-count").text()) === 0) $(".notify-count").hide();
                }
            }
        })
    });

    $('[data-dismiss="modal"]').on('click', function() {
        // This will find the closest parent with class 'modal'
        var modalParent = $(this).closest('.modal');

        modalParent.modal('hide');
    });
    $(".modal").on("hidden.bs.modal", function () {
        console.log('on modal closed')
       $('.modal-backdrop').remove()
    });

    // ""ajax.users.expired.notifications""
    // function notification(timeOut = false) {
    //     ajaxApi({
    //         url:
    // ,
    //         success: function (data) {
    //             (parseInt($(".notify-count").text()) === 0) ? $(".notify-count").hide() : $(".notify-count").text(data[0].length).show();
    //             $.each(data[0],function (k,v) {
    //                 $(".notify-list").prepend(`<span class="dropdown-item btn-notify" style="cursor: pointer" data-id='${v.id}'>
    //                                                 <i class="fas fa-hourglass-end mr-2"></i> <span class="notification-text">${v.text}</span>
    //                                                 <span class="float-right text-muted text-sm">${(v.since === 0 ? 'اقل من يوم' : v.since + " يوم ")}  </span>
    //                                           </span><div class="dropdown-divider"></div>`);
    //                 toastr.warning(v.text)
    //             });
    //         }
    //     })
    // }
</script>


</body>
</html>
