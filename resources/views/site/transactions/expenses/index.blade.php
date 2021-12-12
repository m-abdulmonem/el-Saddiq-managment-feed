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
                    <table id="expensesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang("$trans.code")</th>
                                <th>@lang("$trans.name")</th>
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

    @include("site.transactions.expenses.modals.index")

    @push("js")
        {!! datatable_files() !!}

        <script>
            let table = $("#expensesTable").table({
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                ],
                actionColumnWidth: "250px",
                url: "{{ route("ajax.transactions.expenses.index") }}"
            });

        </script>
    @endpush

@endsection
