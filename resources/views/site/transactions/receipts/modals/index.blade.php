@push("css")
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ admin_assets("select2.min.css") }}">
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
                <input type="hidden" id="invoiceId" name="invoice_id">
                <div class="modal-body">
                    @csrf
                    <div class="row bill-info" style="display: none">
                        <div class="col-12">
                            <ul class="list-unstyled main-info">
                                <li>@lang("clients/clients.name"): <span id="client"></span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled main-info">
                                <li>@lang("balances.remaining") : <span id="remaining"></span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled main-info total-invoice-price">
                                <li>@lang("suppliers/bills.total_price") : <span id="price"></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="payment" class="d-block">@lang("transactions/payments.payment")</label>
                        <select name="payment" id="payment" class="form-control">
                            <option value="cash">@lang("transactions/payments.cash")</option>
                            <option value="bank">@lang("transactions/banks.bank")</option>
                        </select>
                        <div class="alert alert-danger hide"></div>
                    </div>

                    <div class="form-group ">
                        <label for="type_catch_sales" class="d-block">@lang("$trans.type")</label>
                        <select name="type_catch_sales" id="type_catch_sales" class="form-control">
                            <option value="invoices" selected>@lang("$trans.invoices")</option>
                            <option value="clients">@lang("$trans.clients")</option>
                        </select>
                        <div class="alert alert-danger hide"></div>
                    </div>


                    <div class="form-group invoices-list">
                        <label for="invoice" class="d-block payment-to-title">@lang("transactions/payments.select_invoice")</label>
                        <select name="invoice_id" id="invoice" class="form-control"></select>
                        <div class="alert alert-danger hide"></div>
                    </div>
                    <div class="form-group clients-list ">
                        <label for="client" class="d-block payment-to-title">@lang("clients/clients.select_client")</label>
                        <select name="client_id" id="client" class="form-control"></select>
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
    <script src="{{ admin_assets("select2.full.min.js") }}"></script>
    <script src="{{ admin_assets("lang/select2_ar.js") }}"></script>

    <script>


        $(function () {
            invoices();


            $("#type_catch_sales").change(function () {

                switch ($(this).val()) {
                    case "invoices":
                        console.log('invoices')
                        $('invoices-list').addClass('show').removeClass('hide')
                        $('clients-list').addClass('hide').removeClass('show')
                        invoices();
                        break;
                    case "clients":
                        console.log('clients')
                        $('invoices-list').addClass('hide').removeClass('show')
                        $('clients-list').addClass('show').removeClass('hide')
                        clients();
                        break;
                    // default :
                    //     console.log('default')
                    //     $('clients-list').addClass('hide').removeClass('show')
                    //     $('invoices-list').addClass('show').removeClass('hide')
                    //     invoices();
                    //     break;
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
                $.each($(this).data(),function (k,v) {
                    let cond = k === "client" ? v : formatter.format(v);
                    $(`#${k}`).val(v).text(cond);
                });
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
                $("#invoice").removeAttr("disabled").removeClass("disabled").parent().show();
                return $("#paymentsForm").trigger("reset").find("button[type=submit]")
                    .html("<i class='fa fa-plus'></i> @lang("home.create")")
                    .attr("data-update","false");
            }

            function btnUpdate(el) {
                $("#invoice").attr("disabled","true").addClass("disabled").parent().hide();
                $(".modal-title").text("@lang("$trans.update") " + $(el).data("bill-code"));
                return $("#paymentsForm").find("button[type=submit]")
                    .html("<i class='fa fa-save'></i> @lang("home.save")")
                    .attr("data-update","true")
            }

            function invoices() {
                $("#invoice").on("select2:select", function (e) {
                    $('.total-invoice-price').show();
                    $.each(e.params.data,function (k,v) {
                        $(`#${k}`).text(v)
                    });
                    $(".bill-info").show();
                    console.log(e.params.data)
                });
                $("#invoice").select2({
                    width: '100%',
                    placeholder: "@lang("transactions/payments.select_invoice")",
                    ajax: {
                        url: '{{ route("ajax.clients.invoices.codes") }}',
                        {{--url: '{{ route("ajax.clients.names") }}',--}}
                        dataType: 'json',
                        processResults: function (data) {
                            return {results: data[0]}
                        }
                    }
                });
            }

            function clients() {
                $("#client").on("select2:select", function (e) {
                    const data = e.params.data;
                    $(`#client`).text(data.text)
                    $(`#remaining`).text(data.debit);
                    $('.total-invoice-price').hide();
                    $(".bill-info").show();
                    // console.log(e.params.data)
                });
                $("#client").select2({
                    width: '100%',
                    placeholder: "@lang("clients/clients.select_client")",
                    ajax: {
                        url: '{{ route("ajax.clients.names") }}',
                        dataType: 'json',
                        processResults: function (data) {
                            return {results: data[0]}
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
                    url: "{{ route("sales.store") }}",
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
                    url: `/receipts/sales/${ $(el).find("#id").val() }`,
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
