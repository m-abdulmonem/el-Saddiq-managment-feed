@push("css")
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
@endpush
<div class="modal fade" id="chickBooking" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel bookingModalTitle" >@lang("chicks/booking.create")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="bookingForm">
                @csrf
                <input type="hidden" value="" id="id" name="id">
                <input type="hidden" name="client_id" id="clientId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group position-relative">
                                <label for="clientName" class="d-block">@lang("clients/clients.name")</label>
                                <select name='name' class="form-control client" id="clientName"></select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="clientPhone">@lang("clients/clients.phone")</label>
                                <input type="text" class="form-control " id="clientPhone" placeholder="@lang("clients/clients.phone")" name="phone" value="{{ old("phone") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="chick_id">@lang("chicks/booking.select_chick")</label>
                                <select class="form-control  @error('chick_id') is-invalid @enderror" name="chick_id" id="chick_id">
                                    {{ select_options_db(\App\Models\Chick\Chick::pluck("name","id"),"chick_id",null) }}
                                </select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="order_id">@lang("chicks/orders.select_order")</label>
                                <select class="form-control  @error('order_id') is-invalid @enderror" name="order_id" id="order_id">
                                    {{ select_options_db(\App\Models\Chick\ChickOrder::where("is_came",false)->pluck("name","id"),"order_id",null) }}
                                </select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="quantity">@lang("chicks/booking.quantity")</label>
                                <input type="number" min="5" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                       placeholder="@lang("chicks/booking.quantity")" name="quantity" value="{{ old("quantity") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="deposit">@lang("chicks/booking.deposit")</label>
                                <input type="number" min="20" step="any" class="form-control @error('deposit') is-invalid @enderror" id="deposit"
                                       placeholder="@lang("chicks/booking.deposit")" name="deposit" value="{{ old("deposit") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">@lang("home.close")</button>
                    <button type="submit" class="btn btn-primary" data-update="false">@lang("home.create")</button>
                </div>
            </form >
            <!-- ./form -->
        </div>
    </div>
</div>
@push("js")
    <!-- Select2 -->
    <script src="{{ admin_assets("/js/select2.full.min.js") }}"></script>
    <script src="{{ admin_assets("/js/lang/select2_ar.js") }}"></script>
    <script>
        let body = $("body"),modalTitle = $("#bookingModalTitle");
        $("#clientName").on("select2:select", function (e) {
            $("#clientPhone").val(e.params.data.phone);
            $("#clientId").val(e.params.data.id);
        });
        $("#clientName").select2({
            width: '100%',
            placeholder: "@lang("clients/clients.select_client")",
            ajax: {
                url: '/ajax/client/names',
                dataType: 'json',
                processResults: function (data) {
                    return {results: data[0]}
                }
            }
        });

        $(".btn-add").click(function () {
            btnCreate();
            $(this).spanner()
        });
        //
        $(".btn-close,.close").click(function () {
            if ($("#ma-admin-datatable").length > 0) $(".btn-add").removeSpanner()
        });
        

        body.on("click",".btn-update",function (e) {
            e.preventDefault();

            console.log($(this).data());

            $.each($(this).data(),function (k,v) {
                $(`#${k}`).val(v);
            });

            btnUpdate().parent().parent().find("#chick_id").val( $(this).data("chick-id") ).change().closest("#chickBooking").modal("show");
        });
        function btnCreate(){
            $(".modal-title").text("@lang("home.create")");
            return $("#bookingForm").trigger("reset").find("button[type=submit]")
                .html("<i class='fa fa-plus'></i> @lang("home.create")")
                .attr("data-update","false")
        }

        function btnUpdate(){
            $(".modal-title").text("@lang("home.update")");
            return $("#bookingForm").find("button[type=submit]")
                .html("<i class='fa fa-save'></i> @lang("home.save")")
                .attr("data-update","true")
        }


        $("#bookingForm").submit(function (e) {
            e.preventDefault();

            ($(this).find("button[type=submit]").data("update")) ? updateBooking( this ) : createBooking( this);
        });

        /**
         * create new record
         *
         * @param el
         */

        function createBooking(el) {
            console.log($(el).serialize());
            return ajaxApi({
                url: "{{ route("chicks.booking.store") }}",
                data: $(el).serialize(),
                type: "POST",
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        $("#chickBooking").modal("hide");
                        if ($("#ma-admin-datatable").length > 0) {
                            $("#ma-admin-datatable").DataTable().draw();
                            $(".btn-add").removeSpanner();
                        }
                        swal(data.text, {
                            'icon': "success",
                            'timer': 2000
                        });
                    }
                }
            });
        }

        /**
         * update specific record
         *
         * @param el
         */
        function updateBooking(el) {

            return ajaxApi({
                url: `/chicks/booking/${ $(el).find("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
               success: function (data) {
                   if (data.code === 1) {
                       $(el).closest("#chickBooking").modal("hide");
                       if ($("#ma-admin-datatable").length > 0)
                           $("#ma-admin-datatable").DataTable().draw();

                       swal(data.text, {
                           'icon': "success",
                           'timer' : 2000
                       });
                   }
               }
            });
        }

    </script>
@endpush
