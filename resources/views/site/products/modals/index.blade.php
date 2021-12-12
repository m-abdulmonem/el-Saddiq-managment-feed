@push("css")
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
@endpush

<div class="modal fade" id="productsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog {{ request()->segment(1) == "medicines" ? "modal-xl" : "modal-lg"}}">
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
                                <label for="supplier_id" class="d-block">@lang("$trans.select_supplier")</label>
                                <select name="supplier_id" id="supplier_id" class="form-control"></select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="unit_id">@lang("$trans.select_unit")</label>
                                <select name="unit_id" id="unit_id" class="form-control"></select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="category_id" class="d-block">@lang("$trans.select_category")</label>
                                <select name="category_id" id="category_id" class="form-control d-block"> </select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="stock_id" class="d-block">@lang("$trans.select_stock")</label>
                                <select name="stock_id" id="stock_id" class="form-control d-block"> </select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="quantity" class="d-block">@lang("$trans.quantity")</label>
                                <input type="number" class="form-control" id="quantity" placeholder="@lang("$trans.quantity")" name="quantity">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="purchase_price" class="d-block">@lang("$trans.purchase_price")</label>
                                <input type="number" class="form-control" id="purchase_price" placeholder="@lang("$trans.purchase_price")" name="purchase_price">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="sale_price" class="d-block">@lang("$trans.sale_price")</label>
                                <input type="number" class="form-control" id="sale_price" placeholder="@lang("$trans.sale_price")" name="sale_price">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group ">
                                <label for="weight" class="d-block">@lang("$trans.product_weight")</label>
                                <input type="number" class="form-control" id="weight" placeholder="@lang("$trans.product_weight")" name="weight">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group ">
                                <label for="profit" class="d-block">@lang("$trans.profit")</label>
                                <input type="number" class="form-control" id="profit" placeholder="@lang("$trans.profit")" name="profit">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group ">
                                <label for="discount" class="d-block">@lang("$trans.discount")</label>
                                <input type="number" class="form-control" id="discount" placeholder="@lang("$trans.discount")" name="discount">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <div class="col-3">

                            <div class="form-group text-center">
                                <label for="example_12">@lang("$trans.printed")</label>
                                <div class="custom-switch pl-0">
                                    <input type="checkbox" class="custom-switch-input" id="example_12" checked name="is_printed" value="1">
                                    <label class="custom-switch-btn text-hide" for="example_12">{value}</label>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="notes">@lang("$trans.notes")</label>
                                <textarea class="form-control " id="notes" placeholder="@lang("$trans.notes")" name="notes" style="min-height: 125px"></textarea>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col-12 -->
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
        $("#unit_id").select2({
            width: '100%',
            placeholder: "@lang("$trans.select_unit")",
            ajax: {
                url: '{{ route("ajax.products.units") }}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data[0]
                    }
                }
            }
        });
        $("#supplier_id").select2({
            width: '100%',
            placeholder: "@lang("$trans.select_supplier")",
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
        $("#stock_id").select2({
            width: '100%',
            placeholder: "@lang("$trans.select_stock")",
            ajax: {
                url: '{{ route("ajax.stocks.names") }}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data[0]
                    }
                }
            }
        });

        $("#category_id").select2({
            width: '100%',
            placeholder: "@lang("$trans.select_category")",
            ajax: {
                url: '{{ route("ajax.products.categories") }}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data[0]
                    }
                }
            }
        });

        /**
         *
         */
        $(".btn-add").click(function () {
            btnCreate().parent().parent()
                .find("#unit_id")
                .removeAttr("disabled")
                .parent().show();


            $("#discount,#profit,#category_id,#weight").parent().parent().removeClass("col-6").addClass("col-3");

            $("#stock_id,#quantity,#purchase_price,#sale_price")
                .parent().parent().removeClass("disabled").removeAttr("disabled").show();

            $(".custom-switch").parent().hide();

            $("#productsModal").modal("show");
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

            $("#discount,#profit,#category_id,#weight").parent().parent().removeClass("col-3").addClass("col-6");

            $("#stock_id,#quantity,#purchase_price,#sale_price,#unit_id")
                .parent().parent().addClass("disabled").attr("disabled",'disabled').hide();

            $(".custom-switch").parent().hide();

            $("#supplier_id").select2("trigger", "select", {
                data: { id: $(this).data("supplier_id"),text: $(this).data("supplier_name") }
            });
            $("#category_id").select2("trigger", "select", {
                data: { id: $(this).data("category_id"),text: $(this).data("category_name") }
            });
            btnUpdate().parent().parent().find("#unit_id").attr("disabled",true).closest(".form-group").hide().closest("#productsModal").modal("show");

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

            $("#unit_id,#supplier_id,#category_id").empty();//.trigger('change');

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
         * @param callback
         */

        function create(el,callback) {
            ajaxApi({
                url: "{{ route("products.store") }}",
                type: "POST",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        $("#productsModal").modal("hide");
                        if($("#productsTable").length >= 1) $("#productsTable").DataTable().draw();
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
                url: `/products/${ $(el).find("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");

                        $(el).closest("#productsModal").modal("hide");

                        if($("#productsTable").length >= 1) $("#productsTable").DataTable().draw();
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
