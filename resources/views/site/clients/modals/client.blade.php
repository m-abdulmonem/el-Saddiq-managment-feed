<div class="modal fade" id="clientModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("$trans.create")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="create">
                @csrf
                <input type="hidden" value="" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">@lang("clients/clients.name")</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="@lang("clients/clients.name")" name="name" value="{{ old("name") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">@lang("clients/clients.phone")</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="@lang("clients/clients.phone")" name="phone" value="{{ old("phone") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="trader">@lang("clients/clients.select_account_type")</label>
                                <select class="form-control  @error('trader') is-invalid @enderror" name="trader" id="trader">
                                    {{ select_options(['false','true'],"trader",null,"clients/clients") }}
                                </select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="discount">@lang("clients/clients.discount"))</label>
                                <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" disabled placeholder="@lang("clients/clients.discount"))" name="discount" value="{{ old("discount") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->

                        <div class="col-6">
                            <div class="form-group ">
                                <label for="credit_limit">@lang("clients/clients.credit_limit")</label>
                                <input type="number" step="any" class="form-control " id="credit_limit" placeholder="@lang("clients/clients.credit_limit")" name="credit_limit">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="maximum_repayment_period">@lang("clients/clients.maximum_repayment_period")</label>
                                <input type="number" class="form-control" id="maximum_repayment_period" placeholder="@lang("clients/clients.maximum_repayment_period")"
                                       name="maximum_repayment_period">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->

                        <div class="col-6">
                            <div class="form-group ">
                                <label for="creditor">@lang("balances.creditor")</label>
                                <input type="number" class="form-control" id="creditor" placeholder="@lang("balances.creditor")" name="creditor">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="debtor">@lang("balances.debtor")</label>
                                <input type="number" class="form-control" id="debtor" placeholder="@lang("balances.debtor")" name="debtor">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->

                        <div class="col-12">
                            <div class="form-group ">
                                <label for="address">@lang("clients/clients.address")</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="@lang("clients/clients.address")" name="address" value="{{ old("address") }}">
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
    <script>

        /**
         *
         */
        $(".btn-add").click(function () {
            btnCreate();
            $(this).spanner()
        });

        $(".btn-close,.close").click(function () {
            if ($("#clientsTable").length >0)
                $(".btn-add").removeSpanner()
        });


        $("body").on("click",".btn-update",function (e) {
            e.preventDefault();

            $.each($(this).data(),function (k,v) {
                $(`#${k}`).val(v);
            });

            btnUpdate().parent().parent().find("#trader")
                .val( $(this).data("trader").replace("options_","") ).change()
                .closest("#clientModal").modal("show");

        });

        /**
         *
         *
         */
        $("#create").submit(function (e) {
            e.preventDefault();

            if ($(this).find("button[type=submit]").data("update"))
                updateClient( this );
            else
                createClient( this);
        });

        function btnCreate() {
            return $("#create").find("button[type=submit]")
                .html("<i class='fa fa-plus'></i> @lang("home.create")")
                .attr("data-update","false");
        }

        function btnUpdate() {
            return $("#create").find("button[type=submit]")
                .html("<i class='fa fa-save'></i> @lang("home.save")")
                .attr("data-update","true")
        }

        /**
         * create new record
         *
         * @param el
         * @param callback
         */

        function createClient(el) {
            ajaxApi({
                url: "{{ route("clients.store") }}",
                type: "POST",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        $("#clientModal").modal("hide");
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        if ($("#clientsTable").length > 0) {
                            $("#clientsTable").DataTable().draw();
                            $(".btn-add").removeSpanner();
                            $(".modal-backdrop").remove()
                        }
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
        function updateClient(el) {
            ajaxApi({
                url: `/clients/${ $(el).find("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");

                        $(el).closest("#clientModal").modal("hide");
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $("#clientsTable").DataTable().draw();
                        $(".btn-add").removeSpanner()
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
