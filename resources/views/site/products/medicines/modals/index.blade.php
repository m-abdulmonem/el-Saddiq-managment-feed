@push("css")
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
@endpush

<div class="modal fade" id="medicineModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <label for="name">@lang("$trans.name")</label>
                                <input type="text" class="form-control" id="name" placeholder="@lang("$trans.name")" name="name">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="stockIn" class="d-block">@lang("$trans.store_in")</label>
                                <input type="text" class="form-control" id="stockIn" placeholder="@lang("$trans.store_in")" name="stock_in">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="quantity">@lang("$trans.quantity")</label>
                                <input type="number" class="form-control" id="quantity" placeholder="@lang("$trans.quantity")" name="quantity">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="profit" class="d-block">@lang("$trans.profit")</label>
                                <input type="number" class="form-control" id="profit" placeholder="@lang("$trans.profit")" name="profit">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="purchasePrice">@lang("$trans.purchase_price")</label>
                                <input type="number" step="any" class="form-control" id="purchasePrice" placeholder="@lang("$trans.purchase_price")" name="purchase_price">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="salePrice" class="d-block">@lang("$trans.sale_price")</label>
                                <input type="number" step="any" class="form-control" id="salePrice" placeholder="@lang("$trans.sale_price")" name="sale_price">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="for" class="d-block">@lang("$trans.for")</label>
                                <textarea class="form-control" id="for" placeholder="@lang("$trans.for")" name="for"></textarea>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                    </div>
                    <!-- .row -->
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
        $("#purchasePrice").change(function () {
            $("#salePrice").val((parseFloat($(this).val()) / parseFloat($("#quantity").val())) + parseFloat($("#profit").val()))
        });
        /**
         *
         */
        $(".btn-add").click(function () {
            console.log($("#medicinesTable"))
            btnCreate();
            $("#medicineModal").modal("show");
            // $(this).spanner()
        });

        $(".btn-close,.close").click(function () {
           $(".btn-add").removeSpanner()
        });


        $("body").on("click",".btn-update",function (e) {
            e.preventDefault();

            $.each($(this).data(),function (k,v) {
                $(`#${k}`).val(v);
            });
            btnUpdate().closest("#medicineModal").modal("show");

        });

        /**
         *
         *
         */
        $("#create").submit(function (e) {
            e.preventDefault();

            ($(this).find("button[type=submit]").data("update")) ? update( this ) : create( this);
        });

        function btnCreate() {
            $(".modal-title").text("@lang("home.create")");

            return $("#create").trigger("reset").find("button[type=submit]")
                .html("<i class='fa fa-plus'></i> @lang("home.create")")
                .attr("data-update","false");
        }

        function btnUpdate() {
            $(".modal-title").text("@lang("home.update")");
            return $("#create").find("button[type=submit]")
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
                url: "{{ route("medicines.store") }}",
                type: "POST",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        $("#medicineModal").modal("hide");
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        if($("#medicinesTable").length >= 1) $("#medicinesTable").DataTable().draw();
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
                url: `/medicines/${ $(el).find("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");

                        $(el).closest("#medicineModal").modal("hide");
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        if($("#medicinesTable").length >= 1) $("#medicinesTable").DataTable().draw();
                        $(".btn-add").removeSpanner();
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
