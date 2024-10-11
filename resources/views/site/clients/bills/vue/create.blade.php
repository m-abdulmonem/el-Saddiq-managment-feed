@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css",false) !!}
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ admin_assets("select2.min.css") }}">
    @endpush

    <div id="app">
        <div class="row">
            <div class="col-12">
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
                            <span class="btn btn-info btn-paid"><i class="fa fa-save"></i> @lang("home.save")</span>
                            <h3 class="card-title float-left">@lang("dailies.products_list")</h3>
                        </div>
                        <div class="row pl-4 pr-4 pt-3">
                            <div class="col-6">
                                <search></search>
                            </div>
                            <div class="col-4 select2">
                                <label for="client">@lang("clients/clients.select_client")</label>
                                <select2></select2>
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
                        <div class="card-footer">
                            <ul class="list-unstyled d-flex main-info">
                                <li class="w-50">@lang("clients/bills.total_price") : <span class="total-price"></span></li>
                                <li>@lang("balances.net") : <span class="total-net"></span></li>
                            </ul>
                        </div>
                    </div>
                    @include("site.dailies.models.index")
                </form>
                @include("site.dailies.models.discarded_sale")
            </div>
        </div>
    </div>
    @push("js")
        <!-- Select2 -->
        <script src="{{ admin_assets("select2.full.min.js") }}"></script>
        <script src="{{ admin_assets("lang/select2_ar.js") }}"></script>

        <script>
            $("body").on("click",".btn-paid",function () {
                ($("#productsTable tbody tr").length)
                    ? $("#saveInvoiceModal").modal("show")
                    : swal("@lang("$trans.alert_add_products_before")",{
                        icon: "warning",
                        timer: 3000
                    });
            });
        </script>
    @endpush
@endsection
