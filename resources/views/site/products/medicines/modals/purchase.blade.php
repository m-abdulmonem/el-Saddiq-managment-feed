<div class="modal fade" id="medicinesModal"  data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="staticBackdropLabel">
                    @if(request()->segment(1) =="medicines")
                        @lang("products/medicines.purchase_title")
                    @else
                        @lang("products/medicines.sell_title")
                    @endif
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->
            <form method="post" id="medicinesForm">
                @csrf
                <input type="hidden" value="" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group ">
                                <medicine-search></medicine-search>
                            </div>
                        </div>
                        <!-- ./col -->
                        <table class="table table-striped table-hover table-bordered " id="medicinesTable">
                            <thead>
                                <tr class="">
                                    <th scope="col" style="width: 120px">كود</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col">الكمية</th>
                                    <th scope="col">سعر الشراء</th>
                                    <th scope="col">سعر الوحدة</th>
                                    <th scope="col">حذف</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- ./row -->

                </div>
                <div class="modal-footer">
                    @if(request()->segment(1) !="medicines")
                        <div class="ml-auto">@lang("clients/bills.total_price") : <span class="medicine-total-price info-color"></span></div>
                    @endif
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">@lang("home.close")</button>
                    <button type="submit" class="btn btn-info" id="btnSellMedicine"><i class="fa fa-save"></i> @lang("home.save")</button>
                </div>
            </form >
            <!-- ./form -->
        </div>
    </div>
</div>

@push("js")
    <script>
        $("body").on("click",".btn-purchase",function () {
            $("#medicinesModal").modal("show");
        });
        $('body').on('submit','#medicinesForm', function(e){
            e.preventDefault();
            ajaxApi({
                url: "{{ route("ajax.products.medicines.purchases") }}",
                type: "PUT",
                data: $(this).serialize(),
                success: function (data) {
                    if (data.code === 1) {
                        $(this).trigger("reset");
                        $("body").find("tbody tr").remove();
                        $("#medicinesModal").modal("hide");
                        $("#remaining,.total-net,.total-price,.medicine-total-price").text(formatter.format(0));
                        swal(data.text, {
                            'icon': "success",
                            'timer': 2000
                        });
                    }
                },
            })

        });
    </script>
@endpush
