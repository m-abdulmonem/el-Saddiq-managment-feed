@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
        <link rel="stylesheet" type="text/css" href="{{ admin_assets("daterangepicker.css") }}" />
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("products/products.main_info")</h3>
                    <a class='btn btn-primary' title='@lang("stocks.stocktaking")' href='{{route("ajax.stocks.print.stocktaking",$stock->id)}}'>
                        <i class='fa fa-layer-group'></i> @lang("stocks.stocktaking")</a>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body d-flex">
                    <div class="col-6">
                        <ul class="main-info list-ar-numeric">
                            <li class="odd">@lang("$trans.name") : <span>{{$stock->name}}</span></li>
                            <li class="even">@lang("$trans.address") : <span>{{$stock->address}}</span></li>
                            <li><span class="title even">@lang("balances.gain")</span> {{currency($stock->debt()->sum("gain"))}}</li>
                            <li><span class="title odd">@lang("balances.loss")</span> {{ currency($stock->debt()->sum("loss")) }}</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="main-info list-ar-numeric">
                            <li><span class="title even">@lang("products/products.remaining_quantity")</span> {{ $stock->remainingQuantity() }}</li>
                            <li><span class="title odd">@lang("products/products.expired")</span> {{num_to_ar($stock->expired())}}</li>
                            <li><span class="title even">@lang("products/products.quantity")</span> {{num_to_ar($stock->clientProducts()->sum("quantity"))}}</li>
                            <li><span class="title odd">@lang("products/products.returned_quantity")</span> {{num_to_ar($stock->clientProductsReturn()->sum("quantity"))}}</li>
                        </ul>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- ./main info -->
        <div class="col-12">
            @include("graph.stock.index")
        </div>
        <!-- ./col -->

        <!-- ./products-list -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("products/products.title")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped " id="productsTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("products/products.name")</th>
                            <th>@lang("products/products.supplier")</th>
                            <th>@lang("products/products.category")</th>
                            <th>@lang("products/products.quantity")</th>
                            <th>@lang("products/products.price")</th>
                            <th>@lang("products/products.piece_weight")</th>
                            <th>@lang("products/products.expired_at")</th>
{{--                            <th>@lang("products/products.move")</th>--}}
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

    @include("site.stocks.modals.move")

    @push("js")
        {!! datatable_files() !!}
        <script>

            $("#productsTable").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'supplier', name: 'supplier'},
                    {data: 'category', name: 'category'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'price', name: 'price'},
                    {data: 'weight', name: 'weight'},
                    {data: 'expired_at', name: 'expired_at'},
                    // {data: 'move', name: 'move'},
                ],
                url: "{{ route("ajax.products.index") }}",
                actionColumnWidth: "250px",
                data: { stock: "{{ $stock->id }}" }
            });

        </script>
    @endpush


@endsection
