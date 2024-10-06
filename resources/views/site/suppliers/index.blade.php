@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @can("create supplier")
                        <span class="btn btn-info btn-add" data-toggle="modal" data-target="#supplierModal"><i class="fa fa-plus"></i> @lang("home.new")</span>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="suppliersTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.name")</th>
                            <th>@lang("$trans.phone")</th>
                            <th>@lang("$trans.address")</th>
                            <th>@lang("$trans.balances")</th>
                            <th>@lang("$trans.creditor")</th>
                            <th>@lang("$trans.debtor")</th>
                            <th>@lang("$trans.latest_bill")</th>
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
    @include("site.suppliers.modals.index")

    @push("js")
        {!! datatable_files() !!}
        <script src="{{ admin_assets("datatables/dataTables.buttons.min.js") }}"></script>
        <script src="{{ admin_assets("datatables/buttons.print.min.js") }}"></script>
        <script>

            $("#suppliersTable").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {data: 'balances', name: 'balances'},
                    {data: 'creditor', name: 'creditor'},
                    {data: 'debtor', name: 'debtor'},
                    {data: 'latest_bill', name: 'latest_bill'}
                ],
                url: "{{ route("ajax.suppliers.index") }}"
            })
        </script>
    @endpush
@endsection
