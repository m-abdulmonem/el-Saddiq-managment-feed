@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-inline">
                                <label for="select_type">@lang("$trans.select_type")</label>
                                <select name="" id="select_type" class="form-control">
                                    {!! select_options([null,"ducks","chick","chicken"],null,null,$trans) !!}
                                </select>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            @can("create client")
                                <button class="btn btn-primary btn-add" data-toggle="modal" data-target="#client" id="create-chick">
                                    <i class="fa fa-plus"></i> @lang("home.new")
                                </button>
                            @endcan
                            <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- ./row -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="ma-admin-datatable" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.name")</th>
                            <th>@lang("$trans.supplier")</th>
                            <th>@lang("$trans.type")</th>
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

    @include("modals.chicks.index")

    @push("js")
        {!! datatable_files() !!}
        <script>
          let dt = $("#ma-admin-datatable");

          chicksTable();

          $("#select_type").change(function () {
              dt.DataTable().destroy();
              chicksTable($(this).val())
          });

        function chicksTable(type = null) {
            return dt.table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'supplier', name: 'supplier'},
                    {data: 'type', name: 'type'},
                ],
                url: "{{ route("ajax.chicks.index") }}",
                data: {type: type}
            });
        }//end of function

        </script>
    @endpush
@endsection
