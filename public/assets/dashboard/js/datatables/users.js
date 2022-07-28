let table = $('#ma-admin-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: $(".table").data("url")},
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        // {data: 'image', name: 'image' ,orderable: false, searchable: false},
        {data: 'name', name: 'name'},
        {data: 'phone', name: 'phone'},
        {data: 'address', name: 'address'},
        {data: 'pay_type', name: 'pay_type'},
        // {data: 'related', name: 'related'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    oLanguage: {
        'sUrl': "admin/js/datatables/datatable_ar.json"
    }
});

btn_delete(table);
btn_refresh(table);
