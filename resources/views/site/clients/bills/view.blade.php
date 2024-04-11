@extends("site.layouts.index")
@section("content")
    @push("css")
        <link rel="stylesheet" type="text/css" href="{{ admin_assets("css/daterangepicker.css") }}" />
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">

        <!-- bill info -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("products/products.main_info")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-print"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body row  main-info">
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("$trans.bill_number")</span> {{num_to_ar($bill->code)}}</li>
                            <li><span class="title even">@lang("$trans.client")</span> {{$bill->client->name()}}</li>
                            <li><span class="title odd">@lang("$trans.type")</span> {{ $bill->type() }}</li>
                            <li><span class="title even">@lang("$trans.discount")</span> {{currency($bill->discount)}}</li>
                        </ul>
                    </div>
                    <!-- ./col -->
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("$trans.date")</span> {{num_to_ar($bill->created_at->format("Y-m-d"))}}</li>
{{--                            <li><span class="title even">@lang("$trans.is_cash")</span> @lang("balances.$bill->is_cash")</li>--}}
                            <li><span class="title odd">@lang("$trans.quantity")</span> {{num_to_ar($bill->quantity)}}</li>
                            <li><span class="title odd">@lang("$trans.returned_quantity")</span> {{num_to_ar($bill->returnedQuantity())}}</li>
                            <li><span class="title odd">@lang("$trans.status")</span> <span class="{{$bill->getStatusTag()}}">@lang("clients/bills.option_$bill->status")</span></li>

                        </ul>
                    </div>
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title even">@lang("$trans.user")</span> {{ $bill->user->name }}</li>
                            <li><span class="title odd">@lang("balances.gain")</span> {{ currency($bill->gain()) }}</li>
                            <li><span class="title even">@lang("balances.loss")</span> {{ currency($bill->loss()) }}</li>
                        </ul>
                    </div>
                    <!-- ./col -->
                    <div class="col-12">
                        <span class="title even">@lang("$trans.notes") : </span> <p>{{ $bill->notes }}</p>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->


        <!-- balance -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("balances.clients")</h3>
                    <a  class="btn btn-secondary" href="{{ route("ajax.clients.print.balance",$bill->id) }}">
                        <i class="fa fa-print"></i> @lang("home.print")
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="transactionsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>@lang("clients/clients.client")</th>
                            <th>@lang("balances.transaction")</th>
                            <th>@lang("balances.paid")</th>
                            <th>@lang("balances.remaining")</th>
                            <th>@lang("balances.date")</th>
                            <th>@lang("balances.user")</th>
                            <th>@lang("balances.note")</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex h5">
                    <div class="row w-100" style="margin: 1px 1px">
                        <ul class="main-info d-flex list-unstyled w-100">
                            <li class="w-25">@lang("balances.paid") : <span class="odd">{{currency($bill->totalPaid())}}</span></li>
                            <li class="w-25">@lang("balances.remaining") : <span class="odd">{{currency($bill->remaining())}}</span></li>
                            <li class="w-25">@lang("clients/bills.total_price") : <span class="even">{{currency($bill->price)}}</span></li>
                            <li class="w-25">@lang("balances.discount") : <span class="odd">{{currency($bill->discount())}}</span></li>
                        </ul>
                    </div>
                    <!-- ./row -->
                </div>
            </div>
        </div>

        <!-- ./products -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("products/products.title")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-plus"></i> @lang("home.print")</button>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="selectProductType"></label>
                        <select class="form-control" id="selectProductType">
                            <option>@lang("clients.option_default")</option>
                            <option value="sold_product">@lang("clients/bills.sold_product")</option>
                            <option value="discarded_sale">@lang("clients/bills.discarded_product")</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="productsTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("products/products.name")</th>
                            <th>@lang("products/products.type")</th>
                            <th>@lang("$trans.quantity")</th>
                            <th>@lang("stocks.stock")</th>
                            <th>@lang("products/history.unit_price")</th>
                            <th>@lang("products/products.total_price")</th>
                            <th>@lang("products/products.product_weight")</th>
                            <th>@lang("products/products.total_weight")</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <!-- /discarded Sale -->
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("$trans.discarded_sale")</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="returnedInvoicesTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.code")</th>
                            <th>@lang("$trans.quantity")</th>
                            <th>@lang("$trans.price")</th>
                            <th>@lang("balances.balance")</th>
                            <th>@lang("balances.creditor")</th>
                            <th>@lang("balances.debtor")</th>
                            <th>@lang("home.date")</th>
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
        <script type="text/javascript" src="{{ admin_assets("/js/moment.min.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("js/daterangepicker.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("js/plugins/datepicker.js") }}"></script>
        <script>
            $(function () {
                let transactionDate =  $("#TransactionDate");
                transactionDate.maDatepicker();
                transactionDate.on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.format("YYYY-MM-DD"), end = picker.endDate.format("YYYY-MM-DD");
                    $("#transactionsTable").DataTable().destroy();
                    transactions($("#select_type").val(),start,end);
                });

                $("#select_type").change(function () {
                    $("#transactionsTable").DataTable().destroy();
                    transactions($(this).val())
                });

                $("#selectProductType").change(function () {
                    $("#productsTable").DataTable().destroy();
                    products($(this).val())
                })

            });
            $(".btn-print").click(function () {
                window.open("/print/clientBill-{{ $bill->id  }}/Client-bill","_blank");
            });
            $("#btn-print-return-shipping").click(function () {
                window.open("/print/clientBillReturn-{{ $bill->id  }}/Client-bill-return","_blank");
            });
            $("#print-balance").click(function () {
                window.open("/print/clientBalance-{{ $bill->id  }}/Client-Balance","_blank");
            });


            $("#returnedInvoicesTable").table({
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'price', name: 'price'},
                    {data: 'balances', name: 'balances'},
                    {data: 'creditor', name: 'creditor'},
                    {data: 'debtor', name: 'debtor'},
                    {data: 'date', name: 'date'}
                ],
                url: "{{ route("ajax.clients.invoices.returned.invoices",$bill->id) }}",
                notColumns: ['actions'],
                actionColumnWidth: "250px"
            })

            products();
            transactions();

            function products(type= null) {
                $("#productsTable").table({
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'type', name: 'type'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'stock', name: 'stock'},
                        {data: 'piece_price', name: 'piece_price'},
                        {data: 'price', name: 'price'},
                        {data: 'weight', name: 'weight'},
                        {data: 'total_weight', name: 'total_weight'},
                    ],
                    url: "{{ route("ajax.clients.products",$bill->id) }}",
                    data: {type: type},
                    notColumns: [
                        'actions'
                    ]
                });
            }

            function transactions(type = null,start = null, end =null) {
                return  $("#transactionsTable").table({
                    columns: [
                        {data: 'client', name: 'client'},
                        {data: 'type', name: 'type'},
                        {data: 'paid', name: 'paid'},
                        {data: 'rest', name: 'rest'},
                        {data: 'date', name: 'date'},
                        {data: 'user', name: 'user'},
                        {data: 'notes', name: 'notes'},
                    ],
                    url: "{{ route("ajax.clients.invoices.balances",$bill->id) }}",
                    data: {type: type,startDate: start,end: end},
                    notColumns: [
                        '#',
                        'actions'
                    ]
                });
            } //end of function transactions

        </script>
    @endpush
@endsection
