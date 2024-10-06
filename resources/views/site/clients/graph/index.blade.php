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
                <div class="btn-group " role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info btn-graph" id="invoicesReport">@lang("$trans.invoices_report")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="quantityReport">@lang("$trans.quantity_report")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="consumptionReport">@lang("$trans.consumption_report")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="bookingReport">@lang("$trans.booking_report")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="bookingQuantityReport">@lang("$trans.booking_quantity_report")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="chicksConsumptionReport">@lang("$trans.chicks_consumption_report")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="incomeStatementReport">@lang("$trans.income_statement_report")</button>
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
</div>
<!-- /.card -->

@push("js")
    <script src="{{ admin_assets("Chart.min.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("moment.min.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("daterangepicker.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("plugins/datepicker.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("plugins/maChart.js") }}"></script>

    <script>
        let chart = $("#chart"),
            date = $("#chartDate"),
            chartObject;


        $(function () {
            invoicesGraph();

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

        /**
         *
         */
        function clickedButton(start = null,end = null) {
            if ($("#invoicesReport").hasClass("btn-info")){
                chartObject.destroy();
                invoicesGraph(start,end)
            }
            if ($("#quantityReport").hasClass("btn-info")){
                chartObject.destroy();
                quantity(start,end)
            }
            if ($("#consumptionReport").hasClass("btn-info")){
                chartObject.destroy();
                consumption(start,end)
            }
            if ($("#bookingReport").hasClass("btn-info")){
                chartObject.destroy();
                bookingGraph(start,end)
            }
            if ($("#bookingQuantityReport").hasClass("btn-info")){
                chartObject.destroy();
                bookingQuantityGraph(start,end)
            }
            if ($("#chicksConsumptionReport").hasClass("btn-info")){
                chartObject.destroy();
                chicksConsumption(start,end)
            }
            if ($("#incomeStatementReport").hasClass("btn-info")){
                chartObject.destroy();
                incomeStatement(start,end)
            }
        }

        function invoicesGraph(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.clients.graph.invoices",$client->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], invoices = [], returned = [];

                    $.each(result[0],function (date,data) {
                        labels.push(date);
                        invoices.push(data[0]);
                        returned.push(data[1]);
                    });

                    chartObject = chart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("clients/bills.title")",
                                data: invoices,
                                color : 'rgba(60,141,188,0.9)'
                            },
                            1: {
                                label: "@lang("clients/bills.discarded_sale")",
                                data: returned,
                                color: 'rgba(192, 57, 43, 1)'
                            }
                        }
                    });
                }
            });
        }

        /**
         * get quantities
         *
         * @param start
         * @param end
         */
        function quantity(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.clients.graph.quantity",$client->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], quantity = [], returned = [];

                    $.each(result[0],function (date,data) {
                        labels.push(date);
                        quantity.push(data[0]);
                        returned.push(data[1]);
                    });

                    chartObject = chart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("$trans.quantity")",
                                data: quantity,
                                color : 'rgba(60,141,188,0.9)'
                            },
                            1: {
                                label: "@lang("$trans.returned_quantity")",
                                data: returned,
                                color: 'rgba(192, 57, 43, 1)'
                            }
                        }
                    });
                }
            });
        }


        function consumption(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.clients.graph.consumption",$client->id) }}",
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

        function bookingGraph(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.clients.graph.booking",$client->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], invoices = [];

                    $.each(result[0],function (date,data) {
                        labels.push(date);
                        invoices.push(data[0]);
                    });

                    chartObject = chart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("chicks/booking.title")",
                                data: invoices,
                                color : 'rgba(60,141,188,0.9)'
                            }
                        }
                    });
                }
            });

        }

        function bookingQuantityGraph(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.clients.graph.booking.quantity",$client->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], quantity = [];

                    $.each(result[0],function (key,data) {
                        labels.push(key);
                        quantity.push(data[0]);
                    });

                    chartObject = chart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("$trans.chicks_quantity")",
                                data: quantity,
                                color : 'rgba(14,175,189,0.9)'
                            },
                        }
                    });
                }
            });
        }
        function chicksConsumption(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.clients.graph.chicks.consumption",$client->id) }}",
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
        function incomeStatement(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.clients.graph.income.statement",$client->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], gain = [], loss = [];

                    $.each(result[0],function (date,data) {
                        labels.push(date);
                        gain.push(data['gain']);
                        loss.push(data['loss']);
                    });

                    chartObject = chart.maChart({
                        labels: labels,
                        activeCurrency: true,
                        data: {
                            0: {
                                label: "@lang("balances.gain")",
                                data: gain,
                                color : 'rgba(60,141,188,0.9)'
                            },
                            1: {
                                label: "@lang("balances.loss")",
                                data: loss,
                                color: 'rgba(192, 57, 43, 1)'
                            }
                        }
                    });
                }
            });
        }

    </script>
@endpush
