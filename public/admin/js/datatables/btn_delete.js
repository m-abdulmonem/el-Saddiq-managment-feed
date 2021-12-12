
let spanner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span>إنتظر....</span>';

function btn_delete(table) {
    /**
     * delete validate
     */
    $("body").on("click",".btn-delete",function () {
        let _this = $(this);
        _this.attr("disabled","disabled").append(spanner);
        swal({
            title: _this.data("title"),
            text: _this.data("text"),
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: _this.data("url"),
                        data:{_token:_this.data("token")},
                        type: "DELETE",
                        dataType: "json",
                        success: function (result) {
                            if (result.status === 1) {
                                swal(result.msg, {
                                    icon: "success",
                                    timer: 1490
                                });

                                if (table)
                                    table.draw();
                            }
                        },
                        error:function (x,y) {

                        }
                    });
                }else
                    _this.removeAttr("disabled").children("span").hide();
            });
    });
    $(".btn-delete").click(function () {
        let _this = $(this);
        _this.children("a").hide().parent().attr("disabled","disabled")
            .append(spanner);
        swal({
            title: _this.data("title"),
            text: _this.data("text"),
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: _this.data("url"),
                        data:{_token:_this.data("token")},
                        type: "DELETE",
                        dataType: "json",
                        success: function (result) {
                            if (result.status === 1) {
                                swal(result.msg, {
                                    icon: "success",
                                    timer: 1490
                                });

                                if (table) table.draw();
                                else
                                    setTimeout(function () {
                                        location.href = _this.data("back")
                                    }, 1500)


                            }
                        },
                        error:function (x,y) {

                        }
                    });
                }else
                    _this.removeAttr("disabled").children("span").hide().parent().children("a").show();
            });
    })
}

function btn_refresh(table) {

    $(".btn-refresh").click(function () {
        $(this).children("a").hide().parent().attr("disabled","disabled")
            .append(spanner);
        if (table.draw())
            $(this).removeAttr("disabled").children("span").hide().parent().children("a").show();
    })
}

/**
 * spanner
 */

$.fn.extend({
    spanner: function () {
         $name = $(this).html();
         $(this).addClass("disabled").html(spanner);
         return this;
    },
    removeSpanner: function () {
        $(this).removeClass("disabled").html($name);
        return this;
    }
});

