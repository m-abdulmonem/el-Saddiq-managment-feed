@push("css")
    <link rel="stylesheet" href="{{ admin_assets("package/bootstrapDatepicker/bootstrap-datepicker.css") }}">
@endpush
<div class="modal fade" id="orderArriveDate" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel titleChicksOrdersArrived">@lang("$trans.order_arrive_date")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group" id="datepicker-container">
                                <label for="arrived_at">@lang("chicks/orders.arrived_at")</label>
                                <input type="text" step="any" class="form-control @error('arrived_at') is-invalid @enderror" id="arrived_at" autocomplete="off"
                                       placeholder="@lang("chicks/orders.arrived_at")" name="arrived_at" value="{{ old("arrived_at") }}">
                                <div class="alert alert-danger hide"></div>
                            </div>
                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-save-arrive-date" data-update="false"><i class="fa fa-save"></i> @lang("home.save")</button>
                    <button type="button" class="btn btn-link btn-close note-color" data-dismiss="modal"><i class="fa fa-times"></i> @lang("home.close")</button>
                </div>
            </form >
            <!-- ./form -->
        </div>
    </div>
</div>


@push("js")
    <script src="{{ admin_assets("package/bootstrapDatepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ admin_assets("package/bootstrapDatepicker/locales/bootstrap-datepicker.ar.min.js") }}"></script>
    <script>
        let id,arriveDateModal =  $("#orderArriveDate");

        $('#datepicker-container input').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            clearBtn: true,
            language: "ar",
            todayHighlight: true
        });

        $("body").on("click",".btn-arrive-at",function (e) {
            id = $(this).data("id");

            arriveDateModal.modal("show");

        });
        $(".btn-save-arrive-date").click(function (e) {
            e.preventDefault();
            ajaxApi({
                url: `/ajax/chick/orders/arrive/${id}/date`,
                data: {arrived_at: $("#arrived_at").val()},
                type: "PUT",
                success: function (data) {
                    if (data.code === 1)
                        swal(data.text,{
                            'icon': 'success',
                            'timer' : 3000
                        });

                    arriveDateModal.modal("hide")
                }
            });
        })

    </script>
@endpush
