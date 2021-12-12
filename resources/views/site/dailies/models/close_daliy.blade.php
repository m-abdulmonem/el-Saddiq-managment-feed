<div class="modal fade" id="closeDailyModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("$trans.close_daily")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <!-- ./modal-header -->
            <form method="post" id="closeDailyForm">
                @csrf
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="balance">@lang("$trans.box_balance")</label>
                            <input type="text" class="form-control" id="balance"
                                   placeholder="@lang("$trans.box_balance")" name="balance" >
                            <div class="alert alert-danger hide"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">@lang("home.close")</button>
                    <button type="submit" class="btn btn-info">@lang("$trans.save_print")</button>
                </div>
            </form >
            <!-- ./form -->
        </div>
    </div>
</div>


@push("js")
    <script>

        $(".btn-close,.close").click(function () {
            // $(".btn-close-daily").removeSpanner()
        });

        $('body').on('submit','#closeDailyForm', function(e){
            e.preventDefault();
            ajaxApi({
                url: "{{ route("ajax.dailies.close") }}",
                type: "PUT",
                data: $(this).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        window.location.href = data.data[1]
                    }
                },
            })

        });
    </script>
@endpush
