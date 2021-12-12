@extends("site.layouts.index")
@section("content")
    @push("css"){!! datatable_files("css") !!}@endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @can("create client_bill")
                        <a href="{{ route("invoices.create") }}" class="btn btn-primary "><i class="fa fa-plus"></i> @lang("home.new")</a>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="invoicesTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>@lang("$trans.code")</th>
                            <th>@lang("clients/clients.client")</th>
                            <th>@lang("$trans.type")</th>
                            <th>@lang("$trans.discount")</th>
                            <th>@lang("$trans.total_price")</th>
                            <th>@lang("$trans.status")</th>
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

    @push("js")
        {!! datatable_files() !!}
        <script>
            $("#invoicesTable").table({
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
                    {data: 'discount', name: 'discount'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    {data: 'date', name: 'date'}
                ],
                url: "{{ route("ajax.clients.invoices.index") }}",
                notColumns: ['#'],
                actionColumnWidth: "250px"
            })
        </script>
    @endpush
@endsection
