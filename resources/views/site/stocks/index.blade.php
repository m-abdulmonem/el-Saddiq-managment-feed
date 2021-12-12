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
                    <table id="stocksTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang("$trans.code")</th>
                                <th>@lang("$trans.name")</th>
                                <th>@lang("$trans.address")</th>
                                <th>@lang("$trans.related")</th>
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

    @include("site.stocks.modals.index")

    @push("js")
        {!! datatable_files() !!}

        <script>
            let table = $("#stocksTable").table({
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'related', name: 'related',orderable: false, searchable: false},
                ],
                actionColumnWidth: "250px",
                url: "{{ route("ajax.stocks.index") }}"
            });

        </script>
    @endpush

@endsection
