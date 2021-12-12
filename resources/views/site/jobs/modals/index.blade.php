
<!-- Modal -->
<div class="modal fade" id="job" tabindex="-1" role="dialog" aria-labelledby="jobLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" class="jobForm">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group ">
                        <label for="name">@lang("$trans.name")</label>
                        <input class="form-control" name="name" placeholder="@lang("$trans.name")" id="name">
                    </div>
                </div>
                <div class="modal-footer float-left">
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">@lang("home.close")</button>
                    <button type="submit" class="btn btn-primary btn-action " data-update="false">@lang("home.create")</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push("js")
    <script>
        $(function () {

            let body = $("body");

            $(".btn-add").click(function () {
                $("#job").trigger("reset");
                $(this).spanner()
            });
            //
            $(".btn-close,.close").click(function () {
                $(".btn-add").removeSpanner()
            });


            body.on("click",".btn-update",function (e) {
                e.preventDefault();

                $.each($(this).data(),function (k,v) {
                    $(`#${k}`).val(v);
                });

                $(".jobForm").find("button[type=submit]")
                    .html("<i class='fa fa-save'></i> @lang("home.save")")
                    .attr("data-update","true")
                    .closest("#job").modal("show");
            });


            $(".jobForm").submit(function (e) {
                e.preventDefault();

                ($(this).find("button[type=submit]").data("update"))
                    ? update( this )
                    : create( this );
            });
        });

        function create(el) {
            ajaxApi({
                url: "{{ route("jobs.store") }}",
                type: "POST",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(el).trigger("reset");
                        $("#job").modal("hide");
                        $("#jobsTables").DataTable().draw();
                        swal(data.text, {
                            'icon': "success",
                            'timer': 2000
                        });
                    }
                }
            })
        }


        /**
         * update specific record
         *
         * @param el
         */
        function update(el) {
            ajaxApi({
                url: `/jobs/${ $(el).find("#id").val() }`,
                type: "PUT",
                data: $(el).serialize(),
                success: function (data) {
                    if (data.code === 1) {

                        $(el).closest("#job").modal("hide");

                        $("#jobsTables").DataTable().draw();

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
