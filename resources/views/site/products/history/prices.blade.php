@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> {{ trans("home.refresh") }}</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="ma-admin-datatable" class="table table-bordered table-striped" data-url="{{ route('product.prices-history') }}">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans("products.code") }} - {{ trans("products.name") }}</th>
                            <th>{{ trans("products.supplier") }}</th>
                            <th>{{ trans("products_price_history.ton_price") }}</th>
                            <th>{{ trans("products.price") }}</th>
                            <th>{{ trans("products.quantity") }}</th>
                            <th>{{ trans("products_price_history.status") }}</th>
                            <th>{{ trans("products_price_history.difference_value") }}</th>
                            <th>{{ trans("products_price_history.created_at") }}</th>
{{--                            <th>{{ trans("home.actions") }}</th>--}}
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

    @push("js")
        {!! datatable_files() !!}
{{--        <script src="{{ admin_assets("/js/datatables/btn_delete.js") }}"></script>--}}
{{--        <script src="{{ admin_assets("/js/datatables/prices.js") }}"></script>--}}
        <script>
            $("#ma-admin-datatable").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'supplier', name: 'supplier'},
                    {data: 'ton_price', name: 'ton_price'},
                    {data: 'price', name: 'price'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'status', name: 'status'},
                    {data: 'difference_value', name: 'difference_value'},
                    {data: 'created_at', name: 'created_at'}
                ],
                notColumns: [
                    'actions'
                ]
            })
        </script>
    @endpush
@endsection
