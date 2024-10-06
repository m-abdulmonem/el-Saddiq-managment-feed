@extends("site.layouts.index")
@section("content")
    @push("css")
        <link rel="stylesheet" type="text/css" href="{{ admin_assets("daterangepicker.css") }}" />
        {!! datatable_files("css") !!}
    @endpush

    <div class="row">

        <!-- bill info -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("users/users.main_info")</h3>
                    @can("delete client")
                        <button class="btn btn-danger btn-delete " type="button"
                                data-url="{{ route("clients.destroy",$client->id) }}"
                                data-name="{{  $client->name }}" data-token="{{ csrf_token() }}"
                                data-title="@lang("home.confirm_delete")"
                                data-text="@lang("home.alert_delete",['name'=> $client->name])"
                                data-back="{{ route("clients.index") }}">
                            <a><i class="fa fa-trash"></i> @lang("home.delete")</a>
                        </button>
                    @endcan
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-print"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body row  main-info">
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("$trans.name")</span> {{$client->name()}}</li>
                            <li><span class="title even">@lang("$trans.phone")</span> {{num_to_ar($client->phone)}}</li>
                            <li><span class="title even">@lang("$trans.discount")</span> {{currency($client->discount)}}</li>
                            <li><span class="title odd">@lang("$trans.type")</span> {{ $client->type() }}</li>
                        </ul>
                    </div>
                    <!-- ./col -->
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("$trans.latest_bill")</span> {{num_to_ar($client->latestBill())}}</li>
                            <li><span class="title odd">@lang("$trans.quantity")</span> {{num_to_ar($client->bills()->sum("quantity"))}}</li>
                            <li><span class="title odd">@lang("$trans.returned_quantity")</span> {{num_to_ar($client->returnBills()->sum("quantity")??0)}}</li>
                            <li><span class="title even">@lang("balances.balance")</span> {{ currency($client->remaining()) }}</li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("balances.debtor")</span> {{currency($client->debtor())}}</li>
                            <li><span class="title even">@lang("balances.creditor")</span> {{currency($client->creditor())}}</li>
                            <li><span class="title odd">@lang("balances.gain")</span> {{ currency($client->gainLossGraph()->sum("gain")) }}</li>
                            <li><span class="title even">@lang("balances.loss")</span> {{ currency($client->gainLossGraph()->sum("loss")) }}</li>
                        </ul>
                    </div>
                    <!-- ./col -->
                    <div class="col-12">
                        <span class="title even">@lang("$trans.address") : </span> {{ $client->address }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- ./bill info -->

        <!-- chart -->
        <div class="col-12">
            @include("site.clients.graph.index")
        </div>
        <!-- ./col -->

        <!-- balances -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("balances.clients")</h3>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="transactionsDate">@lang("balances.select_date")</label>
                            <div id="TransactionDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="select_type">@lang("balances.select_type")</label>
                                <select name="type" id="select_type" class="form-control">
                                    {!! select_options(['','prev_balance','catch','payment','sale','buy'],null,null,"balances") !!}
                                </select>

                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <table class="table table-bordered table-striped" id="transactionsTable">
                        <thead>
                        <tr>
                            <th>@lang("clients.client")</th>
                            <th>@lang("balances.transaction")</th>
                            <th>@lang("balances.paid")</th>
                            <th>@lang("balances.remaining")</th>
                            <th>@lang("balances.date")</th>
                            <th>@lang("users.user")</th>
                            <th>@lang("balances.note")</th>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex h5">
                    <ul class="list-unstyled d-flex w-100">
                        <li class="w-25">@lang("balances.paid") :  <span class="primary-color ml-3">  {{ currency($client->totalBills()) }}</span></li>
                        <li class="w-25">@lang("balances.paid") :  <span class="primary-color ml-3">  {{ currency($client->totalPaid()) }}</span></li>
                        <li class="w-25">@lang("balances.creditor") :  <span class="primary-color ml-3">  {{ currency($client->creditor()) }}</span></li>
                        <li class="w-25">@lang("balances.debtor") :  <span class="primary-color ml-3">  {{ currency($client->debtor()) }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ./balances -->

        <!-- ./invoices -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("clients/bills.title")</h3>
                    @can("create client_bill")
                        <a href="{{ route("invoices.create") }}" class="btn btn-primary "><i class="fa fa-plus"></i> @lang("home.new")</a>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-inline mb-3">
                        <label for="invoiceType">@lang("products/products.select_product_type")</label>
                        <select id="invoiceType" class="form-control">
                            <option value="">@lang("clients/clients.option_default")</option>
                            <option value="invoices">@lang("clients/bills.title")</option>
                            <option value="returned_sale_invoice">@lang("clients/bills.discarded_sale")</option>
                        </select>
                    </div>
                    <table id="invoicesTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>@lang("$trans.code")</th>
                            <th>@lang("clients/clients.client")</th>
                            <th>@lang("$trans.type")</th>
                            <th>@lang("$trans.discount")</th>
                            <th>@lang("clients/bills.price")</th>
                            <th>@lang("clients/bills.status")</th>
                            <th>@lang("balances.balance")</th>
                            <th>@lang("balances.creditor")</th>
                            <th>@lang("balances.debtor")</th>
                            <th>@lang("home.date")</th>
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
                    <div class="form-inline mb-3">
                        <label for="productType">@lang("products/products.select_product_type")</label>
                        <select id="productType" class="form-control">
                            <option value="">@lang("clients/clients.option_default")</option>
                            <option value="sold_product">@lang("clients/bills.sold_product")</option>
                            <option value="discarded_product">@lang("clients/bills.discarded_product")</option>
                        </select>
                    </div>
                    <table class="table table-bordered table-striped " id="productsTable">
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
        <!-- booking -->
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("chicks/booking.title")</h3>
                    @can("create client")
                        <button class="btn btn-primary btn-add" data-toggle="modal" data-target="#chickBooking">
                            <i class="fa fa-plus"></i> @lang("home.new")
                        </button>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-inline mb-3">
                        <label for="select_status">@lang("chicks/booking.select_status")</label>
                        <select name="" id="select_status" class="form-control">
                            {!! select_options([null,1,0],null,"false",$trans) !!}
                        </select>
                    </div>
                    <table id="bookingTable" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("clients.name")</th>
                            <th>@lang("clients.phone")</th>
                            <th>@lang("chicks/chicks.name")</th>
                            <th>@lang("chicks/orders.quantity")</th>
                            <th>@lang("chicks/booking.deposit")</th>
                            <th>@lang("chicks/orders.status")</th>
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

    @push("js")
        {!! datatable_files() !!}
        <script type="text/javascript" src="{{ admin_assets("moment.min.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("daterangepicker.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("plugins/datepicker.js") }}"></script>
        <script>
            $(function () {
                let  transactionDate = $("#TransactionDate"),startDate,endDate;
                $("#select_type").change(function () {
                    $("#transactionsTable").DataTable().destroy();
                    transactions($(this).val().replace("option_",""),startDate,endDate);
                });

                transactionDate.maDatepicker();
                transactionDate.on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.format("YYYY-MM-DD"), end = picker.endDate.format("YYYY-MM-DD");
                    startDate = start;
                    endDate = end;
                    $("#transactionsTable").DataTable().destroy();
                    transactions($("#select_type").val().replace("option_"),start,end);
                });

                $("#invoiceType").change(function () {
                    $("#invoicesTable").DataTable().destroy();
                    invoices($(this).val())
                });
                $("#productType").change(function () {
                    $("#productsTable").DataTable().destroy();
                    products($(this).val())
                });
                $("#select_status").change(function () {
                    $("#bookingTable").DataTable().destroy();
                    chicksTable($(this).val())
                });
                invoices();
                products();
                booking();
                transactions()
            });
            function invoices(type){
                $("#invoicesTable").table({
                    columns: [
                        {data: 'code', name: 'code'},
                        {data: 'name', name: 'name'},
                        {data: 'type', name: 'type'},
                        {data: 'discount', name: 'discount'},
                        {data: 'price', name: 'price'},
                        {data: 'status', name: 'status'},
                        {data: 'balances', name: 'balances'},
                        {data: 'creditor', name: 'creditor'},
                        {data: 'debtor', name: 'debtor'},
                        {data: 'date', name: 'date'}
                    ],
                    url: "{{ route("ajax.clients.invoices.index") }}",
                    data: {client: "{{ $client->id }}",type: type},
                    notColumns: ['#'],
                    actionColumnWidth: "250px"
                });
            }
            function products(type = null){
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
                    url: "{{ route("ajax.clients.products",$client->id) }}",
                    data: {type: type},
                    notColumns: [
                        'actions'
                    ]
                });

            }

            function booking(status = null) {
                return  $("#bookingTable").table({

                    columns: [
                        {data: 'client', name: 'client'},
                        {data: 'phone', name: 'phone'},
                        {data: 'chick', name: 'chick'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'deposit', name: 'deposit'},
                        {data: 'status', name: 'status'},
                    ],
                    // url: "route("ajax.booking.index")",
                    url: "{{ url("ajax.booking.index") }}",
                    data: {status: status,client: "{{ $client->id }}"},
                    actionColumnWidth : "300px"
                });
            }//end of function

            function transactions(type = null,start = null,end = null) {
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
                    url: "{{ route("ajax.clients.balances",$client->id) }}",
                    data: {type: type,startDate: start,end: end},
                    notColumns: [
                        '#',
                        'actions'
                    ]
                });
            }
        </script>
    @endpush


@endsection
