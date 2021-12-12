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
                                <label for="select_account_type">@lang("$trans.select_account_type")</label>
                                <select name="" id="select_account_type" class="form-control">
                                    {!! select_options([null,"customer","trader"],null,null,$trans) !!}
                                </select>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            @can("create client")
                                <button class="btn btn-primary btn-add" data-toggle="modal" data-target="#clientModal">
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
                    <table id="clientsTable" class="table table-bordered table-striped" >
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

    @include("site.clients.modals.client")

    @push("js")
        {!! datatable_files() !!}
        <script>
          let dt = $("#clientsTable");

          clientsTable();

          $("#select_account_type").change(function () {
              dt.DataTable().destroy();
              clientsTable($(this).val())
          });

        function clientsTable(type = null) {
            return dt.table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {data: 'balances', name: 'balances'},
                    {data: 'creditor', name: 'creditor'},
                    {data: 'debtor', name: 'debtor'},
                    {data: 'latest_bill', name: 'latest_bill'},
                ],
                url: "{{ route("ajax.clients.index") }}",
                data: {type: type}
            });
        }//end of function

        </script>
    @endpush
@endsection
