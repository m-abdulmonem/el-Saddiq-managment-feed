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
                    <h3 class="card-title float-left">@lang("users/users.main_info")</h3>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body d-flex main-info">
                    <div class="col-3">
                        <img src="{{ img($user->picture) }}" alt="">
                    </div>
                    <div class="col-8 d-flex">
                        <div class="col-6">
                            <ul class="list-ar-numeric">
                                <li><span class="title odd">@lang("$trans.name")</span> {{$user->name()}}</li>
                                <li><span class="title even">@lang("$trans.phone")</span> {{ num_to_ar($user->phone) }}</li>
                                <li><span class="title odd">@lang("$trans.address")</span> {{ $user->address }}</li>
                                <li><span class="title even">@lang("$trans.job")</span> {{ $user->job->name }}</li>
                                <li><span class="title even">@lang("clients/clients.credit_limit")</span> {{ $user->credit_limit }}</li>
                            </ul>
                        </div>
                        <div class="col-6 float-right">
                            <ul class="list-ar-numeric">
                                <li><span class="title odd">@lang("$trans.salary")</span> {{ currency($user->salary) }}</li>
                                <li><span class="title even">@lang("$trans.salary_type")</span> @lang("$trans.option_$user->salary_type")</li>
                                <li><span class="title odd">@lang("$trans.holidays")</span> {{ str_replace(","," - " , $user->holidays) }}</li>
                                <li><span class="title even">@lang("$trans.status")</span> @lang("$trans.option_$user->is_active")</li>
                                <li><span class="title even">@lang("$trans.discount_limit")</span> {{ $user->discount_limit }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- ./main info -->
        <div class="col-12">
            @include("graph.users.index")
        </div>
        <!-- ./col -->
        <!-- bills -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left d-flex">@lang("clients/bills.title")</div>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped " id="invoicesTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("clients/bills.bill_number")</th>
                            <th>@lang("clients/clients.client")</th>
                            <th>@lang("clients/bills.type")</th>
                            <th>@lang("clients/bills.discount")</th>
                            <th>@lang("clients/bills.total_price")</th>
                            <th>@lang("clients/bills.status")</th>
                            <th>@lang("home.date")</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
{{--                <div class="card-footer d-flex ">--}}
{{--                    <div class="col-4  d-flex">--}}
{{--                        <h4 >@lang("balances.paid") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 d-flex">--}}
{{--                        <h4>@lang("balances.debtor") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 d-flex">--}}
{{--                        <h4>@lang("balances.creditor") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
        <!-- ./bills -->
        <!-- balances -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="balances-tabs float-left">@lang("clients/balances.title")</div>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-12 d-flex">
                        <div class="col-6">
                            <label for="transactionsDate">@lang("balances.select_date")</label>
                            <div id="transactionsDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="select_transaction_type">@lang("balances.select_transaction_type")</label>
                                <select name="transaction_type" id="select_transaction_type" class="form-control">
                                    {!! select_options(['','prev_balance','catch','payment','sale','buy'],null,null,"balances") !!}
                                </select>

                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./col-12 ./d-flex -->

                    <table class="table table-bordered table-striped " id="balanceTable">
                        <thead>
                        <tr>
                            <th>@lang("clients/clients.client")</th>
                            <th>@lang("balances.transaction")</th>
                            <th>@lang("balances.paid")</th>
                            <th>@lang("balances.remaining")</th>
                            <th>@lang("balances.date")</th>
                            <th>@lang("balances.note")</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
{{--                <div class="card-footer d-flex ">--}}
{{--                    <div class="col-4  d-flex">--}}
{{--                        <h4 >@lang("balances.paid") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 d-flex">--}}
{{--                        <h4>@lang("balances.debtor") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 d-flex">--}}
{{--                        <h4 >@lang("balances.creditor") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
        <!-- ./balances -->
        <!-- chicks -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="chicks-tabs float-left ">@lang("chicks/booking.title")</div>
                    <button type="button" class="btn btn-info " id="print-balance"><i class="fa fa-print"></i> @lang("home.print")</button>
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped " id="BookingTable">
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
{{--                <div class="card-footer d-flex ">--}}
{{--                    <div class="col-4  d-flex">--}}
{{--                        <h4 >@lang("balances.paid") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 d-flex">--}}
{{--                        <h4>@lang("balances.debtor") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 d-flex">--}}
{{--                        <h4 >@lang("balances.creditor") : <span class="info-color ml-2"> {{ currency(0) }}</span></h4>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
        <!-- ./chicks -->
    </div>
    <!-- /.row -->

    @push("js")
        {!! datatable_files() !!}
        <script src="{{ admin_assets("moment.min.js") }}"></script>
        <script src="{{ admin_assets("daterangepicker.js") }}"></script>
        <script src="{{ admin_assets("plugins/datepicker.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("plugins/datepicker.js") }}"></script>

        <script>
            $("#invoicesTable").table({
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
                    {data: 'discount', name: 'discount'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    {data: 'date', name: 'date'}
                ],
                url: "{{ route("ajax.clients.invoices.index") }}",
                notColumns: ['actions'],
                actionColumnWidth: "250px"
            });

            {{-- $("#BookingTable").table({
                columns: [
                    {data: 'client', name: 'client'},
                    {data: 'phone', name: 'phone'},
                    {data: 'chick', name: 'chick'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'deposit', name: 'deposit'},
                    {data: 'status', name: 'status'},
                ],
                url: "{{ route("ajax.booking.index") }}",
                data: {user: "{{$user->id}}"},
                actionColumnWidth : "300px"
            }); --}}

            $(function () {
                let transactionDate = $("#transactionsDate"),
                    transactionType = $("#select_transaction_type");
                transactionDate.maDatepicker();

                transactionType.change(function () {
                    $("#balanceTable").DataTable().destroy();
                    clientTransactions($(this).val());
                });
                transactionDate.maDatepicker();
                transactionDate.on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.format("YYYY-MM-DD"), end = picker.endDate.format("YYYY-MM-DD");
                    $("#balanceTable").DataTable().destroy();
                    clientTransactions(transactionType.val(),start,end)
                });

            });


            clientTransactions();

            function clientTransactions(type = null,start = null, end =null) {
                return  $("#balanceTable").table({
                    columns: [
                        {data: 'client', name: 'client'},
                        {data: 'type', name: 'type'},
                        {data: 'paid', name: 'paid'},
                        {data: 'rest', name: 'rest'},
                        {data: 'date', name: 'date'},
                        {data: 'notes', name: 'notes'},
                    ],
                    url: "{{ route("ajax.users.balances.client",$user->id) }}",
                    data: {type: type,start: start,end: end},
                    notColumns: [
                        '#',
                        'actions'
                    ]
                });
            } //end of function transactions


        </script>
    @endpush


@endsection
