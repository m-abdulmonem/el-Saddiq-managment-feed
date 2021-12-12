<div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="jobLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="moveForm">
                <input type="hidden" id="id">
                <input type="hidden" id="pivot">
                <input type="hidden" id="name" name="name">
                <div class="modal-body">
                    @csrf
                    <div class="form-group ">
                        <label for="stock_id">@lang("stocks.stock")</label>
                        <select class="form-control" name="stock_id" id="stock_id" data-role="tagsinput">
                            {{ select_options_db(\App\Models\Stock::pluck("name","id")) }}
                        </select>
                        <div class="alert alert-danger hide"></div>
                    </div>
                    <div class="form-group ">
                        <label for="quantity">@lang("products/products.quantity")</label>
                        <input class="form-control" name="quantity"
                               placeholder="@lang("products/products.quantity")" id="quantity" data-role="tagsinput">
                        <div class="alert alert-danger hide"></div>
                    </div>
                </div>
                <div class="modal-footer float-left">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal"><i class="fa fa-times"></i> @lang("home.close")</button>
                    <button type="submit" class="btn btn-primary btn-move" data-update=""><i class="fas fa-check"></i>@lang("home.confirm")</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push("js")
    <script>


        $(function () {

            $("body").on("click",".btn-move-product",function () {
                btnCreate(this);


                $.each($(this).data(),function (k,v) {
                    $(`#${k}`).val(v);
                });

                $("#moveModal").modal("show");
                $(this).spanner()
            });

            $(".btn-close,.close").click(function () {
                $(".btn-move-product").removeSpanner()
            });


            $("#moveForm").submit(function (e) {
                e.preventDefault();
                move( this);
            });

            function btnCreate(el) {
                $(".modal-title").text(`@lang("stocks.move") [${$(el).data("name")}] @lang("stocks.to")`);

                return $("#stockForm").trigger("reset").find("button[type=submit]")
                    .html("<i class='fa fa-plus'></i> @lang("home.create")")
                    .attr("data-update","false");
            }


            /**
             * create new record
             *
             * @param el
             */

            function move(el) {
                ajaxApi({
                    url: `/ajax/stocks/product/${$("#id").val()}/move`,
                    type: "PUT",
                    data: $(el).serialize(),
                    success: function (data) {
                        if (data.code === 1) {
                            $(el).trigger("reset");
                            $("#moveModal").modal("hide");
                            $("#productsTable").DataTable().draw();
                            $(".btn-move-product").removeSpanner();
                            swal(data.text, {
                                'icon': "success",
                                'timer': 2000
                            });
                        }
                    },
                });
                {{--swal({--}}
                {{--    title: '@lang("stocks.alert_move_confirm")',--}}
                {{--    text: '@lang('stocks.alert_move_text')',--}}
                {{--    icon: 'info',--}}
                {{--    showCancelButton: true,--}}
                {{--    confirmButtonColor: '#117a8b',--}}
                {{--    cancelButtonColor: '#e8e8e8',--}}
                {{--    dangerMode: true--}}
                {{--}).then((result) => {--}}
                {{--    if (result.isConfirmed) {--}}
                {{--      --}}
                {{--    }--}}
                {{--})--}}
            }

        })
    </script>
@endpush
