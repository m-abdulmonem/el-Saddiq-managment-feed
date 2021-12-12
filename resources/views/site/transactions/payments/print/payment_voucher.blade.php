@include("pdf.layouts.head")

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
        }
    </style>
    @for($i =0; $i< 2; $i++)
        <div class="border">

            @include("pdf.layouts.header")
            <style>
                body:after{
                    background: #fff!important;
                }
                .invoice-info{
                    font-size: 40px;
                }
            </style>
            <div class="text-center title">@lang("$trans.payment_voucher")</div>
            <!-- info row -->
            <div class="row invoice-info mt-5">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6"><h4 class="mb-3">@lang("$trans.code") : <span> {{ ($payment->code )}} </span></h4></div>
                        <div class="col-6"><h4 class="mb-3">@lang("home.date") : <span> {{ num_to_ar( $payment->created_at->format("Y-m-d"))  }} </span></h4></div>
                    </div>

                    <h4 class="mb-3">@lang("$trans.receiver") : <span> {{ ( $payment->bank->name ?? $payment->expense->name ?? $payment->supplier->name ?? "") }} </span> </h4>
                    <h4 class="mb-3">@lang("$trans.paid") : <span> {{ currency($payment->paid) }} لاغير. </span> </h4>
                    <h4 class="mb-3">@lang("$trans.payment_way") : <span> @lang("$trans.$payment->payment") </span></h4>

                    <h4 class="mb-3 w-100">
                        @lang("$trans.payment_for") :
                        <span>
                            @lang("$trans.expenses.title") :
                            {!! $payment->supplier ? trans("$trans.pay_for_supplier") : ($payment->bank ? trans("$trans.bank_deposit") : ($payment->expense ? "<span class='font-weight-bold'>{$payment->expense->name}</span>": "")) !!}
                            @lang("$trans.payment_number",['code' => $payment->code])
                        </span>
                    </h4>
                </div>
                <!-- /.col -->
                <div class="col-6">

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- info row -->
            <div class="row invoice-info mt-5" style="padding-bottom: 5%">
                <div class="col-6">
                    <h4>@lang("$trans.receiver_signature") : <span> ................ </span></h4>
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <h4>@lang("$trans.user_signature") : <span> ................ </span></h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            @include("pdf.layouts.foot")
        </div>
    @endfor
@push("js")
    window.onafterprint = function () {
        window.location.href = "{{ route("payments.index") }}"
    };
@endpush
@include("pdf.layouts.foot")
