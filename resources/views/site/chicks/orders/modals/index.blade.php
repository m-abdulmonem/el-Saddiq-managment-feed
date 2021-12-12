<div class="modal fade" id="OrdersModel" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="name">@lang("chicks/orders.name")</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                       placeholder="@lang("chicks/orders.name")" name="name" value="{{ old("name") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="price">@lang("chicks/orders.price")</label>
                                <input type="number" step="any" class="form-control @error('price') is-invalid @enderror" id="price"
                                       placeholder="@lang("chicks/orders.price")" name="price" value="{{ old("price") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="chick_id">@lang("chicks/chicks.select_type")</label>
                                <select class="form-control  @error('type') is-invalid @enderror" name="chick_id" id="chick_id">
                                    {{ select_options_db(\App\Models\Chick\Chick::pluck("name","id"),"chick_id",null) }}
                                </select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4">
                            <div class="form-group ">
                                <label for="is_came">@lang("chicks/orders.select_status")</label>
                                <select class="form-control  @error('is_came') is-invalid @enderror" name="is_came" id="is_came">
                                    {{ select_options(['0','1'],"is_came",null,"chicks/orders") }}
                                </select>
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

        //
        $(".btn-add").click(function () {
            btnCreate();
            $("#create").trigger("reset");
            $(this).spanner()
        });
        //
        $(".btn-close,.close").click(function () {
            $(".btn-add").removeSpanner()
        });

        //
        $("body").on("click",".btn-update",function (e) {
            e.preventDefault();

            $.each($(this).data(),function (k,v) {
                $(`#${k}`).val(v);
            });

            btnUpdate().attr("data-update","true").parent().parent().closest("#OrdersModel").modal("show");
        });

        function  btnCreate() {
            $(".modal-title").text("@lang("home.create")");
            return $("#create").trigger("reset").find("button[type=submit]").data("update",false)
                .html("<i class='fa fa-plus'></i> @lang("home.create")")

        }

        function btnUpdate(){
            $(".modal-title").text("@lang("home.update")");
            return $("#create").find("button[type=submit]").data("update",true)
                .html("<i class='fa fa-save'></i> @lang("home.save")")
        }

        //
        $("#create").submit(function (e) {
            e.preventDefault();
            ($(this).find("button[type=submit]").data("update")) ? update( this ) : create( this);
        });

        /**
         * create new record
         *
         * @param el
         * @param callback
         */

        function create(el) {
            ajaxApi({
                url: "{{ route("chicks.orders.store") }}",
                type: "POST",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        $("#OrdersModel").modal("hide");
                        $("#ordersTable").DataTable().draw();
                        $(".btn-add").removeSpanner()
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
                url: `/chicks/orders/${ $(el).find("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {

                        $(el).closest("#OrdersModel").modal("hide");

                        $("#ordersTable").DataTable().draw();

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
