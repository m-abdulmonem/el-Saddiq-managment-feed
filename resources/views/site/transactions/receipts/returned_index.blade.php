@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @can("create $perm")
                        <button class="btn btn-primary btn-add"  title="@lang("home.new")"><a><i class="fa fa-plus"></i> @lang("home.new")</a></button>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button" title="#@lang("home.refresh")"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="paymentsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.code")</th>
                            <th>@lang("suppliers/bills.return_shipping_number")</th>
                            <th>@lang("suppliers/bills.total_price")</th>
                            <th>@lang("balances.paid")</th>
                            <th>@lang("balances.remaining")</th>
                            <th>@lang("balances.paid_percentage")</th>
                            <th>@lang("home.date")</th>
                            <th>@lang("home.actions")</th>
                        </tr>
                        </thead>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @include("site.transactions.receipts.modals.returned")

    @push("js")
        {!! datatable_files() !!}

        <script>
            let table = $("#paymentsTable").table({
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'number', name: 'number'},
                    {data: 'price', name: 'price'},
                    {data: 'paid', name: 'paid'},
                    {data: 'remaining', name: 'remaining'},
                    {data: 'percentage', name: 'percentage'},
                    {data: 'date', name: 'date'},
                ],
                actionColumnWidth: "auto",
                url: "{{ route("ajax.transactions.receipts.returned") }}"
            });

        </script>
    @endpush

@endsection
