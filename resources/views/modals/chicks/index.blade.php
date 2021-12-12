<div class="modal fade" id="client" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <label for="name">@lang("$trans.name")</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="@lang("$trans.name")" name="name" value="{{ old("name") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="supplier_id">@lang("$trans.select_type")</label>
                                <select class="form-control  @error('supplier_id') is-invalid @enderror" name="supplier_id" id="supplier_id">
                                    {{ select_options_db(\App\Models\Supplier\Supplier::pluck("name","id"),"supplier_id") }}
                                </select>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="type">@lang("$trans.select_type")</label>
                                <select class="form-control  @error('type') is-invalid @enderror" name="type" id="type">
                                    {{ select_options(['ducks','chick','chicken'],"type",null,"$trans") }}
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
        let body = $("body");
        //
        $(".btn-add").click(function () {
            btnCreate();
            $("#create").trigger("reset");
            $(this).spanner();
        });
        //
        $(".btn-close,.close").click(function () {
            $(".btn-add").removeSpanner()
        });

        body.on("click","#create-chick",function () {
            $("#create").find("button[type=submit]")
                .html("<i class='fa fa-plus'></i> @lang("home.create")")
                .attr("data-update",false).closest("form").find("#id").val("0");
        });

        //
        body.on("click",".btn-update",function (e) {
            e.preventDefault();

            $.each($(this).data(),function (k,v) {
                $(`#${k}`).val(v);
            });

                btnUpdate().attr("data-update","true").parent().parent().find("#supplier_id")
                .val( $(this).data("supplier") ).change()
                .closest("#client").modal("show");
        });

        function btnCreate(){
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

            ($(this).find("button[type=submit]").data("update")) ? update( this ): create( this);
        });

        /**
         * create new record
         *
         * @param el
         */

        function create(el) {

            ajaxApi({
                url: "{{ route("chicks.store") }}",
                type: "POST",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        $(".btn-add").removeSpanner();
                        $("#client").modal("hide");
                        $("#ma-admin-datatable").DataTable().draw();
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
                url: `/chicks/${ $(el).find("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {

                        $(el).closest("#client").modal("hide");

                        $("#ma-admin-datatable").DataTable().draw();

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
