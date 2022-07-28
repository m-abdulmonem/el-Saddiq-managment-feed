let table = $('#ma-admin-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: $(".table").data("url")},
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},

        {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    oLanguage: {
        'sUrl': "admin/js/datatables/datatable_ar.json"
    }
});

btn_delete(table);
btn_refresh(table);
