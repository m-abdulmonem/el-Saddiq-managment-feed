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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#categoriesModal" id="create-category"><i class="fa fa-plus"></i> {{ trans("home.new") }}</button>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="categoriesTable" class="table table-bordered table-striped" data-url="{{ route('categories.index') }}">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang("$trans.name")</th>
                                <th>@lang("$trans.details")</th>
{{--                                <th>@lang("$trans.related")</th>--}}
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

    @include("modals.categories.index")

    @push("js")
        {!! datatable_files() !!}
        <script>
            $("#categoriesTable").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'details', name: 'details'},
                    // {data: 'related', name: 'related', orderable: false, searchable: false},
                ],
                url: "{{ route("ajax.categories.index") }}",
            })
        </script>
    @endpush
@endsection
