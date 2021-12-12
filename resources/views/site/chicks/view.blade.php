@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
        <link rel="stylesheet" type="text/css" href="{{ admin_assets("css/daterangepicker.css") }}" />
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("home.main_info")</h3>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body d-flex main-info">
                    <div class="col-6">
                        <ul class="list-ar-numeric">
                            <li><span class="title even">@lang("$trans.chick")</span> {{$chick->name}}</li>
                            <li><span class="title odd">@lang("$trans.quantity")</span> @lang("$trans.quantity",['quantity' => num_to_ar($services->quantity($chick->id))])</li>
                            <li><span class="title even">@lang("chicks/orders.price")</span> {{ currency(($price = $services->orders($chick->id)->latest()->first())?$price->price:0 ) }}</li>
                            <li><span class="title odd">@lang("chicks/orders.chick_price")</span> {{ currency(($chick_price = $services->orders($chick->id)->latest()->first()) ? $chick_price->chick_price : 0) }}</li>
                        </ul>
                    </div>
                    <div class="col-6 float-right">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("balances.gain")</span> {{ currency($chick->debt()->sum("gain")) }}</li>
                            <li><span class="title even">@lang("balances.loss")</span> {{ currency($chick->debt()->sum("loss")) }}</li>
                            <li><span class="title odd">@lang("$trans.sold_quantity")</span> {{  num_to_ar($chick->soldQuantity()) }}</li>
                            <li><span class="title even">@lang("$trans.unsold_quantity")</span> {{  num_to_ar($chick->unsoldQuantity()) }}</li>
                        </ul>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- ./main info -->
        <div class="col-12">
            @include("site.chicks.graph.chick")
        </div>
        <!-- ./col -->
        <!-- balances -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("balances.transactions")</h3>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="supplierTransactionDate">@lang("balances.select_date")</label>
                            <div id="supplierTransactionDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="select_supplier_transaction_type">@lang("balances.select_transaction_type")</label>
                                <select name="transaction_type" id="select_supplier_transaction_type" class="form-control">
                                    {!! select_options(['','prev_balance','catch','payment','sale','buy'],null,null,"balances") !!}
                                </select>

                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                    <table class="table table-bordered table-striped " id="transactions">
                        <thead>
                        <tr>
                            <th>@lang("suppliers.supplier")</th>
                            <th>@lang("balances.type")</th>
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
                <div class="card-footer d-flex ">
                    <div class="col-4  d-flex">
                        <h4>@lang("balances.paid") : <span class="info-color ml-2"> {{ currency($chick->supplierPaid()) }}</span></h4>
                    </div>
                    <div class="col-4 d-flex">
                        <h4>@lang("balances.creditor") : <span class="info-color ml-2"> {{ currency($chick->creditorSupplier()) }}</span></h4>
                    </div>
                    <div class="col-4 d-flex">
                        <h4>@lang("balances.debtor") : <span class="info-color ml-2"> {{ currency($chick->debtorSupplier()) }}</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./balances -->



        <!-- balances -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("balances.clients")</h3>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="clientTransactionDate">@lang("balances.select_date")</label>
                            <div id="clientTransactionDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="select_client_transaction_type">@lang("balances.select_transaction_type")</label>
                                <select name="transaction_type" id="select_client_transaction_type" class="form-control">
                                    {!! select_options(['','prev_balance','catch','payment','sale','buy'],null,null,"balances") !!}
                                </select>

                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                    <table class="table table-bordered table-striped " id="clientTransactions">
                        <thead>
                        <tr>
                            <th>@lang("clients.client")</th>
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
                <div class="card-footer d-flex ">
                    <div class="col-4  d-flex">
                        <h4 >@lang("balances.paid") : <span class="info-color ml-2"> {{ currency($chick->clientPaid()) }}</span></h4>
                    </div>
                    <div class="col-4 d-flex">
                        <h4>@lang("balances.debtor") : <span class="info-color ml-2"> {{ currency($chick->debtorClient()) }}</span></h4>
                    </div>
                    <div class="col-4 d-flex">
                        <h4 >@lang("balances.creditor") : <span class="info-color ml-2"> {{ currency($chick->creditorClient()) }}</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./balances -->

        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6"><h3 class="card-title float-left">@lang("chicks/orders.title")</h3></div>
                        <div class="col-6 float-left">
                            <button type="button" class="btn btn-info btn-print"><i class="fa fa-print"></i> @lang("home.print")</button>
                            <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>

                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="orders-table" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("chicks/orders.name")</th>
                            <th>@lang("chicks/orders.price")</th>
                            <th>@lang("chicks/orders.chick_price")</th>
                            <th>@lang("chicks/orders.quantity")</th>
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

        <!-- ./products-list -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("chicks/booking.title")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped " id="booking">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("clients/clients.name")</th>
                            <th>@lang("clients/clients.phone")</th>
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
        <script src="{{ admin_assets("/js/moment.min.js") }}"></script>
        <script src="{{ admin_assets("js/daterangepicker.js") }}"></script>
        <script src="{{ admin_assets("js/plugins/datepicker.js") }}"></script>
        <script>
            let supplierDate = $("#supplierTransactionDate"),clientDate = $("#clientTransactionDate");
            $(function () {
                supplierDate.maDatepicker();
               clientDate.maDatepicker();

                supplierDate.on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.unix(), end = picker.endDate.unix();
                    $("#transactions").DataTable().destroy();
                    transactions($("#select_supplier_transaction_type").val(),start,end)
                });

                clientDate.on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.unix(), end = picker.endDate.unix();
                    $("#clientTransactions").DataTable().destroy();
                    clientTransactions($("#select_client_transaction_type").val(),start,end)
                });

            });

            $("#select_supplier_transaction_type").change(function () {
                $("#transactions").DataTable().destroy();
                transactions($(this).val())
            });
            $("#select_client_transaction_type").change(function () {
                $("#clientTransactions").DataTable().destroy();
                clientTransactions($(this).val())
            });

            var booking = $("#booking").table({
                columns: [
                    {data: 'client', name: 'client'},
                    {data: 'phone', name: 'phone'},
                    {data: 'chick', name: 'chick'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'deposit', name: 'deposit'},
                    {data: 'status', name: 'status'},
                ],
                actionColumnWidth: "300px",
                data: {chick:"{{ $chick->id }}"},
                url: "{{ route("ajax.booking.index") }}",
            });

            $("#orders-table").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'chick_price', name: 'chick_price'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'status', name: 'status'},
                ],
                url: "{{ route("ajax.chick.orders.index") }}",
                data: {chick: "{{ $chick->id }}"},
                actionColumnWidth : "350px"
            });
            
            transactions();

            clientTransactions();

            function transactions(type = null,start = null, end =null) {
                return  $("#transactions").table({
                    columns: [
                        {data: 'supplier', name: 'supplier'},
                        {data: 'type', name: 'type'},
                        {data: 'paid', name: 'paid'},
                        {data: 'remaining', name: 'remaining'},
                        {data: 'date', name: 'date'},
                        {data: 'user', name: 'user'},
                        {data: 'notes', name: 'notes'},
                    ],
                    url: "{{ route("ajax.chicks.balances.supplier",$chick->id) }}",
                    data: {type: type,startDate: start,end: end},
                    notColumns: [
                        '#',
                        'actions'
                    ]
                });
            } //end of function transactions


            function clientTransactions(type = null,start = null, end =null) {
                return  $("#clientTransactions").table({
                    columns: [
                        {data: 'client', name: 'client'},
                        {data: 'transaction', name: 'transaction'},
                        {data: 'paid', name: 'paid'},
                        {data: 'rest', name: 'rest'},
                        {data: 'date', name: 'date'},
                        {data: 'user', name: 'user'},
                        {data: 'notes', name: 'notes'},
                    ],
                    url: "{{ route("ajax.chicks.balances.client",$chick->id) }}",
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
