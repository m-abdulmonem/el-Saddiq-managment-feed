@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="productsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.number")</th>
                            <th>@lang("users/users.user")</th>
                            <th>@lang("home.date")</th>
                            <th>@lang("$trans.time_in")</th>
                            <th>@lang("$trans.time_out")</th>
                            <th>@lang("$trans.inc_dec")</th>
                            <th>@lang("$trans.net_sales")</th>
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

    @include("site.products.modals.index")
    @include("site.products.modals.update_price")
    @push("js")
        {!! datatable_files() !!}
        <script >
            $("#productsTable").table({
                columns: [
                    {data: 'number', name: 'number'},
                    {data: 'user', name: 'user'},
                    {data: 'date', name: 'date'},
                    {data: 'time_in', name: 'time_in'},
                    {data: 'time_out', name: 'time_out'},
                    {data: 'inc_dec', name: 'inc_dec'},
                    {data: 'net', name: 'net'},
                ],
                url: "{{ route("ajax.dailies.index") }}",
                actionColumnWidth: "250px",
            });
        </script>
    @endpush
@endsection
