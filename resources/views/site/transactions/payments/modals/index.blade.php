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
                <div class="modal-body">
                    @csrf
                    <div class="form-group ">
                        <label for="payment" class="d-block">@lang("$trans.payment")</label>
                        <select name="payment" id="payment" class="form-control">
                            <option value="cash">@lang("$trans.cash")</option>
                            <option value="cheque">@lang("$trans.cheque")</option>
                        </select>
                        <div class="alert alert-danger hide"></div>
                    </div>

                    <div class="form-group ">
                        <label for="payment_type" class="d-block">@lang("$trans.payment_way")</label>
                        <select name="payment_type" id="payment_type" class="form-control">
                            <option value="expenses">@lang("$trans.expenses")</option>
                            <option value="bank_deposit">@lang("$trans.bank_deposit")</option>
                            <option value="pay_for_supplier">@lang("$trans.pay_for_supplier")</option>
                        </select>
                        <div class="alert alert-danger hide"></div>
                    </div>

                    <div class="form-group ">
                        <label for="paymentTo" class="d-block payment-to-title">@lang("transactions/expenses.title")</label>
                        <select name="" id="paymentTo" class="form-control"></select>
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
            expenses();
            $("#payment_type").change(function () {
                switch ($(this).val()) {
                    case "pay_for_supplier":
                        suppliers();
                        break;
                    case "bank_deposit":
                        banks();
                        break;
                    case "expenses":
                        expenses();
                        break;
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

                $.each($(this).data(),function (k,v) {
                    $(`#${k}`).val(v);
                });
                btnUpdate().closest("#paymentsModal").modal("show");

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

                return $("#paymentsForm").trigger("reset").find("button[type=submit]")
                    .html("<i class='fa fa-plus'></i> @lang("home.create")")
                    .attr("data-update","false");
            }

            function btnUpdate() {
                $(".modal-title").text("@lang("home.update")");
                return $("#paymentsForm").find("button[type=submit]")
                    .html("<i class='fa fa-save'></i> @lang("home.save")")
                    .attr("data-update","true")
            }

            function suppliers() {
                $(".payment-to-title").text("@lang("suppliers/suppliers.title")");
                $("#paymentTo").attr("name","supplier_id").select2({
                    width: '100%',
                    placeholder: "@lang("products/products.select_supplier")",
                    ajax: {
                        url: '{{ route("ajax.products.suppliers") }}',
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data[0]
                            }
                        }
                    }
                });
            }
            
            function banks() {
                $(".payment-to-title").text("@lang("transactions/banks.title")");
                $("#paymentTo").attr("name","bank_id").select2({
                    width: '100%',
                    placeholder: "@lang("$trans.select_bank")",
                    ajax: {
                        url: '{{ route("ajax.transactions.banks.names") }}',
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data[0]
                            }
                        }
                    }
                });
            }
            
            function expenses() {
                $(".payment-to-title").text("@lang("transactions/expenses.title")");
                $("#paymentTo").attr("name","expense_id").select2({
                    width: '100%',
                    placeholder: {id: "-1",text: "@lang("$trans.select_expense")"},
                    ajax: {
                        url: '{{ route("ajax.transactions.expenses.names") }}',
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data[0]
                            }
                        }
                    }
                });
            }


            /**
             * create new record
             *
             * @param el
             */

            function create(el) {
                ajaxApi({
                    url: "{{ route("payments.store") }}",
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
                        }
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
                    url: `/payments/${ $(el).find("#id").val() }`,
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
