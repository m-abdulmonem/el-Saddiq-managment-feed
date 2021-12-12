
<!-- BAR CHART -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title float-left">{{ trans("$trans.suppliers_chart") }}</h3>

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
                    <button type="button" class="btn btn-info btn-graph" id="btnQuantity">{{ trans("$trans.quantity") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnBills">{{ trans("$trans.bills") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnProducts">{{ trans("$trans.products") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnChicksQuantity">{{ trans("$trans.chicks_quantity") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnChicks">{{ trans("$trans.chicks") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnOrders">{{ trans("$trans.orders") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnIncomeStatement">{{ trans("$trans.income_statement") }}</button>
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
    <script src="{{ admin_assets("js/Chart.min.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("/js/moment.min.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("js/daterangepicker.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("js/plugins/datepicker.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("js/plugins/maChart.js") }}"></script>

    <script>
        let chart = $("#chart"),
            date = $("#chartDate"),
            chartObject;


        $(function () {
            quantity();

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
            if ($("#btnQuantity").hasClass("btn-info")){
                chartObject.destroy();
                quantity(start,end)
            }
            if ($("#btnBills").hasClass("btn-info")){
                chartObject.destroy();
                bills(start,end)
            }
            if ($("#btnProducts").hasClass("btn-info")){
                chartObject.destroy();
                products(start,end)
            }
            if ($("#btnChicksQuantity").hasClass("btn-info")){
                chartObject.destroy();
                chicksQuantity(start,end)
            }
            if ($("#btnChicks").hasClass("btn-info")){
                chartObject.destroy();
                chicks(start,end)
            }
            if ($("#btnOrders").hasClass("btn-info")){
                chartObject.destroy();
                orders(start,end)
            }
            if ($("#btnIncomeStatement").hasClass("btn-info")){
                chartObject.destroy();
                incomeStatement(start,end)
            }
        }

        /**
         * get quantities
         *
         * @param start
         * @param end
         */
        function quantity(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.suppliers.graph.quantity",$supplier->id) }}",
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
                                color: 'rgba(14,175,189,0.9)'
                            }
                        }
                    });
                }
            });
        }

        function bills(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.suppliers.graph.bills",$supplier->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], bills = [], returned = [];

                    $.each(result[0],function (date,data) {
                        labels.push(date);
                        bills.push(data[0]);
                        returned.push(data[1]);
                    });

                    chartObject = chart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("$trans.bills")",
                                data: bills,
                                color : 'rgba(60,141,188,0.9)'
                            },
                            1: {
                                label: "@lang("$trans.returned_bills")",
                                data: returned,
                                color: 'rgba(14,175,189,0.9)'
                            }
                        }
                    });
                }
            });
        }
        function products(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.suppliers.graph.products",$supplier->id) }}",
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
        function chicksQuantity(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.suppliers.graph.chicks.quantity",$supplier->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], quantity = [];

                    $.each(result[0],function (key,data) {
                        labels.push(data[0]);
                        quantity.push(data[1]);
                    });

                    chartObject = chart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("$trans.chicks_quantity_graph")",
                                data: quantity,
                                color : 'rgba(14,175,189,0.9)'
                            },
                        }
                    });
                }
            });
        }
        function chicks(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.suppliers.graph.chicks",$supplier->id) }}",
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
        function orders(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.suppliers.graph.orders",$supplier->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], quantity = [];

                    $.each(result[0],function (key,data) {
                        labels.push(data[0]);
                        quantity.push(data[1]);
                    });

                    chartObject = chart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("$trans.order_graph")",
                                data: quantity,
                                color : 'rgba(14,175,189,0.9)'
                            },
                        }
                    });
                }
            });
        }
        function incomeStatement(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.suppliers.graph.income.statement",$supplier->id) }}",
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
