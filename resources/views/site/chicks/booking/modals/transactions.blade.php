<div class="modal fade" id="chickBookingTransaction" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title transaction-modal" id="staticBackdropLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- ./modal-header -->

            <div class="modal-body">
                <table id="table-chickBookingTransaction" class="table table-bordered table-striped" >
                    <thead>
                    <tr>
                        <th>@lang("balances.transaction")</th>
                        <th>@lang("balances.paid")</th>
                        <th>@lang("balances.remaining")</th>
                        <th>@lang("balances.date")</th>
                        <th>@lang("balances.user")</th>
                        <th>@lang("balances.note")</th>
                    </tr>
                    </thead>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">@lang("home.close")</button>
            </div>

        </div>
    </div>
</div>
@push("js")

    <script>
        let transactionTable =  $("#table-chickBookingTransaction");

        $("body").on("click",".btn-transaction",function (e) {
            e.preventDefault();

            $(".transaction-modal").text( $(this).data("name") );

            transactionTable.DataTable().destroy();

            tableTransaction($(this).data("booking") );

            $("#chickBookingTransaction").modal("show");
        });
        

        function tableTransaction(id) {
           return transactionTable.table({
                columns: [
                    {data: 'transaction', name: 'transaction'},
                    {data: 'paid', name: 'paid'},
                    {data: 'rest', name: 'rest'},
                    {data: 'date', name: 'date'},
                    {data: 'user', name: 'user'},
                    {data: 'notes', name: 'notes'},
                ],
                notColumns: [
                    "#",
                    'actions'
                ],
                url: `/ajax/chick/booking/transaction/${id}`,
            })
        }

    </script>
@endpush
