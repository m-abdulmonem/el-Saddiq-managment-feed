@extends("site.layouts.index")
@section("content")
    @push("css")
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
    @endpush
    <div id="app" class="pt-5">
        <div class="row">
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>
                                <span class="btn btn-outline-primary w-100 m-1 btn-sell-medicine" data-toggle="modal" data-target="#medicinesModal">@lang("products/medicines.title")</span>
                            </li>
                            <li>
                                <span class="btn btn-outline-info w-100 m-1" data-toggle="modal" data-target="#chickBooking">@lang("chicks/booking.title")</span>
                            </li>
                            <li>
                                <span class="btn btn-outline-dark w-100 m-1" id="printLastInvoice">@lang("$trans.print_last_invoice")</span>
                            </li>
                            <li>
                                <span class="btn btn-outline-secondary w-100 m-1 mt-0 btn-add" data-toggle="modal" data-target="#clientModal" id="save">@lang("$trans.new_client")</span>
                            </li>
                            <li>
                                <span class="btn btn-outline-warning w-100 m-1" data-toggle="modal" data-target="#discardedModal" >@lang("$trans.discarded_sale")</span>
                            </li>
                            <li>
                                <span class="btn btn-outline-danger w-100 m-1 btn-close-daily">@lang("$trans.close_daily")</span>
                            </li>
                            <li style="margin: 20px 0"></li>
                            <li class="balance-text">
                                @lang("clients/bills.total_price") : <span class="odd total-price" id=""></span>
                            </li>
{{--                            <li class="balance-text">@lang("clients/bills.discount") : <span class="even total-discount" id=""></span></li>--}}
                            <li class="balance-text">@lang("balances.net") : <span class="odd total-net" id=""></span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-10">
                <form class="createInvoice" method="post">
                    <input type="hidden" id="credit">
                    <input type="hidden" id="profitInput">
                    <input type="hidden" value="postpaid" name="debt">
                    <input type="hidden" value="daily" name="daily">
                    <input type="hidden" name="total_price" id="totalPrice">
                    <input type="hidden" name="total_quantity" id="totalQuantity">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <span class="btn btn-info btn-save btn-paid"><i class="fa fa-save"></i> @lang("home.save")</span>
                            <h3 class="card-title float-left">@lang("$trans.products_list")</h3>
                        </div>
                        <div class="row pl-4 pr-4 pt-3">
                            <div class="col-6">
                                <product-search></product-search>
                            </div>
                            <div class="col-4 select2">
                                <label for="client">@lang("clients/clients.select_client")</label>
                                <user-search></user-search>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="status">@lang("clients/bills.select_status")</label>
                                    <select name="status" id="status" class="form-control">
                                        {{ select_options(['draft','loaded','onWay','delivered','canceled'],"status",null,"clients/bills") }}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <daily-table></daily-table>
                    </div>
                    @include("site.dailies.models.index")
                </form>
                @include("site.dailies.models.discarded_sale")
                @include("site.dailies.models.sell_medicines")
            </div>
        </div>
    </div>

    @include("site.clients.modals.client")
    @include("site.dailies.models.close_daliy")
    @include("site.chicks.booking.modals.index")


    <style>
        .balance-text {
            font-size: 20px;
            letter-spacing: 3px;
            margin: 10px 0;
        }

        .balance-text span {
            font-weight: bold;
        }
    </style>
    @push("js")
        <!-- Select2 -->
        <script src="{{ admin_assets("/js/select2.full.min.js") }}"></script>
        <script src="{{ admin_assets("/js/lang/select2_ar.js") }}"></script>

        <script>
            $(function () {
                $("body").on("click",".btn-save",function () {
                    ($("#productsTable tbody tr").length)
                        ? $("#saveInvoiceModal").modal("show")
                        : swal("@lang("$trans.alert_add_products_before")",{
                            icon: "warning",
                            timer: 3000
                        });
                });
                $("body").on("click",".btn-close-daily",function () {
                    // $(this).spanner();
                    $("#closeDailyModal").modal("show");
                });
                $("body").on("click","#printLastInvoice",function () {
                    ajaxApi({
                        url: '{{ route('ajax.client.print.last.invoice') }}',
                        success: function (data) {
                            console.log(data);
                            if (data.code === 1)
                                window.open(data.data[1]);
                        }
                    })
                });

            })
        </script>
    @endpush
@endsection
