<div class="modal fade" id="chicksOrdersArrived" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel titleChicksOrdersArrived">@lang("chicks/orders.receive_order")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="savePriceForm">
                @csrf
                <input type="hidden" value="" id="OrderArrivedId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="price">@lang("chicks/orders.price")</label>
                                <input type="number" step="any" class="form-control @error('price') is-invalid @enderror" id="price"
                                       placeholder="@lang("chicks/orders.price")" name="price" value="{{ old("price") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="chick_price">@lang("chicks/orders.chick_price")</label>
                                <input type="number" step="any" class="form-control @error('chick_price') is-invalid @enderror" id="chick_price"
                                       placeholder="@lang("chicks/orders.chick_price")" name="chick_price" value="{{ old("chick_price") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="paid">@lang("balances.paid")</label>
                                <input type="number" step="any" class="form-control" id="paid"
                                       placeholder="@lang("balances.paid")" name="paid" >
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-save-price" data-update="false"><i class="fa fa-save"></i> @lang("home.save")</button>
                    <button type="button" class="btn btn-link btn-close note-color" data-dismiss="modal"><i class="fa fa-times"></i> @lang("home.close")</button>
                </div>
            </form >
            <!-- ./form -->
        </div>
    </div>
</div>


@push("js")
    <script>
        let prices = $("#chicks_price"),
            price = $("#chick_price"),
            quantity;
        $("body").on("click",".btn-arrived",function () {
            quantity = $(this).data("quantity");

            $("#OrderArrivedId").val( $(this).data("id") );

            $("#chicksOrdersArrived").modal("show");

        });

        $(".btn-save-price").click(function (e) {
            e.preventDefault();
            let $this = this;
            swal({
                title: "@lang("home.alert_confirm")",
                text: "@lang("chicks/orders.transaction_confirm_text")",
                icon: "info",
                buttons: true,
                // dangerMode: true,
            }).then((changePrice) => {
                if (changePrice)
                    savePrice($this)
            });
        });

        /**
         * update specific record
         *
         */
        function savePrice() {
            ajaxApi({
                url: `/ajax/chick/orders/arrived/${ $("#OrderArrivedId").val() }`,
                data: $("#savePriceForm").serialize(),
                type: "PUT",
                success: function (data) {
                    if (data.code === 1) {

                       $("#chicksOrdersArrived").modal("hide");

                        $("#ma-admin-datatable").DataTable().draw();

                        swal(data.text, {
                            'icon': "success",
                            'timer' : 2000
                        });
                    }
                },
            })
        }

    </script>
@endpush
