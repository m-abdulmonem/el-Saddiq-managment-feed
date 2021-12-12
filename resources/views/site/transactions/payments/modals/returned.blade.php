@push("css")
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
@endpush
<div class="modal fade" id="paymentsModal" tabindex="-1" role="dialog" aria-labelledby="jobLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="paymentsForm">
                <input type="hidden" id="id">
                <input type="hidden" id="billId" name="client_bill_id">
                <input type="hidden" id="remaining" name="remaining">
                <div class="modal-body">
                    @csrf
                    <div class="row bill-info" style="display: none">
                        <div class="col-12">
                            <ul class="list-unstyled main-info">
                                <li>@lang("clients/clients.name"): <span id="supplier"></span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled main-info">
                                <li>@lang("balances.remaining") : <span id="remainingBalance"></span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled main-info">
                                <li>@lang("suppliers/bills.total_price") : <span id="price"></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="payment" class="d-block">@lang("$trans.payment")</label>
                        <select name="payment" id="payment" class="form-control">
                            <option value="cash">@lang("$trans.cash")</option>
                            <option value="cheque">@lang("$trans.cheque")</option>
                        </select>
                        <div class="alert alert-danger hide"></div>
                    </div>

                    <div class="form-group ">
                        <label for="bill" class="d-block">@lang("$trans.select_bill")</label>
                        <select name="client_bill_id" id="bill" class="form-control"></select>
                        <div class="alert alert-danger hide"></div>
                    </div>

                    <div class="form-group ">
                        <label for="paid">@lang("balances.paid")</label>
                        <input class="form-control" name="paid"
                               placeholder="@lang("balances.paid")" id="paid" data-role="tagsinput">
                        <div class="alert alert-danger hide"></div>
                    </div>

                </div>
                <div class="modal-footer float-left">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal"><i class="fa fa-times"></i> @lang("home.close")</button>
                    <button type="submit" class="btn btn-primary btn-action " data-update=""><i class="fa fa-plus"></i>@lang("home.create")</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push("js")
    <!-- Select2 -->
    <script src="{{ admin_assets("/js/select2.full.min.js") }}"></script>
    <script src="{{ admin_assets("/js/lang/select2_ar.js") }}"></script>

    <script>

        $(function () {
            $("#bill").on("select2:select", function (e) {
                $.each(e.params.data,function (k,v) {
                    $(`#${k}`).text(v)
                });
                // $("#billId").val(e.params.data['id']);
                $(".bill-info").show();
            });
            $("#bill").select2({
                width: '100%',
                placeholder: {id: "-1",text: "@lang("$trans.select_bill")"},
                ajax: {
                    url: '{{ route("ajax.clients.invoices.returned.names") }}',
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data[0]
                        }
                    }
                }
            });

            $(".btn-add").click(function () {
                btnCreate();

                $("#paymentsModal").modal("show");
                $(this).spanner()
            });

            $(".btn-close,.close").click(function () {
                $(".btn-add").removeSpanner()
            });

            $("body").on("click",".btn-update",function (e) {
                e.preventDefault();
                $(".bill-info").show();
                $("#bill").parent().hide();
                $.each($(this).data(),function (k,v) {
                    $(`#${k}`).val(v);
                    $(`#${k}`).text(v);
                });
                $("#price").text(formatter.format($(this).data("price")));
                $("#remainingBalance").text(formatter.format($(this).data("remaining").toString().replace("-","")));
                btnUpdate(this).closest("#paymentsModal").modal("show");

            });

            /**
             *
             *
             */
            $("#paymentsForm").submit(function (e) {
                e.preventDefault();

                ($(this).find("button[type=submit]").data("update")) ? update( this ) : create( this);
            });

            function btnCreate() {
                $(".modal-title").text("@lang("home.create")");
                $("#bill").parent().show();
                $(".bill-info").hide();
                return $("#paymentsForm").trigger("reset").find("button[type=submit]")
                    .html("<i class='fa fa-plus'></i> @lang("home.create")")
                    .attr("data-update","false");
            }

            function btnUpdate(el) {
                $(".modal-title").text("@lang("$trans.update") " + $(el).data("bill-code"));
                return $("#paymentsForm").find("button[type=submit]")
                    .html("<i class='fa fa-save'></i> @lang("home.save")")
                    .attr("data-update","true")
            }


            /**
             * create new record
             *
             * @param el
             */

            function create(el) {
                ajaxApi({
                    url: "{{ route("returned.store") }}",
                    type: "POST",
                    data: $(el).serialize(),
                    success: function (data) {
                        if (data.code === 1) {
                            $(el).trigger("reset");
                            $("#paymentsModal").modal("hide");
                            $("#paymentsTable").DataTable().draw();
                            $(".btn-add").removeSpanner();
                            swal(data.text, {
                                'icon': "success",
                                'timer': 2000
                            });
                        }else
                            swal(data.text, {
                                'icon': "info",
                                'timer': 2000
                            });
                    },
                });
            }

            /**
             * update specific record
             *
             * @param el
             */
            function update(el) {
                ajaxApi({
                    url: `/payment/returned/${ $(el).find("#id").val() }`,
                    type: "PUT",
                    data: $(el).serialize(),
                    success: function (data) {
                        if (data.code === 1) {
                            $(el).trigger("reset");

                            $(el).closest("#paymentsModal").modal("hide");
                            $("#paymentsTable").DataTable().draw();

                            $(".btn-add").removeSpanner();
                            swal(data.text, {
                                'icon': "success",
                                'timer' : 2000
                            });
                        }
                    },
                });
            }

        })
    </script>
@endpush
