<div class="modal fade" id="supplierModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("$trans.create")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form id="supplierForm" class="modal-form">
                @csrf
                <input type="hidden" value="" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">@lang("$trans.name")</label>
                                <input type="text" class="form-control " id="name" placeholder="@lang("$trans.name")" name="name">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">@lang("$trans.phone")</label>
                                <input type="text" class="form-control " id="phone" placeholder="@lang("$trans.phone")" name="phone" >
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="discount">@lang("$trans.discount")</label>
                                <input type="number" class="form-control " id="discount" placeholder="@lang("$trans.discount")" name="discount">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="myCode">@lang("$trans.my_code")</label>
                                <input type="text" class="form-control " id="myCode" placeholder="@lang("$trans.my_code")" name="my_code">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="creditor">@lang("balances.creditor")</label><!-- المطلوب منى -->
                                <input type="number" class="form-control " id="creditor" placeholder="@lang("balances.creditor")" name="creditor">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="debtor">@lang("balances.debtor")</label><!-- المطلوب منة -->
                                <input type="text" class="form-control " id="debtor" placeholder="@lang("balances.debtor")" name="debtor">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="address">@lang("$trans.address")</label>
                                <input type="text" class="form-control" id="address" placeholder="@lang("$trans.address")" name="address">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>

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
            $(this).spanner();

            $("#supplierForm").find("button[type=submit]")
                .html("<i class='fa fa-plus'></i> @lang("home.create")")
                .attr("data-update","false");

            $("#creditor,#debtor").removeAttr("disabled").removeClass("disabled")
        });




        $("body").on("click",".btn-update",function (e) {
            e.preventDefault();

            $(this).spanner({text: false});
            $.each($(this).data(),function (k,v) {
                $(`#${k}`).val(v);
            });

            $("#creditor,#debtor").attr("disabled","disabled").addClass("disabled");

            $("#supplierForm").find("button[type=submit]")
                .html("<i class='fa fa-save'></i> @lang("home.save")")
                .attr("data-update","true")
                .closest("#supplierModal").modal("show")
        });

        /**
         *
         *
         */
        $("#supplierForm").submit(function (e) {
            e.preventDefault();
            ($(this).find("button[type=submit]").data("update")) ?  update( this ): create( this);
        });


        /**
         * create new record
         *
         * @param el
         */

        function create(el) {
            ajaxApi({
                url: "{{ route("suppliers.store") }}",
                type: "POST",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        $("#supplierModal").modal("hide");
                        if ($("#clientsTable").length > 0) {
                            $("#suppliersTable").DataTable().draw();
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
        function update(el) {
            ajaxApi({
                url: `/suppliers/${ $("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");

                        $(el).closest("#supplierModal").modal("hide");

                        $("#clientsTable").DataTable().draw();
                        ($(".modal-form").find("button[type=submit]").data("update"))
                            ? $(`#item-${$("#id").val()}`).removeSpanner()
                            : $(".btn-add").removeSpanner();
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
