@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">

        <!-- bill info -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("users/users.main_info")</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-plus"></i> @lang("home.print")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body row  main-info">
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("$trans.bill_number")</span> {{num_to_ar($bill->number)}}</li>
                            <li><span class="title even">@lang("$trans.supplier")</span> {{$bill->supplier->name()}}</li>
                            <li><span class="title odd">@lang("$trans.type")</span> {{ $bill->type() }}</li>
                            <li><span class="title even">@lang("$trans.discount")</span> {{$bill->discount}}</li>
                            <li><span class="title odd">@lang("$trans.quantity_sold")</span> {{num_to_ar($bill->quantitySold())}}</li>
                        </ul>
                    </div>
                    <!-- ./col -->
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("$trans.date")</span> {{num_to_ar($bill->created_at->format("Y-m-d"))}}</li>
                            <li><span class="title even">@lang("$trans.is_cash")</span> @lang("$trans.$bill->is_cash")</li>
                            <li><span class="title odd">@lang("$trans.quantity")</span> {{ num_to_ar($bill->quantity) }}</li>
                            <li><span class="title even">@lang("$trans.car_number")</span> {{$bill->car_number}}</li>
                            <li><span class="title odd">@lang("$trans.returned_quantity")</span> {{num_to_ar($bill->returnedQuantity())}}</li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <ul class="list-ar-numeric">
                            <li><span class="title odd">@lang("$trans.status")</span> {!! $bill->statusTag() !!}</li>
                            <li><span class="title even">@lang("$trans.driver")</span> {{ $bill->driver }}</li>
                            <li><span class="title odd">@lang("balances.gain")</span> {{ currency($bill->gain()) }}</li>
                            <li><span class="title even">@lang("balances.loss")</span> {{ currency($bill->loss()) }}</li>
                            <li><span class="title odd">@lang("$trans.expired_quantity")</span> {{ num_to_ar($bill->expiredQuantity()) }}</li>
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
                    <h3 class="card-title float-left">@lang("balances.transactions")</h3>
                    {{-- <a  class="btn btn-secondary" href="{{ route("ajax.suppliers.bills.print.transactions",$bill->id) }}">
                        <i class="fa fa-print"></i> @lang("home.print")
                    </a> --}}
{{--                    <button class="btn btn-info float-right">@lang("balances.btn_paid")</button>--}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="transactionsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>@lang("suppliers/suppliers.supplier")</th>
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
                     <div class="w-50 d-flex">@lang("balances.paid") : <h4 class="primary-color ml-3">  {{ currency($bill->balances()->sum("paid")) }}</h4></div>
                     <div class="w-50 d-flex">@lang("balances.remaining") : <h4 class="primary-color ml-3">  {{ currency($bill->remaining()) }}</h4></div>
                </div>
            </div>
        </div>

        <!-- ./products-list -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">{{ trans("$trans.purchases") }}</h3>
                    <button type="button" class="btn btn-info btn-print"><i class="fa fa-plus"></i> {{ trans("home.print") }}</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="productsTable">
                        <thead>
                        <tr>
                            <th>@lang("products/products.product")</th>
                            <th>@lang("stocks.stock") </th>
                            <th>@lang("$trans.quantity") </th>
                            <th>@lang("$trans.price") </th>
                            <th>@lang("products/products.purchase_price") </th>
                            <th>@lang("$trans.price_after_discount") </th>
                            <th>@lang("products/products.sale_price") </th>
                            <th>@lang("products/products.price") </th>
                            <th>@lang("products/products.expired_at")</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" id="final-products-list-footer">
                    <input type="hidden" name="total_price" class="total-price-input">
                    <input type="hidden" name="transaction_id" id="transaction_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="ml-5">
{{--                                        {{ trans("$trans.total_price") }} : <span class="total-price primary-color">{{ num_to_arabic($bill->total_price) }}</span> <small></small>--}}
                                    </h3>
                                </div>
                                <!-- col -->
                                <div class="col-6">
                                    <h3 class="ml-5">
{{--                                        {{ trans("$trans.after_discount") }} : <span class="after-discount primary-color">{{ num_to_arabic($bill->total_price - $bill->discount ) }}</span> <small></small>--}}
                                    </h3>
                                </div>
                                <!-- col -->
                            </div>
                            <!-- ./row -->
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="row ml-auto">
                                <div class="col-6">
                                    <h3 class="ml-5">
{{--                                        {{ trans("$trans.total_paid") }} : <span class="paid primary-color">{{ num_to_arabic($bill->supplierBalance()->where("transaction_type","payment")->sum("paid")) }}</span> <small></small>--}}
                                    </h3>
                                </div>
                                <!-- ./col -->
                               <div class="col-6">
                                   <h3 class="ml-5">
{{--                                       {{ trans("$trans.residual") }} : <span class="residual primary-color">{{ num_to_arabic(($bill->total_price - $bill->discount) - $bill->supplierBalance()->where("transaction_type","payment")->sum("paid")) }}</span>--}}
                                   </h3>
                               </div>
                                <!-- ./col -->
                            </div>
                            <!-- ./row -->
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <!-- ./return shipping products-list -->
        <div class="col-12 ">
            <div class="card " >
                <div class="card-header">
                    <h3 class="card-title float-left">{{ trans("$trans.return_shipping") }}</h3>
                    <button type="button" class="btn btn-info " id="btn-print-return-shipping"><i class="fa fa-plus"></i> {{ trans("home.print") }}</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="returnedProductsTable">
                        <thead>
                        <tr>
                            <th>@lang("$trans.code")</th>
                            <th>@lang("$trans.quantity")</th>
                            <th>@lang("$trans.price")</th>
                            <th>@lang("balances.balance")</th>
                            <th>@lang("$trans.date")</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" id="final-products-list-footer">
                    <input type="hidden" name="total_price" class="total-price-input">
                    <input type="hidden" name="transaction_id" id="transaction_id">
                    <div class="row ">
                        <ul class="main-info d-flex list-unstyled w-100">
                            <li class="col-4 even">@lang("$trans.price") : <span class="primary-color">{{ currency($bill->returnedBills()->sum("price")) }}</span></li>
                            <li class="col-4 even">@lang("balances.paid") : <span class="primary-color">{{ num_to_arabic($bill->balances()->sum('paid')) }}</span></li>
                            <li class="col-4 even">@lang("balances.remaining") : <span class="primary-color">{{ num_to_arabic($bill->balances()->sum('paid')) }}</span></li>
                        </ul>
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



{{--    <script>window.open('Calculator:///'); </script>--}}
    @push("js")
        {!! datatable_files() !!}
        <script>

            transactions();
            $("#productsTable").table({
                columns: [
                    {data: 'product', name: 'product'},
                    {data: 'stock', name: 'stock'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'piece_price', name: 'piece_price'},
                    {data: 'purchase_price', name: 'purchase_price'},
                    {data: 'after_discount', name: 'after_discount'},
                    {data: 'sale_price', name: 'sale_price'},
                    {data: 'price', name: 'price'},
                    {data: 'expired_at', name: 'expired_at'},
                ],
                url: "{{ route("ajax.suppliers.bills.products",$bill->id) }}",
                data: {},
                notColumns: [
                    '#',
                    'actions'
                ]
            });
            $("#returnedProductsTable").table({
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'price', name: 'price'},
                    {data: 'balances', name: 'balances'},
                    {data: 'date', name: 'date'},
                ],
                url: "{{ route("ajax.suppliers.bills.returned.products",$bill->id) }}",
                data: {},
                notColumns: [
                    '#',
                    'actions'
                ]
            });
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
                    url: "{{ route("ajax.suppliers.bills.balances",$bill->id) }}",
                    data: {type: type,start: start,end: end},
                    notColumns: [
                        '#',
                        'actions'
                    ]
                });
            } //end of function transactions

            $(".btn-print").click(function () {
                window.open("/print/supplierBill-{{ $bill->id  }}/supplier-bill","_blank");
            });
            $("#btn-print-return-shipping").click(function () {
                window.open("/print/supplierBillReturn-{{ $bill->id  }}/supplier-bill-return","_blank");
            });
            $("#print-balance").click(function () {
                window.open("/print/supplierBalance-{{ $bill->id  }}/supplier-Balance","_blank");
            });

        </script>
    @endpush
@endsection
