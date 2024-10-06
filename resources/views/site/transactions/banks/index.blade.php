@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
        <link rel="stylesheet" type="text/css" href="{{ admin_assets("daterangepicker.css") }}" />
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
                    <table id="banksTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang("$trans.name")</th>
                                <th>@lang("balances.opening_balances")</th>
                                <th>@lang("$trans.address")</th>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("home.chart")</h3>
                    <a class="btn btn-info btn-print" href="{{route("ajax.transactions.banks.print")}}"><i class="fa fa-print"></i> @lang("home.print")</a>
                    <button class="btn btn-info btn-show-chart" ><i class="fas fa-chart-bar"></i> @lang("$trans.show_chart")</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-6">
                        <div id="date" class="mb-4" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                    <table id="chartsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("home.date")</th>
                            <th>@lang("$trans.statement")</th>
                            <th>@lang("balances.creditor")</th>
                            <th>@lang("balances.debtor")</th>
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
    @include("site.transactions.banks.modals.index")

    @push("js")
        {!! datatable_files() !!}
        <script type="text/javascript" src="{{ admin_assets("moment.min.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("daterangepicker.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("plugins/datepicker.js") }}"></script>
        <script>

            $(function () {

                $(".btn-show-chart").click(function () {
                    $(".btn-print").attr("href",$(".btn-print").attr("href").replace(/[0-9]/g, ''))
                    $("#chartsTable").DataTable().destroy();
                    charts();
                });

                $("body").on("click",".btn-chart",function () {
                    $(".btn-print").attr("href",$(".btn-print").attr("href") + `/${$(this).data("id")}`);
                    $("#chartsTable").DataTable().destroy();
                    charts($(this).data("id"))
                });

                $("#date").maDatepicker();

                $("#date").on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.format("YYYY-MM-DD"), end = picker.endDate.format("YYYY-MM-DD");
                    $("#chartsTable").DataTable().destroy();
                    charts(null,start,end)
                });
            });

            let table = $("#banksTable").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'opening_balance', name: 'opening_balance'},
                    {data: 'address', name: 'address'},
                ],
                actionColumnWidth: "250px",
                url: "{{ route("ajax.transactions.banks.index") }}"
            });

            function charts(id = null,start= null,end= null) {
                $("#chartsTable").table({
                    columns: [
                        {data: 'date', name: 'date'},
                        {data: 'statement', name: 'statement'},
                        {data: 'creditor', name: 'creditor'},
                        {data: 'debtor', name: 'debtor'},
                    ],
                    actionColumnWidth: "250px",
                    notColumns: ['actions'],
                    url: `{{ route("ajax.transactions.banks.charts") }}/${id}`,
                    data: {startDate: start,end: end}
                });
            }
        </script>
    @endpush

@endsection
