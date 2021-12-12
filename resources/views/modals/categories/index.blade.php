<div class="modal fade" id="categoriesModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("$trans.create")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="categoryForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group-group mb-3">
                                <label for="name">@lang("$trans.name")</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                       placeholder="@lang("$trans.name")" name="name" >

                                <div class="alert alert-danger hide"></div>

                            </div>
                        </div>
                        <!-- ./col-12 -->
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="details">@lang("$trans.details")</label>
                                <textarea class="form-control @error('details') is-invalid @enderror" id="details"
                                          placeholder="@lang("$trans.details")" name="details" style="min-height: 125px"></textarea>
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                        <!-- ./col-12 -->
                    </div>
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
        let body = $("body"),
            form = $("#categoryForm"),
            table = $("#categoriesTable"),
            modal = $("#categoriesModal");
        //
        $(".btn-add").click(function () {
            form.trigger("reset");
            $(this).spanner()
        });
        //
        $(".btn-close,.close").click(function () {
            $(".btn-add").removeSpanner()
        });

        $("#create-category").click(function () {

            form.trigger("reset").find("button[type=submit]")
                .html("<i class='fa fa-plus'></i> @lang("home.create")")
                .attr("data-update","false").parent().parent()
                .closest("#categoriesModal").modal("show");
        });

        //
        body.on("click",".btn-update",function (e) {
            e.preventDefault();

            $.each($(this).data(),function (k,v) {
                $(`#${k}`).val(v);
            });
            form.find("button[type=submit]")
                .html("<i class='fa fa-save'></i> @lang("home.save")")
                .attr("data-update","true").parent().parent()
                .closest("#categoriesModal").modal("show");
        });

        //
        form.submit(function (e) {
            e.preventDefault();

            if ($(this).find("button[type=submit]").data("update"))
                update( this );
            else
                create( this);
        });

        /**
         * create new record
         *
         * @param el
         * @param callback
         */

        function create(el,callback) {

            ajaxApi({
                url: "{{ route("categories.store") }}",
                type: "POST",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        modal.modal("hide");

                        table.DataTable().draw();

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
                url: `/categories/${ $(el).find("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {

                        $(el).closest("#categoriesModal").modal("hide");

                        table.DataTable().draw();

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
