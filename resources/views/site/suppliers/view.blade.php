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
                    <h3 class="card-title float-left">{{ trans("users.main_info") }}</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-plus"></i> {{ trans("home.print") }}</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body row main-info">
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li class="odd">@lang("$trans.name") : <span>{{ $supplier->name() }}</span></li>
                            <li class="even">@lang("$trans.discount") : <span>{{ currency($supplier->discount) }}</span></li>
                            <li class="odd">@lang("$trans.address") : <span>{{ $supplier->address }}</span></li>
                        </ul>
                    </div>
                    <!-- ./col -->
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li class="odd">@lang("$trans.phone") : <span>{{ num_to_ar($supplier->phone) }}</span></li>
                            <li class="even">@lang("$trans.my_code") : <span>{{ currency($supplier->my_code) }}</span></li>
                            <li class="odd" title="@lang("$trans.in_this_course")">@lang("$trans.quantity") : <span>{{ $supplier->courseQuantity() }}</span></li>
                        </ul>
                    </div>
                    <!-- ./col -->
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li class="odd">@lang("$trans.total_gian") : <span>{{ currency($supplier->incomeStatementGraph()->sum("gain")) }}</span></li>
                            <li class="even">@lang("$trans.total_loss") : <span>{{ currency(removeMines($supplier->incomeStatementGraph()->sum("loss"))) }}</span></li>
                            <li class="odd">@lang("$trans.total_quantity") : <span>{{ num_to_ar($supplier->courseQuantity()) }}</span></li>
                        </ul>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->

        <!-- graph -->
        <div class="col-12">
            @include("site.suppliers.graph")
        </div>
        <!-- /.col -->

        <!-- balance -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("balances.supplier")</h3>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("suppliers/bills.btn_print_balance")</button>
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
                                    {!! select_options(['','prev_balance','catch','payment','sale','buy','mashal','tip'],null,null,"balances") !!}
                                </select>

                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <table class="table table-bordered table-striped" id="transactionsTable">
                        <thead>
                        <tr>
                            <th>@lang("suppliers.supplier")</th>
                            <th>@lang("balances.transaction")</th>
                            <th>@lang("balances.paid")</th>
                            <th>@lang("balances.remaining ")</th>
                            <th>@lang("balances.date")</th>
                            <th>@lang("balances.user")</th>
                            <th>@lang("balances.note")</th>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex h5">
                    @lang("balances.paid") :  <h4 class="primary-color ml-3">  {{ currency($supplier->totalBillsPrice()) }}</h4>
                    @lang("balances.paid") :  <h4 class="primary-color ml-3">  {{ currency($supplier->totalPaid()) }}</h4>
                    @lang("balances.creditor") :  <h4 class="primary-color ml-3">  {{ $supplier->creditor() }}</h4>
                    @lang("balances.debtor") :  <h4 class="primary-color ml-3">  {{ $supplier->debtor() }}</h4>
                </div>
            </div>
        </div>

        <!-- ./products-list -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("products.title")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-plus"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="productsTable">
                        <thead>
                        <tr>
                            <th>@lang("products.name")</th>
                            <th>@lang("products.price")</th>
                            <th>@lang("products.sale_price")</th>
                            <th>@lang("products.profit_ratio")</th>
                            <th>@lang("products.stock")</th>
                            <th>@lang("products.quantity")</th>
                            <th>@lang("balances.gain")</th>
                            <th>@lang("balances.loss")</th>
                            <th>@lang("products.expired_at")</th>
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

        <!-- ./bills -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("suppliers/bills.title")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-plus"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang("suppliers/bills.code")</th>
                                <th>@lang("suppliers/bills.bill_number")</th>
                                <th>@lang("suppliers/bills.type")</th>
                                <th>@lang("suppliers/bills.quantity")</th>
                                <th>@lang("suppliers/bills.discount")</th>
                                <th>@lang("suppliers/bills.price")</th>
                                <th>@lang("suppliers/bills.balance")</th>
                                <th>@lang("suppliers/bills.creditor")</th>
                                <th>@lang("suppliers/bills.debtor")</th>
                                <th>@lang("home.actions")</th>
                            </tr>
                        </thead>
                        <tbody id="bills">

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <h5>@lang("balances.creditor") <small> {{ currency(0) }} </small></h5>
                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <!-- ./chicks -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("chicks/chicks.title")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-plus"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="chicksTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("chicks/chicks.name")</th>
                            <th>@lang("chicks/chicks.price")</th>
                            <th>@lang("chicks/chicks.sale_price")</th>
                            <th>@lang("chicks/chicks.profit")</th>
                            <th>@lang("chicks/chicks.total_quantity")</th>
                            <th>@lang("balances.gain")</th>
                            <th>@lang("balances.loss")</th>
                            <th>@lang("home.actions")</th>
                        </tr>
                        </thead>
                        <tbody id="bills">

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
{{--                            <h5>@lang("balances.creditor") <small> {{ currency(0) }} </small></h5>--}}
                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <!-- ./orders -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("chicks/orders.title")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-plus"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="ordersTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("chicks/orders.name")</th>
                            <th>@lang("chicks/orders.price")</th>
                            <th>@lang("chicks/orders.purchase_price")</th>
                            <th>@lang("chicks/orders.sale_price")</th>
                            <th>@lang("chicks/orders.quantity")</th>
                            <th>@lang("chicks/orders.status")</th>
{{--                            <th>@lang("chicks/orders.chick")</th>--}}
                            <th>@lang("chicks/orders.gain")</th>
                            <th>@lang("chicks/orders.loss")</th>
                            <th>@lang("chicks/orders.date")</th>
                            <th>@lang("home.actions")</th>
                        </tr>
                        </thead>
                        <tbody id="bills">

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
{{--                            <h5>@lang("balances.creditor") <small> {{ currency(0) }} </small></h5>--}}
                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <!-- /.card-footer -->
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
                   transactions(null,start,end);
               });

               $("#select_type").change(function () {
                   $("#transactionsTable").DataTable().destroy();
                   transactions($(this).val())
               })

           });

           let table =  $("#datatable").table({
                columns: [
                    {data: 'code', name: 'code' },
                    {data: 'number', name: 'number'},
                    {data: 'type', name: 'type'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'discount', name: 'discount'},
                    {data: 'price', name: 'price'},
                    {data: 'balances', name: 'balances'},
                    {data: 'creditor', name: 'creditor'},
                    {data: 'debtor', name: 'debtor'}
                ],
                url: "{{ route("ajax.suppliers.bills.index") }}",
                data: {supplier: "{{ $supplier->id }}"}
            });

           $("#chicksTable").table({
               columns: [
                   {data: 'name', name: 'name'},
                   {data: 'price', name: 'price'},
                   {data: 'sale_price', name: 'sale_price'},
                   {data: 'profit', name: 'profit'},
                   {data: 'quantity', name: 'quantity'},
                   {data: 'gain', name: 'gain'},
                   {data: 'loss', name: 'loss'},
               ],
            //    url: " route('ajax.chicks.index') ",
               url: "{{ url("") }}",
               data: {supplier: "{{ $supplier->id }}"}
           });

           $("#ordersTable").table({
               columns: [
                   {data: 'name', name: 'name'},
                   {data: 'price', name: 'price'},
                   {data: 'purchase_price', name: 'purchase_price'},
                   {data: 'sale_price', name: 'sale_price'},
                   {data: 'quantity', name: 'quantity'},
                   {data: 'status', name: 'status'},
                   // {data: 'chick', name: 'chick'},
                   {data: 'gain', name: 'gain'},
                   {data: 'loss', name: 'loss'},
                   {data: 'date', name: 'date'},
               ],
            //    url: "route("ajax.chick.orders.index")",
               url: "{{ url("") }}",
               data: {supplier: "{{$supplier->id}}"},
               actionColumnWidth : "350px"
           });

           $("#productsTable").table({
               columns: [
                   {data: 'name', name: 'name'},
                   {data: 'price', name: 'price'},
                   {data: 'sale_price', name: 'sale_price'},
                   {data: 'profit', name: 'profit'},
                   {data: 'stock', name: 'stock'},
                   {data: 'quantity', name: 'quantity'},
                   {data: 'gain', name: 'gain'},
                   {data: 'loss', name: 'loss'},
                   {data: 'expired_at', name: 'expired_at'},
               ],
               url: "{{ route("ajax.products.index",['supplier'=> $supplier->id]) }}",
               notColumns: [
                   '#',
               ]
           });

           transactions();

           function transactions(type = null,start = null, end =null) {
               return  $("#transactionsTable").table({
                   columns: [
                       {data: 'supplier', name: 'supplier'},
                       {data: 'type', name: 'type'},
                       {data: 'paid', name: 'paid'},
                       {data: 'remaining', name: 'remaining'},
                       {data: 'date', name: 'date'},
                       {data: 'user', name: 'user'},
                       {data: 'notes', name: 'notes'},
                   ],
                   url: "{{ route("ajax.suppliers.balances",$supplier->id) }}",
                   data: {type: type,startDate: start,end: end},
                   notColumns: [
                       '#',
                       'actions'
                   ]
               });
           } //end of function transactions

            $(".btn-print").click(function () {
                window.open("/print/supplierBill-{{ $supplier->id  }}/supplier-bill","_blank");
            });
            $("#btn-print-return-shipping").click(function () {
                window.open("/print/supplierBillReturn-{{ $supplier->id  }}/supplier-bill-return","_blank");
            });
            $("#print-balance").click(function () {
                window.open("/print/supplierBalance-{{ $supplier->id  }}/supplier-Balance","_blank");
            });

        </script>
    @endpush
@endsection
