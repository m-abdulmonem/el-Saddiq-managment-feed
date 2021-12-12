
let query = $(".table"),
    table = $('#ma-admin-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: query.data("url"),
        data: {
            query:  query.data("query")
        }
    },
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'name'},
        {data: 'supplier', name: 'supplier'},
        {data: 'category', name: 'category'},
        {data: 'stock', name: 'stock'},
        {data: 'quantity', name: 'quantity'},
        {data: 'price', name: 'price'},
        {data: 'weight', name: 'weight'},
        {data: 'expired_at', name: 'expired_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    oLanguage: {
        'sUrl': "admin/js/datatables/datatable_ar.json"
    }
});

btn_delete(table);
btn_refresh(table);
