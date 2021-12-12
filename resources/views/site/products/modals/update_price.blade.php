
<div class="modal fade" id="updatePriceModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("$trans.update_price")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="updatePriceForm">
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="price">@lang("$trans.total_price")</label>
                            <input type="text" class="form-control" id="price" placeholder="@lang("$trans.total_price")" name="price">
                            <div class="alert alert-danger hide"></div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="sale_price">@lang("$trans.price")</label>
                            <input type="text" class="form-control" id="sale_price" placeholder="@lang("$trans.price")" name="sale_price">
                            <div class="alert alert-danger hide"></div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">@lang("home.close")</button>
                    <button type="submit" class="btn btn-info btn-price">@lang("home.save")</button>
                </div>
            </form >
            <!-- ./form -->
        </div>
    </div>
</div>


@push("js")
    <script>
        $(function () {
            let id;
            $("body").on('click','.btn-price-update',(function () {
                id = $(this).data("id");
                $.each($(this).data(),function (k,v) {
                    $(`#${k}`).val(v);
                });
                $("#updatePriceModal").modal("show");
            }));

            $(".btn-price").click(function (e) {
                e.preventDefault();

                ajaxApi({
                    url: `/ajax/products/price/change/${id}`,
                    type: "PUT",
                    data: $("#updatePriceForm").serialize(),
                    success: function (data) {
                        if (data.code === 1) {
                            $("#updatePriceForm").trigger("reset");
                            $("#updatePriceModal").modal("hide");

                            if($("#productsTable").length >= 1) $("#productsTable").DataTable().draw();

                            swal(data.text, {
                                'icon': "success",
                                'timer': 2000
                            });
                        }
                    },
                });
            })

        })
    </script>
@endpush
