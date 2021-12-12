@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @can("create job")
                        <button class="btn btn-primary btn-create"
                                title="@lang("$trans.create")" data-toggle="modal" data-target="#job">
                            <i class="fa fa-plus"></i> @lang("home.new")
                        </button>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="jobsTables" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang("$trans.name")</th>
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

    @include("site.jobs.modals.index")

    @push("js")
        {!! datatable_files() !!}

        <script>
            $("#jobsTables").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'related', name: 'related', orderable: false, searchable: false},
                ],
                url: "{{ route("ajax.jobs.index") }}"
            });
        </script>

    @endpush
@endsection
