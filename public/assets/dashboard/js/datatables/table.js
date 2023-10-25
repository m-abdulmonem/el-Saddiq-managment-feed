
let spanner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span>إنتظر....</span>',
    $name,dataTable;

/**
 *
 * @param table
 */
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
                            }else{
                                if (Array.isArray(result.msg)){
                                    $.each(data,function (k,v) {
                                        toastr.error(v,{
                                            title: "خطأ فى بيانات الإدخال",
                                            delay: 3000
                                        })
                                    })
                                } else
                                    toastr.error(result.msg,{
                                        title: "خطأ فى الحذف",
                                        delay: 3000
                                    });
                                _this.removeSpanner();
                            }
                        },
                        error:function (x,y) {

                        }
                    });
                }else
                    _this.removeSpanner();
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

                                if (table)
                                    table.draw();
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

/**
 *
 * @param table
 */
function btn_refresh(table) {

    $(".btn-refresh").click(function () {
        $(this).children("a").hide().parent().attr("disabled","disabled")
            .append(spanner);
        if (table.draw())
            $(this).removeAttr("disabled").children("span").hide().parent().children("a").show();
    })
}

function getTable (dataTable){
    return dataTable
}

$.fn.extend({

    table: function(data = null){
        let table= $(".table"),
            setting = $.extend({
            columns: [],
            notColumns: [],
            data: null,
            actionOptions: {},
            url: table.data("url"),
            actionColumnWidth: "177.006px",
            buttons:  [
                {
                    extend: 'print',
                    text: "<i class='fa fa-print'></i> طباعة",
                    className : "btn btn-info",
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' )
                            .prepend(
                                '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                            );

                        $(win.document.body).find( 'table' )
                            .find('td:last-child, th:last-child')
                            .remove();

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    },
                    exportOptions: {
                        columns: [":visible"]
                    }
                },{
                    extend:  "pageLength",
                    customize: function (win){
                        console.log($(win.document.body).find("buttons-page-length"))
                    },
                    text: "إظهار 10 من"
                },

                'colvis'
            ],
            searching: true,
            dom: 'Bfrtip',
            "paging": true,
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        },data);


        if (!setting.notColumns.includes("#"))
            //add table row indexed
            setting.columns.unshift({data: 'DT_RowIndex',  orderable: false, searchable: false });

        if (!setting.notColumns.includes("actions"))
            //add  row actions cell
            setting.columns.push({
                data: 'action', name: 'action', orderable: false, searchable: false, width: setting.actionColumnWidth
            });


        let datatable = $(this).DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: setting.url,
                data: setting.data ? setting.data : {data:table.data("query")}
            },
            columns: setting.columns,
            buttons: setting.buttons,
            "searching": setting.searching,
            oLanguage: {
                "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
                "sLoadingRecords": "جارٍ التحميل...",
                "sProcessing":   "جارٍ التحميل...",
                "sLengthMenu":   "أظهر _MENU_ مدخلات",
                "sZeroRecords":  "لم يعثر على أية سجلات",
                "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix":  "",
                "sSearch":       "ابحث:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "الأول",
                    "sPrevious": "السابق",
                    "sNext":     "التالي",
                    "sLast":     "الأخير"
                },
                "oAria": {
                    "sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً",
                    "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                }
            }
        });

        btn_delete(datatable);
        btn_refresh(datatable);
        getTable(datatable);

        dataTable = datatable;



        return datatable;
    },
    getTable: function (){
        return dataTable
    },
    spanner: function (options) {
        let settings = $.extend({
            text: true,
            icon: true
        },options);
        spanner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span> ${ settings.text ? "إنتظر....":"" } </span>`;
        $name = $(this).html();
        $(this).addClass("disabled").html(spanner);
        return this;
    },
    removeSpanner: function () {
        $(this).removeClass("disabled").html($name);
        return this;
    }
});




