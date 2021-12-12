@extends("site.layouts.index")
@section("content")
    @push("css"){!! datatable_files("css") !!}@endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @can("create supplier_bill")
                        <a href="{{ route("bills.create") }}" class="btn btn-primary "><i class="fa fa-plus"></i> @lang("home.new")</a>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="supplierBillsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.code")</th>
                            <th>@lang("suppliers/suppliers.name")</th>
                            <th>@lang("$trans.bill_number")</th>
                            <th>@lang("$trans.type")</th>
                            <th>@lang("$trans.quantity")</th>
                            <th>@lang("$trans.discount")</th>
                            <th>@lang("clients/bills.total_price")</th>
                            <th>@lang("balances.balance")</th>
{{--                            <th>@lang("balances.creditor")</th>--}}
{{--                            <th>@lang("balances.debtor")</th>--}}
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

    @push("js")
        {!! datatable_files() !!}
        <script>
            $("#supplierBillsTable").table({
                columns: [
                    {data: 'code', name: 'code' },
                    {data: 'name', name: 'name'},
                    {data: 'number', name: 'number'},
                    {data: 'type', name: 'type'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'discount', name: 'discount'},
                    {data: 'price', name: 'price'},
                    {data: 'balances', name: 'balances'},
                    // {data: 'creditor', name: 'creditor'},
                    // {data: 'debtor', name: 'debtor'}
                ],
                url :"{{ route("ajax.suppliers.bills.index") }}"
            })
        </script>
    @endpush
@endsection
