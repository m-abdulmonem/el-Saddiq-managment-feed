@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @can("create product")
                        <button class="btn btn-info btn-add" data-toggle="modal" data-target="#productsModal"><i class="fa fa-plus"></i> @lang("home.new")</button>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="productsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.name")</th>
                            <th>@lang("$trans.supplier")</th>
                            <th>@lang("$trans.category")</th>
                            <th>@lang("stocks.stock")</th>
                            <th>@lang("$trans.quantity")</th>
                            <th>@lang("$trans.price")</th>
                            <th>@lang("$trans.unit_price")</th>
                            <th>@lang("$trans.piece_weight")</th>
                            <th>@lang("$trans.expired_at")</th>
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

    @include("site.products.modals.index")
    @include("site.products.modals.update_price")
    @push("js")
        {!! datatable_files() !!}
        <script >
            $("#productsTable").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'supplier', name: 'supplier'},
                    {data: 'category', name: 'category'},
                    {data: 'stock', name: 'stock'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'sale_price', name: 'sale_price'},
                    {data: 'price', name: 'price'},
                    {data: 'weight', name: 'weight'},
                    {data: 'expired_at', name: 'expired_at'},
                ],
                url: "{{ route("ajax.products.index") }}",
                actionColumnWidth: "250px",
                data: {
                    category: "{{ request("cat") }}",
                    supplier: "{{ request("suppler") }}",
                    stock: "{{ request("stock") }}",
                    index: true
                }
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
