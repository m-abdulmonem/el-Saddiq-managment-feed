<div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="jobLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="stockForm">
                <input type="hidden" id="id">
                <div class="modal-body">
                    @csrf
                    <div class="form-group ">
                        <label for="name">@lang("stocks.name")</label>
                        <input class="form-control" name="name"
                               placeholder="@lang("stocks.name")" id="name" data-role="tagsinput">
                        <div class="alert alert-danger hide"></div>
                    </div>
                    <div class="form-group ">
                        <label for="address">@lang("stocks.address")</label>
                        <input class="form-control" name="address"
                               placeholder="@lang("stocks.address")" id="address" data-role="tagsinput">
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
    <script>


        $(function () {

            $(".btn-add").click(function () {
                btnCreate();
                $("#stockModal").modal("show");
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
                btnUpdate().closest("#stockModal").modal("show");

            });

            /**
             *
             *
             */
            $("#stockForm").submit(function (e) {
                e.preventDefault();

                ($(this).find("button[type=submit]").data("update")) ? update( this ) : create( this);
            });

            function btnCreate() {
                $(".modal-title").text("@lang("home.create")");

                return $("#stockForm").trigger("reset").find("button[type=submit]")
                    .html("<i class='fa fa-plus'></i> @lang("home.create")")
                    .attr("data-update","false");
            }

            function btnUpdate() {
                $(".modal-title").text("@lang("home.update")");
                return $("#stockForm").find("button[type=submit]")
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
                    url: "{{ route("stocks.store") }}",
                    type: "POST",
                    data: $(el).serialize(),
                    success: function (data) {
                        if (data.code === 1) {
                            $(el).trigger("reset");
                            $("#stockModal").modal("hide");
                            if($("#stocksTable").length >= 1) $("#stocksTable").DataTable().draw();
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
                    url: `/stocks/${ $(el).find("#id").val() }`,
                    type: "PUT",
                    data: $(el).serialize(),
                    success: function (data) {
                        if (data.code === 1) {
                            $(el).trigger("reset");

                            $(el).closest("#stockModal").modal("hide");

                            if($("#stocksTable").length >= 1) $("#stocksTable").DataTable().draw();
                            $(".btn-add").removeSpanner();
                            swal(data.text, {
                                'icon': "success",
                                'timer' : 2000
                            });
                        }
                    },
                });
            }


        {{--    let id, form = $("#stock_form");--}}

        {{--    $(".btn-create").click(function () {--}}
        {{--        $("#stock").modal("show")--}}
        {{--    });--}}
        {{--    --}}
        {{--    $("body").on("click",".btn-update",function () {--}}
        {{--        id = $(this).data("id");--}}

        {{--        $.each($(this).data(),function (k,v) {--}}
        {{--            $(`#${k}`).val(v);--}}
        {{--        });--}}

        {{--        form.find("button[type=submit]")--}}
        {{--            .html("<i class='fa fa-save'></i> @lang("home.save")")--}}
        {{--            .attr("data-update","true").parent().parent()--}}
        {{--            .closest("#stock").modal("show");--}}
        {{--    });--}}
        {{--    --}}
        {{--    --}}
        {{--    form.on("submit",function (event) {--}}
        {{--        event.preventDefault();--}}
        {{--        if ($("button[type=submit]").data("update")){--}}
        {{--            ajaxApi({--}}
        {{--                url: `/stocks/${id}`,--}}
        {{--                type: "PUT",--}}
        {{--                data:  $(this).serialize(),--}}
        {{--                success: function (data) {--}}
        {{--                    $("#stock_form").trigger("reset");--}}
        {{--                    $("#stock").modal("hide");--}}

        {{--                    table.draw();--}}

        {{--                    swal(data.text, {--}}
        {{--                        icon: "success",--}}
        {{--                        timer: 1490--}}
        {{--                    });--}}
        {{--                }--}}
        {{--            });--}}
        {{--        }else{--}}
        {{--            ajaxApi({--}}
        {{--                url: "{{ route("stocks.store") }}",--}}
        {{--                data: $(this).serialize(),--}}
        {{--                type: "POST",--}}
        {{--                success: function (data) {--}}
        {{--                    form.trigger("reset");--}}
        {{--                    $("#stock").modal("hide");--}}

        {{--                    table.draw();--}}

        {{--                    swal(data.text,{--}}
        {{--                        icon: "success",--}}
        {{--                        timer: 1490--}}
        {{--                    });--}}
        {{--                }--}}

        {{--            })--}}
        {{--        }--}}
        {{--    });--}}

        })
    </script>
@endpush
