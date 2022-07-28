let table = $('#ma-admin-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: $(".table").data("url")},
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'name'},
        {data: 'supplier', name: 'supplier'},
        {data: 'ton_price', name: 'ton_price'},
        {data: 'price', name: 'price'},
        {data: 'quantity', name: 'quantity'},
        {data: 'quantity_consumed', name: 'quantity_consumed'},
        {data: 'consumption', name: 'consumption'},
        {data: 'created_at', name: 'created_at'}
    ],
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

btn_delete(table);
btn_refresh(table);
