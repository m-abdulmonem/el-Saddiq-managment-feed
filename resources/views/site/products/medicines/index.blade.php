@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @can("create $perm")
                        <button class="btn btn-info btn-add" data-toggle="modal" data-target="#medicineModal"><i class="fa fa-plus"></i> @lang("home.new")</button>
                    @endcan
                    @can("update $perm")
                        <button class='btn btn-info btn-purchase'><i class='fas fa-prescription-bottle-alt'></i> @lang("$trans.purchase")</button>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="medicinesTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.code")</th>
                            <th>@lang("$trans.name")</th>
                            <th>@lang("$trans.for")</th>
                            <th>@lang("$trans.quantity")</th>
                            <th>@lang("$trans.sale_price")</th>
                            <th>@lang("$trans.purchase_price")</th>
                            <th>@lang("$trans.profit")</th>
                            <th>@lang("$trans.stock_in")</th>
                            <th>@lang("home.actions")</th>
                        </tr>
                        </thead>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    @include("site.products.medicines.modals.index")
    <div id="app">
        @include("site.products.medicines.modals.purchase")
    </div>

    @push("js")
        {!! datatable_files() !!}
        <script >
            $("#medicinesTable").table({
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                    {data: 'for', name: 'for'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'sale_price', name: 'sale_price'},
                    {data: 'purchase_price', name: 'purchase_price'},
                    {data: 'profit', name: 'profit'},
                    {data: 'stock_in', name: 'stock_in'},
                ],
                url: "{{ route("ajax.products.medicines.index") }}",
                actionColumnWidth: "250px",
            });



            // let data = table.rows().data();
            // for (let i = 0; i< data.length; i++)
            //     console.log(data[i]);
            //
            // // $('#ma-admin-datatable tbody').on( 'click', 'td', function () {
            // //     alert( table.cell( this ).data() );
            // // } );
            //
            // $('#ma-admin-datatable tbody').on( 'click', 'tr', function () {
            //     var d = table.row( this ).data();
            //     // console.log( table.row( this ).data() )
            //     let data = table.rows().data();
            //     for (let i = 0; i< data.length; i++)
            //         console.log(data[i].name);
            // } );

        </script>
    @endpush
@endsection
