
<!-- BAR CHART -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title float-left">@lang("home.chart")</h3>

        <div class="card-tools float-right">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-9">
                <div class="btn-group " role="group" aria-label="Basic btn-group">
                    <button type="button" class="btn btn-info btn-graph" id="btnShowConsumption">@lang("products/products.consumption_report")</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnShowTopProducts">@lang("products/products.consumption_report")</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnLocationsGraph">@lang("products/products.locations_report")</button>
                </div>
                <!-- ./col-8 -->
            </div>
            <!-- ./col -->
            <div class="col-3">
                <div id="chartDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="chart">
            <canvas id="chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer d-flex">

    </div>
    <!-- ./card-footer -->
</div>
<!-- /.card -->

@push("js")
    <script src="{{ admin_assets("Chart.min.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("moment.min.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("daterangepicker.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("plugins/datepicker.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("plugins/maChart.js") }}"></script>
    <script>
        $(function () {
            let chart = $("#chart"),
                date = $("#chartDate"),
                chartObject;


            $(function () {
                consumptionGraph();

                date.maDatepicker();

                date.on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.format("YYYY-MM-DD"), end = picker.endDate.format("YYYY-MM-DD");
                    clickedButton(start,end)
                });


                $(".btn-group button").click(function () {
                    $(this).addClass("btn-info").removeClass("btn-light")
                        .siblings().removeClass("btn-info").addClass("btn-light");

                    clickedButton()
                });

            });


            function clickedButton(start = null,end = null) {
                if ($("#btnShowConsumption").hasClass("btn-info")){
                    chartObject.destroy();
                    consumptionGraph(start,end)
                }
                if ($("#btnShowTopProducts").hasClass("btn-info")){
                    chartObject.destroy();
                    productsGraph(start,end)
                }
                if ($("#btnLocationsGraph").hasClass("btn-info")){
                    chartObject.destroy();
                    locationGraph(start,end)
                }

            }

            function consumptionGraph(start = null,end = null) {
                ajaxApi({
                    url: "{{ route("ajax.stocks.graph.consumption",$stock->id) }}",
                    data: {start: start,end: end},
                    success: function (result) {
                        let labels = [], quantity = [],returned = [];

                        $.each(result[0],function (name,data) {
                            labels.push(name);
                            quantity.push(data[0]);
                            returned.push(data[1])
                        });

                        chartObject = chart.maChart({
                            labels: labels,
                            data: {
                                0: {
                                    label: "@lang("products/products.sold")",
                                    data: quantity,
                                    color : 'rgba(60,141,188,0.9)'
                                },
                                1: {
                                    label: "@lang("products/products.returned")",
                                    data: returned,
                                    color: 'rgba(192, 57, 43, 1)'
                                }
                            }
                        });
                    }
                });
            }
            function productsGraph(start = null,end = null) {
                ajaxApi({
                    url: "{{ route("ajax.stocks.graph.products",$stock->id) }}",
                    data: {start: start,end: end},
                    success: function (result) {
                        let labels = [], quantity = [],color = [];

                        $.each(result[0],function (name,data) {
                            labels.push(name);
                            quantity.push(data[0]);
                            color.push(data[1])
                        });

                        chartObject = chart.maChart({
                            labels: labels,
                            type: "doughnut",
                            data: {
                                0: {
                                    data: quantity,
                                    color : color
                                },
                            }
                        });
                    }
                });
            }
            function locationGraph(start = null,end = null) {
                ajaxApi({
                    url: "{{ route("ajax.stocks.graph.location",$stock->id) }}",
                    data: {start: start,end: end},
                    success: function (result) {
                        let labels = [], quantity = [],color = [];

                        $.each(result[0],function (name,data) {
                            labels.push(name);
                            quantity.push(data[0]);
                            color.push(data[1])
                        });

                        chartObject = chart.maChart({
                            labels: labels,
                            type: "doughnut",
                            data: {
                                0: {
                                    data: quantity,
                                    color : color
                                },
                            }
                        });
                    }
                });
            }


            function applyDate(el,callback) {
                el.maDatepicker();
                el.on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.format("YYYY-MM-DD"), end = picker.endDate.format("YYYY-MM-DD");
                    callback(start,end)
                });
            }
        });



    </script>
@endpush
