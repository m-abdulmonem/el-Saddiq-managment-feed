<div class="modal fade" id="chickBookingDelivered" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("chicks/booking.delivered")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="form-delivered">
{{--                @csrf--}}
                <input type="hidden" value="" id="bookingId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            @lang("chicks/orders.price") : <span class="info-color " id="totalprice"></span>
                        </div>
                        <!-- ./col -->
                        <div class="col-3">
                            @lang("balances.deposit") : <span class="info-color " id="deliveredDeposit"></span>
                        </div>
                        <!-- ./col -->
                        <div class="col-3">
                            <input type="hidden" name="net" id="inputNet">
                            @lang("balances.net") : <span class="info-color" id="net"></span>
                        </div>
                        <!-- ./col -->
                        <div class="col-3">
                            @lang("balances.remaining") : <span class="info-color " id="rest"></span>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->

                    <div class="col-12 mt-2">
                        <div class="form-inline ">
                            <label for="paid" class="d-block">@lang("balances.paid")</label>
                            <input type="number" step="any"  class="form-control w-100" id="paid" placeholder="@lang("balances.paid")"
                                   name="paid" autocomplete="off">

                            <div class="alert alert-danger hide"></div>
                        </div>
                    </div>
                    <!-- ./col -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">@lang("home.close")</button>
                    <button type="submit" class="btn btn-primary btn-save-booking"><i class="fa fa-save"></i>@lang("home.save")</button>
                </div>
            </form >
            <!-- ./form -->
        </div>
    </div>
</div>
@push("js")
    <!-- numbers format -->
    <script src="{{ admin_assets("/js/jquery.number.min.js") }}"></script>
    <script src="{{ admin_assets("/js/persianumber.min.js") }}"></script>
    <script>
        $(".btn-save-booking").click(function (e) {
            e.preventDefault();
            delivered(this)
        });

        
        $("#paid").keyup(function () {
            $("#rest").text( $("#inputNet").val() - $(this).val() )
        });
        
        
        $("body").on("click",".btn-delivered",function (e) {
            e.preventDefault();

            $("#inputNet").val( $(this).data("net") );
            $("#bookingId").val( $(this).data("bookingId") );


            $.each($(this).data(),function (k,v) {
                $(`#${k}`).text( $.number(v, 2) ).persiaNumber("ar");
            });

            $("#chickBookingDelivered").modal("show");
        });

        /**
         * update specific record
         *
         * @param el
         */
        function delivered(el) {
            ajaxApi({
                url: `/ajax/chick/booking/delivered/${ $("#bookingId").val() }`,
                type: "PUT",
                data:  {paid: $("#paid").val()},
                success: function (data) {
                    if (data.code === 1) {

                        $(el).closest("#client").modal("hide");

                        $("#ma-admin-datatable").DataTable().draw();

                        swal(data.text, {
                            'icon': "success",
                            'timer' : 2000
                        });
                    }
                },
            });
        }

    </script>
@endpush
