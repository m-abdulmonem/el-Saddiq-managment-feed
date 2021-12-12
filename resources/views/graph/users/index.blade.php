
<!-- BAR CHART -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title float-left">{{ trans("$trans.bills_chart") }}</h3>

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
                    <button type="button" class="btn btn-info btn-graph" id="btnShowPrices">{{ trans("$trans.btn_sales") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnShowPrices">{{ trans("$trans.purchase") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnShowPrices">{{ trans("$trans.chicks") }}</button>
                    <button type="button" class="btn btn-light btn-graph" id="btnShowLocations">{{ trans("$trans.btn_work_hours") }}</button>
{{--                    <button type="button" class="btn btn-light btn-graph" id="btnShowConsumption">{{ trans("$trans.btn_absence") }}</button>--}}
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

    <script>
        $(".btn-group button").click(function () {
            $(this).addClass("btn-info").removeClass("btn-light")
                .siblings().removeClass("btn-info").addClass("btn-light")
        });
    </script>

{{--    <script>--}}
{{--        $(function () {--}}
{{--            let date = $("#chartDate"),--}}
{{--                chart,--}}
{{--                elChart = $("#chart"),--}}
{{--                startDate,endDate;--}}

{{--            $.fn.extend({--}}
{{--                prices: function (start= null, end= null) {--}}
{{--                    let $this = $(this);--}}
{{--                    ajaxApi({--}}
{{--                        url: "{{ route("ajax.graph.chicks.prices",$chick->id) }}",--}}
{{--                        data : {start:start,end:end},--}}
{{--                        dataType:"json",--}}
{{--                        success: function (result) {--}}
{{--                            let dates = [],prices = [];--}}

{{--                            $.each(result.data[1],function (k,data) {--}}
{{--                                dates.push(data["dates"]);--}}
{{--                                prices.push(data["prices"])--}}
{{--                            });--}}

{{--                            chart = new Chart($this.get(0).getContext('2d'), {--}}
{{--                                type: 'line',--}}
{{--                                data: {--}}
{{--                                    labels  : dates,//prices dates--}}
{{--                                    datasets: [--}}
{{--                                        {--}}
{{--                                            label               : "@lang("chicks.prices")",--}}
{{--                                            backgroundColor     : 'rgba(60,141,188,0.9)',--}}
{{--                                            borderColor         : 'rgba(60,141,188,0.8)',--}}
{{--                                            pointStrokeColor    : 'rgba(60,141,188,1)',--}}
{{--                                            pointHighlightStroke: 'rgba(60,141,188,1)',--}}
{{--                                            pointColor          : '#3b8bba',--}}
{{--                                            pointHighlightFill  : '#fff',--}}
{{--                                            data                : prices, // prices value--}}
{{--                                            fill: true,--}}
{{--                                            borderWidth: 1 // Specify bar border width--}}
{{--                                        },--}}

{{--                                    ]--}}
{{--                                },--}}
{{--                                options: {--}}
{{--                                    responsive              : true,--}}
{{--                                    maintainAspectRatio     : false,--}}
{{--                                    datasetFill             : true,--}}
{{--                                    scales: {--}}
{{--                                        yAxes: [{--}}
{{--                                            ticks: {--}}
{{--                                                min: 0,--}}
{{--                                                stepSize: 1--}}
{{--                                            }--}}
{{--                                        }]--}}
{{--                                    }//end of scales--}}
{{--                                }//end of option--}}
{{--                            });// end of chart--}}


{{--                        }// end of success--}}
{{--                    }); // end of ajax--}}
{{--                    return $this;--}}
{{--                },--}}
{{--                locations: function (start = null, end= null) {--}}
{{--                    let $this = $(this);--}}
{{--                    ajaxApi({--}}
{{--                        url: "{{ route("ajax.graph.chicks.locations",$chick->id) }}",--}}
{{--                        data : {start:start,end:end},--}}
{{--                        dataType:"json",--}}
{{--                        success: function (result) {--}}
{{--                            chart = new Chart($this.get(0).getContext('2d'), {--}}
{{--                                type: 'bar',--}}
{{--                                data: {--}}
{{--                                    labels  : result[0].data[0]['locations'],//prices dates--}}
{{--                                    datasets: [--}}
{{--                                        {--}}
{{--                                            label               : "@lang("chicks.locations")",--}}
{{--                                            backgroundColor     : 'rgba(60,141,188,0.9)',--}}
{{--                                            borderColor         : 'rgba(60,141,188,0.8)',--}}
{{--                                            pointStrokeColor    : 'rgba(60,141,188,1)',--}}
{{--                                            pointHighlightStroke: 'rgba(60,141,188,1)',--}}
{{--                                            pointColor          : '#3b8bba',--}}
{{--                                            pointHighlightFill  : '#fff',--}}
{{--                                            data                : result[0].data[0]['quantity'], // prices value--}}
{{--                                            // fill: true,--}}
{{--                                            borderWidth: 1 // Specify bar border width--}}
{{--                                        },--}}

{{--                                    ]--}}
{{--                                },--}}
{{--                                options: {--}}
{{--                                    responsive              : true,--}}
{{--                                    maintainAspectRatio     : false,--}}
{{--                                    datasetFill             : true,--}}
{{--                                    scales: {--}}
{{--                                        yAxes: [{--}}
{{--                                            ticks: {--}}
{{--                                                min: 0,--}}
{{--                                                stepSize: 1--}}
{{--                                            }--}}
{{--                                        }]--}}
{{--                                    }//end of scales--}}
{{--                                }//end of option--}}
{{--                            });// end of chart--}}


{{--                        }// end of success--}}
{{--                    }); // end of ajax--}}
{{--                    return $this;--}}
{{--                },--}}
{{--                consumption: function (start = null, end= null) {--}}
{{--                    let $this = $(this);--}}
{{--                    ajaxApi({--}}
{{--                        url: "{{ route("ajax.graph.chicks.consumption",$chick->id) }}",--}}
{{--                        data : {start:start,end:end},--}}
{{--                        dataType:"json",--}}
{{--                        success: function (result) {--}}
{{--                            chart = new Chart($this.get(0).getContext('2d'), {--}}
{{--                                type: 'line',--}}
{{--                                data: {--}}
{{--                                    labels  : result[0].data[0]['dates'],//prices dates--}}
{{--                                    datasets: [--}}
{{--                                        {--}}
{{--                                            label               : "@lang("chicks.locations")",--}}
{{--                                            backgroundColor     : 'rgba(60,141,188,0.9)',--}}
{{--                                            borderColor         : 'rgba(60,141,188,0.8)',--}}
{{--                                            pointStrokeColor    : 'rgba(60,141,188,1)',--}}
{{--                                            pointHighlightStroke: 'rgba(60,141,188,1)',--}}
{{--                                            pointColor          : '#3b8bba',--}}
{{--                                            pointHighlightFill  : '#fff',--}}
{{--                                            data                : result[0].data[0]['quantity'], // prices value--}}
{{--                                            fill: true,--}}
{{--                                            borderWidth: 1 // Specify bar border width--}}
{{--                                        },--}}

{{--                                    ]--}}
{{--                                },--}}
{{--                                options: {--}}
{{--                                    responsive              : true,--}}
{{--                                    maintainAspectRatio     : false,--}}
{{--                                    datasetFill             : true,--}}
{{--                                    scales: {--}}
{{--                                        yAxes: [{--}}
{{--                                            ticks: {--}}
{{--                                                min: 0,--}}
{{--                                                stepSize: 1--}}
{{--                                            }--}}
{{--                                        }]--}}
{{--                                    }//end of scales--}}
{{--                                }//end of option--}}
{{--                            });// end of chart--}}
{{--                        }// end of success--}}
{{--                    }); // end of ajax--}}
{{--                    return $this;--}}
{{--                }--}}
{{--            });// functions--}}



{{--            elChart.prices();--}}
{{--            date.maDatepicker();--}}

{{--            date.on('apply.daterangepicker', function(ev, picker) {--}}
{{--                let start = picker.startDate.unix(), end = picker.endDate.unix();--}}

{{--                if ($(".btn-graph #btnShowPrices").hasClass("btn-info"))--}}
{{--                    initChart().prices(start,end);--}}
{{--                if ($(".btn-graph #btnShowLocations").hasClass("btn-info"))--}}
{{--                    initChart().locations(start,end);--}}
{{--                if ($(".btn-graph #btnShowConsumption").hasClass("btn-info"))--}}
{{--                    initChart().consumption(start,end)--}}
{{--            });--}}



{{--            $("#btnShowPrices").click(function () {--}}
{{--                initChart().prices(startDate,endDate)--}}
{{--            });--}}

{{--            $("#btnShowLocations").click(function () {--}}
{{--                initChart().locations(startDate,endDate)--}}
{{--            });--}}
{{--            $("#btnShowConsumption").click(function () {--}}
{{--                initChart().consumption(startDate,endDate)--}}
{{--            });--}}
{{--            function initChart() {--}}
{{--                chart.destroy();--}}
{{--                return elChart--}}
{{--            }--}}
{{--        });--}}



{{--    </script>--}}
@endpush
