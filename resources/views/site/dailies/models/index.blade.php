<div class="modal fade" id="saveInvoiceModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("$trans.contain_sale")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="invoiceForm">
                @csrf
                <input type="hidden" value="" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="paid">@lang("balances.paid")</label>
                                <input type="text" class="form-control" id="paid"
                                       placeholder="@lang("balances.paid")" name="postpaid" >
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="discountInput">@lang("balances.discount")</label>
                                <input type="text" class="form-control" id="discountInput"
                                       placeholder="@lang("balances.discount")" name="discount"
                                       {{ (auth()->id() != 1 && auth()->user()->discount_limit == 0) ? "disabled=disabled" : null }} >
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center align-content-center">
                            <h4>@lang("clients/bills.total_price") : <span class="total-net"></span></h4>
                        </div>
                        <!-- ./col -->
                        <div class="col-6 d-flex align-items-center align-content-center">
                            <h4>@lang("balances.remaining") : <span class="remaining"></span></h4>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">@lang("home.close")</button>
                    <button type="submit" class="btn btn-info" id="btnSave" data-update="false">@lang("$trans.save_print")</button>
                </div>
            </form >
            <!-- ./form -->
        </div>
    </div>
</div>

@push("js")
    <script>

        $(".btn-add").click(function () {
            $(this).spanner();
            $("#create").find("button[type=submit]")
                .html("<i class='fa fa-plus'></i> @lang("home.create")")
                .attr("data-update","false");
        });

        // $(".btn-close,.close").click(function () {
        //     $(".btn-add").removeSpanner()
        // });

        $("body").on("change","#paid",function () {
            let remaining = parseFloat($("#totalPrice").val()) - parseFloat($(this).val()), userLimit = parseFloat("{{ auth()->user()->creditLimit() }}") , admin = parseInt("{{ auth()->id() }}");

            if (admin !== 1 && (userLimit -remaining) <0){
                $("#btnSave").addClass("disabled").attr("disabled","disabled");
                swal("@lang("users/users.alert_credit_limit")",{
                    icon: "error",
                    timer: 3000
                });
            }else
                $("#btnSave").removeClass("disabled").removeAttr("disabled");

            $(".remaining").text(formatter.format(remaining))
        });

        $("body").on("change","#discountInput",function () {
            const remaining = parseFloat("{{ auth()->user()->discountLimit() }}"),
                price = parseFloat($("#totalPrice").val())-parseFloat($(this).val()),
                net = price - parseFloat($("#paid").val());

            if ((remaining - parseFloat($(this).val())) >=0) {
                if (parseFloat($("#profitInput").val()) >= parseFloat($(this).val())){
                    $(".total-net").text(formatter.format(price));
                    $(".remaining").text(formatter.format(net))
                }
                else{
                    swal(` هذا الخصم غير مسموح به المتاح هو ${formatter.format($("#profitInput").val())}`,{
                        icon: "warning",
                        timer: 3000
                    });
                    $(this).val("");
                }
            } else {
                swal("@lang("$trans.alert_discount_grater_limit")",{
                    icon: "warning",
                    timer: 3000
                });
                $(this).val("");
            };
        });

        $('body').on('submit','.createInvoice', function(e){
            e.preventDefault();
            
            if ($(".btn-save").hasClass("btn-paid"))
                ajaxApi({
                url: "{{ route("invoices.store") }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(this).trigger("reset");
                        $("#remaining,.total-net,.total-price").text(formatter.format(0));
                        $("body").find("tbody tr").remove();
                        $("#saveInvoiceModal").modal("hide");
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $("#paid").val("");
                        window.open(`/ajax/client/print/invoice/${data.data[1].id}`);
                        swal(data.text, {
                            'icon': "success",
                            'timer': 2000
                        });
                    }
                },
            });
            else
                ajaxApi({
                url: `/clients/invoices/${$("#invoiceId").val()}`,
                type: "PUT",
                data: $(this).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(this).trigger("reset");
                        $("body").find("tbody tr").remove();
                        $("#remaining,.total-net,.total-price").text(formatter.format(0));
                        $(".btn-save").removeClass("btn-returned").addClass("btn-paid");
                        $("#invoiceId,#invoiceType").remove();
                        $("#saveInvoiceModal").modal("hide");
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $("#paid").val("");
                        // window.open(`/ajax/client/print/invoice/${data.data[1].id}`);
                        swal(data.text, {
                            'icon': "success",
                            'timer': 2000
                        });
                    }
                },
            })

        });
    </script>
@endpush
