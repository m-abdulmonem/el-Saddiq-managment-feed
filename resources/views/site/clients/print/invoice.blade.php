@include("pdf.layouts.head")
@include("pdf.layouts.header")
    <div class="text-center title">@lang("$trans.invoice")</div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-6">
            <h4>@lang("clients/bills.bill_number") : <span> {{ num_to_ar($invoice->code )}} </span></h4>
            <h4>@lang("clients/bills.client") : <span> {{ $invoice->client->name() }} </span> </h4>
            <h4>@lang("clients/clients.address") : <span> {{ $invoice->client->address }} </span> </h4>
        </div>
        <!-- /.col -->
        <div class="col-6">
            <h4>@lang("home.date") : <span> {{ num_to_ar( $invoice->created_at->format("Y-m-d"))  }} </span></h4>
            <h4>@lang("clients/clients.phone") : <span> {{ num_to_ar($invoice->client->phone) }} </span></h4>
            <h4>@lang("suppliers/bills.quantity") : <span> {{ num_to_ar($invoice->products()->sum("quantity")) }}</span></h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="list">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang("products/products.name")</th>
                <th>@lang("products/products.unit_price")</th>
                <th>@lang("products/products.quantity")</th>
                <th>@lang("products/products.total_weight")</th>
{{--                @if($invoice->client->trader)--}}
{{--                    <th>@lang("products.quantum")</th>--}}
{{--                @endif--}}
                <th>@lang("products/products.total_price")</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 1; @endphp
            @foreach($invoice->products as $product)
                <tr>
                    <th>{{ $i++ }}</th>
                    <th>{{ $product->nameSupplier() }}</th>
                    <th>{{ currency($product->pivot->piece_price) }}</th>
                    <th>{{ num_to_ar($product->pivot->quantity) }}</th>
                    <th>{{ num_to_ar($product->pivot->quantity * $product->weight) ?? "-" }}</th>
{{--                    @if($invoice->client->is_trader)--}}
{{--                        <th>@lang("products.ton",['ton' => num_to_ar(($product->pivot->quantity * $product->pivot->quantity) / 1000)])</th>--}}
{{--                    @endif--}}
                    <th>{{ currency($product->pivot->price) }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row main-info total">
        <ul class="list-unstyled d-flex w-100" style="font-size: 25px">
            <li class="col-4"><span class="title">@lang("clients/bills.total_price") : </span> {{currency($invoice->price)}}</li>
            <li class="col-4"><span class="title">@lang("balances.discount") : </span> {{currency($invoice->discount)}}</li>
            <li class="col-4"><span class="title">@lang("balances.net") : </span> {{currency($invoice->price - $invoice->discount)}}</li>
        </ul>
        <ul class="list-unstyled d-flex w-100" style="font-size: 25px">
            <li class="col-8">{{ spell_out( $invoice->price - $invoice->discount  ) }} جنية لاغير</li>
            <li class="col-4"><span class="title">@lang("balances.option_prev_balance") : </span> {{ currency($invoice->client->prevBalance()) }}</li>
        </ul>
        <ul class="list-unstyled d-flex w-100" style="font-size: 25px">
            <li class="col-8"></li>
            <li class="col-4"><span class="title">@lang("balances.option_current_balance") : </span> {{ currency($invoice->currentBalance()) }}</li>
        </ul>
    </div>

@include("pdf.layouts.footer")
<div class="page-break"></div>

<style>
    @media print {
        .payments-voucher{
            max-height: 100%;
            overflow: hidden;
            page-break-after: always;
        }
        .border:first-of-type{
            margin-bottom: 8%;
        }
        .receipt-content{
            padding: 20px 0;
        }
    }
</style>

@if($invoice->balances()->where("type","catch")->sum("paid") < $invoice->price)
    @for($i =0; $i< 2; $i++)
        <div class="receipt-content">
            <div class="border">
                @include("pdf.layouts.header")
                <style>
                    /*body:after{*/
                    /*    background: #fff!important;*/
                    /*}*/
                    .invoice-info{
                        font-size: 40px;
                    }
                </style>
                <div class="text-center title">@lang("transactions/receipts.receive")</div>
                <!-- info row -->
                <div class="row invoice-info mt-5">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6"><h4 class="mb-3">@lang("$trans.bill_number") : <span> {{ ($invoice->code )}} </span></h4></div>
                            <div class="col-6"><h4 class="mb-3">@lang("home.date") : <span> {{ num_to_ar( $invoice->created_at->format("Y-m-d"))  }} </span></h4></div>
                            <div class="col-12"><h4 class="mb-3">@lang("clients/clients.client") : <span> {{ $invoice->client->name() }} </span></h4></div>
                            <div class="col-6"><h4 class="mb-3">@lang("$trans.total_price") : <span> {{ currency($invoice->price - $invoice->discount) }} </span></h4></div>
                            <div class="col-6"><h4>@lang("suppliers/bills.quantity") : <span> {{ num_to_ar($invoice->products()->sum("quantity")) }}</span></h4></div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- info row -->
                <div class="row invoice-info mt-5 text-center" style="padding: 20px 0">
                    <div class="col-6">
                        <h2>@lang("balances.paid") : <span>  </span></h2>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <h2>@lang("balances.remaining") : <span>  </span></h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- info row -->
                <div class="row invoice-info mt-5" style="padding-bottom: 5%">
                    <div class="col-6">
                        <h4>@lang("transactions/payments.receiver_signature") : <span> ................ </span></h4>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <h4>@lang("transactions/payments.user_signature") : <span> ................ </span></h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
    @endfor
@endif


@push("js")
    window.onafterprint = function () {
        window.location.href = "{{ back() }}"
    };
@endpush
@include("pdf.layouts.footer")


