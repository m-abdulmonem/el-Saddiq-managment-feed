
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
                <div class="btn-group" role="group" aria-label="Basic btn-group">
                    <button type="button" class="btn btn-info btn-graph" id="btnShowPrices">@lang("$trans.btn_show_prices")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="btnShowLocations">@lang("$trans.btn_show_locations")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="btnShowConsumption">@lang("$trans.btn_show_consumption")</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="btnShowIncome">@lang("$trans.btn_show_income")</button>
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
        let date = $("#chartDate"),
            chart,
            elChart = $("#chart"),
            startDate,
            endDate,
            chartObject;

        $(function () {
            prices();
            date.maDatepicker();

            date.on('apply.daterangepicker', function(ev, picker) {
                let start = picker.startDate.unix(), end = picker.endDate.unix();

                tabs(start,end);
            });


            $(".btn-group button").click(function () {
                $(this).addClass("btn-info").removeClass("btn-secondary")
                    .siblings().removeClass("btn-info").addClass("btn-secondary")

                tabs();
            });
        });
        
        function tabs(start = null,end= null) {
            chartObject.destroy();

            if ($("#btnShowPrices").hasClass("btn-info"))
                prices(start,end);
            if ($("#btnShowLocations").hasClass("btn-info"))
                locations(start,end);
            if ($("#btnShowConsumption").hasClass("btn-info"))
                consumption(start,end);
            if ($("#btnShowIncome").hasClass("btn-info"))
                incomeStatement(start,end)
        }

        function prices(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.chicks.graph.prices",$chick->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], prices = [];

                    $.each(result[0],function (date,price) {
                        labels.push(date);
                        prices.push(price);
                    });

                    chartObject = elChart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("$trans.prices")",
                                data: prices,
                                color : 'rgba(60,141,188,0.9)'
                            }
                        }
                    });
                }
            });
        }
        function locations(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.chicks.graph.locations",$chick->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], quantity = [];

                    $.each(result[0],function (location,data) {
                        labels.push(location);
                        quantity.push(data);
                    });

                    chartObject = elChart.maChart({
                        labels: labels,
                        type: "bar",
                        min: 0,
                        data: {
                            0: {
                                label: "@lang("$trans.locations")",
                                data: quantity,
                                color : 'rgba(60,141,188,0.9)'
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
        function consumption(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.chicks.graph.consumption",$chick->id) }}",
                data: {start: start,end: end},
                success: function (result) {

                    console.log(result);
                    let labels = [], quantity = [];

                    $.each(result[0],function (date,data) {
                        labels.push(date);
                        quantity.push(data);
                    });

                    chartObject = elChart.maChart({
                        labels: labels,
                        data: {
                            0: {
                                label: "@lang("$trans.quantity")",
                                data: quantity,
                                color : 'rgba(60,141,188,0.9)'
                            }
                        }
                    });
                }
            });
        }
        function incomeStatement(start = null,end = null) {
            ajaxApi({
                url: "{{ route("ajax.chicks.graph.income.statement",$chick->id) }}",
                data: {start: start,end: end},
                success: function (result) {
                    let labels = [], gain = [], loss = [];

                    $.each(result[0],function (date,data) {
                        labels.push(date);
                        gain.push(data['gain']);
                        loss.push(data['loss']);
                    });

                    chartObject = elChart.maChart({
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
