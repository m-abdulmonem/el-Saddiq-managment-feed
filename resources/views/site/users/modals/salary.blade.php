@push("css")
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
@endpush

<div class="modal fade" id="salaryModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("$trans.create")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="salaryForm">
                @csrf
                <input type="hidden" value="" id="id" name="user_id">
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="salaryInput">@lang("$trans.salary")</label>
                            <input type="number" step="any" class="form-control" id="salaryInput" placeholder="@lang("$trans.salary")" name="salary">
                            <div class="alert alert-danger hide"></div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="increase">@lang("$trans.increase")</label>
                            <input type="number" step="any" class="form-control" id="increase" placeholder="@lang("$trans.increase")" name="increase">
                            <div class="alert alert-danger hide"></div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="discount">@lang("$trans.discount")</label>
                            <input type="number" step="any" class="form-control" id="discount" placeholder="@lang("$trans.discount")" name="discount">
                            <div class="alert alert-danger hide"></div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="notes">@lang("$trans.notes")</label>
                            <textarea class="form-control" id="notes" placeholder="@lang("$trans.notes")" name="notes"></textarea>
                            <div class="alert alert-danger hide"></div>
                        </div>
                    </div>
                    <!-- ./col -->
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

        $("body").on("click",".btn-paid-salary",function () {
            $("#id").val($(this).data("id"));
            $(".modal-title").text("@lang("$trans.save_salary")");

            $("#salaryForm").find("#salaryInput").val($(this).data("salary")).parent().parent()
                .find("button[type=submit]").html("<i class='fa fa-save'></i> @lang("home.save")");


            ($(this).data("disabled") === 1)
                ? $("#salaryInput").addClass("disabled").attr("disabled","disabled")
                : $("#salaryInput").removeClass("disabled").removeAttr("disabled");

            
            $("#salaryModal").modal("show");

            $(this).spanner()
        });
        
        $("#increase").change(function () {
            $("#salaryInput").val((parseFloat($(this).val()) + parseFloat($("#salaryInput").val())))
        });

        $("#discount").change(function () {
            $("#salaryInput").val((parseFloat($("#salaryInput").val()) - parseFloat($(this).val())))
        });

        $(".btn-close,.close").click(function () {
            $(".btn-paid-salary").removeSpanner()
        });



        $("#salaryForm").submit(function (e) {
            e.preventDefault();
            const $this = this;
            ajaxApi({
                url: "{{ route("salaries.store") }}",
                type: "POST",
                data: $($this).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $($this).trigger("reset");
                        $("#salaryModal").modal("hide");
                        console.log($("#userTable").DataTable().draw());
                        $(".btn-paid-salary").removeSpanner();
                        swal(data.text, {
                            'icon': "success",
                            'timer': 2000
                        });
                    }
                },
            });

        });
    </script>
@endpush
