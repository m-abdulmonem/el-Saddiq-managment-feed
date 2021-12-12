@push("css")
    <link rel="stylesheet" type="text/css" href="{{ admin_assets("css/daterangepicker.css") }}" />
@endpush
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
                <div class="btn-group " role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info btn-graph" id="btnBillsCount">{{ trans("$trans.btn_show_bills_count_report") }}</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="btnShowQuantity">{{ trans("$trans.btn_show_quantity_report") }}</button>
                    <button type="button" class="btn btn-secondary btn-graph" id="btnShowMostConsumptionProducts">{{ trans("$trans.btn_show_most_consumption_products") }}</button>
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
        <div class="col-4  d-flex">
{{--            <h4 > {{ trans("balances.total_invoices") }} : <span class="info-color ml-2">{{ currency($client->totalBills()) }}</span></h4>--}}
        </div>

        <div class="col-4 d-flex">
{{--            <h5 > {{ trans("balances.profit") }} : <span class="info-color ml-2"> {{ currency($client->getGain()) }} </span></h5>--}}
        </div>
        <div class="col-4 d-flex">
{{--            <h5 > {{ trans("balances.loss") }} : <span class="info-color ml-2"> {{ currency($client->getLoss()) }} </span></h5>--}}
        </div>
    </div>
    <!-- ./card-footer -->
</div>
<!-- /.card -->



@push("js")
    <script src="{{ admin_assets("js/Chart.min.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("/js/moment.min.js") }}"></script>
    <script type="text/javascript" src="{{ admin_assets("js/daterangepicker.js") }}"></script>
    <script>
        $(function () {
            let chart,elChart = $("#chart"),chartDate = $('#chartDate'),
                start = moment().subtract(29, 'days'),
                end = moment(),
                startDate,endDate;
            $.fn.extend({
                showBillsGraph: function (start= null, end= null) {
                    let $this = $(this);
                    {{--$.ajax({--}}
                    {{--    url: "{{ route("graph.client.bills",$client->id) }}",--}}
                    {{--    data : {start:start,end:end},--}}
                    {{--    dataType:"json",--}}
                    {{--    success: function (data) {--}}
                    {{--        let returnBills = [],--}}
                    {{--            bills = [],--}}
                    {{--            months = [];--}}


                    {{--        $.each(data.data,function (k,v) {--}}
                    {{--            months.push(k);--}}
                    {{--            bills.push(v["invoice"]);--}}
                    {{--            returnBills.push(v["returnBills"])--}}
                    {{--        });--}}



                    {{--       chart = new Chart($this.get(0).getContext('2d'), {--}}
                    {{--            type: 'bar',--}}
                    {{--            data: {--}}
                    {{--                labels  : months,--}}
                    {{--                datasets: [--}}
                    {{--                    {--}}
                    {{--                        label               : '{{ trans("clients_bills.discarded_sale") }}',--}}
                    {{--                        backgroundColor     : 'rgba(210, 214, 222, 1)',--}}
                    {{--                        borderColor         : 'rgba(210, 214, 222, 1)',--}}
                    {{--                        pointColor          : 'rgba(210, 214, 222, 1)',--}}
                    {{--                        pointHighlightStroke: 'rgba(220,220,220,1)',--}}
                    {{--                        pointStrokeColor    : '#c1c7d1',--}}
                    {{--                        pointHighlightFill  : '#fff',--}}
                    {{--                        data                : returnBills,--}}
                    {{--                    },--}}
                    {{--                    {--}}
                    {{--                        label               : '{{ trans("clients_bills.sales") }}',--}}
                    {{--                        backgroundColor     : 'rgba(60,141,188,0.9)',--}}
                    {{--                        borderColor         : 'rgba(60,141,188,0.8)',--}}
                    {{--                        pointStrokeColor    : 'rgba(60,141,188,1)',--}}
                    {{--                        pointHighlightStroke: 'rgba(60,141,188,1)',--}}
                    {{--                        pointColor          : '#3b8bba',--}}
                    {{--                        pointHighlightFill  : '#fff',--}}
                    {{--                        data                : bills,--}}
                    {{--                    },--}}

                    {{--                ]--}}
                    {{--            },--}}
                    {{--            options: {--}}
                    {{--                responsive              : true,--}}
                    {{--                maintainAspectRatio     : false,--}}
                    {{--                datasetFill             : true,--}}
                    {{--                scales: {--}}
                    {{--                    yAxes: [{--}}
                    {{--                        ticks: {--}}
                    {{--                            min: 0,--}}
                    {{--                            stepSize: 1--}}
                    {{--                        }--}}
                    {{--                    }]--}}
                    {{--                }//end of scales--}}
                    {{--            }//end of option--}}
                    {{--        });// end of chart--}}


                    {{--    }// end of success--}}
                    {{--}); // end of ajax--}}
                    return $this;
                },

                {{--showQuantityGraph : function (start= null, end= null) {--}}
                {{--    let $this = $(this);--}}
                {{--    $.ajax({--}}
                {{--        url: "{{ route("graph.client.quantity",$client->id) }}",--}}
                {{--        data : {start:start,end:end},--}}
                {{--        dataType:"json",--}}
                {{--        success: function (data) {--}}
                {{--            let salesQuantity = [],--}}
                {{--                discardedSalesQuantity = [],--}}
                {{--                months = [];--}}

                {{--            $.each(data.data,function (k,v) {--}}
                {{--                months.push(k);--}}
                {{--                salesQuantity.push(v["sales"]);--}}
                {{--                discardedSalesQuantity.push(v["discardedSales"])--}}
                {{--            });--}}


                {{--           chart = new Chart($this.get(0).getContext('2d'), {--}}
                {{--                type: 'bar',--}}
                {{--                data: {--}}
                {{--                    labels  : months,--}}
                {{--                    datasets: [--}}
                {{--                        {--}}
                {{--                            label               : '{{ trans("clients_bills.discarded_sale") }}',--}}
                {{--                            backgroundColor     : 'rgba(210, 214, 222, 1)',--}}
                {{--                            borderColor         : 'rgba(210, 214, 222, 1)',--}}
                {{--                            pointColor          : 'rgba(210, 214, 222, 1)',--}}
                {{--                            pointHighlightStroke: 'rgba(220,220,220,1)',--}}
                {{--                            pointStrokeColor    : '#c1c7d1',--}}
                {{--                            pointHighlightFill  : '#fff',--}}
                {{--                            data                : discardedSalesQuantity,--}}
                {{--                        },--}}
                {{--                        {--}}
                {{--                            label               : '{{ trans("clients_bills.sales") }}',--}}
                {{--                            backgroundColor     : 'rgba(60,141,188,0.9)',--}}
                {{--                            borderColor         : 'rgba(60,141,188,0.8)',--}}
                {{--                            pointStrokeColor    : 'rgba(60,141,188,1)',--}}
                {{--                            pointHighlightStroke: 'rgba(60,141,188,1)',--}}
                {{--                            pointColor          : '#3b8bba',--}}
                {{--                            pointHighlightFill  : '#fff',--}}
                {{--                            data                : salesQuantity,--}}
                {{--                        },--}}

                {{--                    ]--}}
                {{--                },--}}
                {{--                options: {--}}
                {{--                    responsive              : true,--}}
                {{--                    maintainAspectRatio     : false,--}}
                {{--                    datasetFill             : true,--}}
                {{--                    scales: {--}}
                {{--                        yAxes: [{--}}
                {{--                            ticks: {--}}
                {{--                                min: 0,--}}
                {{--                                stepSize: 1--}}
                {{--                            }--}}
                {{--                        }]--}}
                {{--                    }//end of scales--}}
                {{--                }//end of option--}}
                {{--            })// end of chart--}}
                {{--        }// end of success--}}
                {{--    }); // end of ajax--}}
                {{--},--}}

                {{--showProductsConsumption : function (start= null, end= null) {--}}
                {{--    let $this = $(this);--}}
                {{--    $.ajax({--}}
                {{--        url: "{{ route("graph.client.usedProduct",$client->id) }}",--}}
                {{--        data : {start:start,end:end},--}}
                {{--        dataType:"json",--}}
                {{--        success: function (data) {--}}
                {{--            let products = [],--}}
                {{--                color = [],--}}
                {{--                quantity = [];--}}

                {{--            console.log(data.data);--}}

                {{--            $.each(data.data,function (k,v) {--}}
                {{--                color.push(k);--}}
                {{--                products.push(v['p']);--}}
                {{--                quantity.push(v['q'])--}}
                {{--            });--}}


                {{--            //Create pie or douhnut chart--}}
                {{--            // You can switch between pie and douhnut using the method below.--}}
                {{--            chart = new Chart($this.get(0).getContext('2d'), {--}}
                {{--                type: 'doughnut',--}}
                {{--                data: {--}}
                {{--                    labels: products,--}}
                {{--                    datasets: [--}}
                {{--                        {--}}
                {{--                            data: quantity,--}}
                {{--                            backgroundColor : color, //['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],--}}
                {{--                        }--}}
                {{--                    ]--}}
                {{--                },--}}
                {{--                options: {--}}
                {{--                    maintainAspectRatio : false,--}}
                {{--                    responsive : true,--}}
                {{--                }--}}
                {{--            });--}}

                {{--        }// end of success--}}
                {{--    }); // end of ajax--}}
                {{--    return $this;--}}
                {{--}--}}
            });// functions


            chartDate.daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'اليوم': [moment(), moment()],
                    'الامس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'اخر 7 ايام': [moment().subtract(6, 'days'), moment()],
                    'اخر 30 يوم': [moment().subtract(29, 'days'), moment()],
                    'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
                    'الشهر الماضى': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'منذ البداية': ["منذ البداية",null]
                },
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " to ",
                    "applyLabel": "عرض",
                    "cancelLabel": "إالغاء",
                    "fromLabel": "من",
                    "toLabel": "الى",
                    "customRangeLabel": "عرض فترة مخصصة",
                    "weekLabel": "إسبوع",
                    "daysOfWeek": [
                        "ح",
                        "ن",
                        "ث",
                        "ع",
                        "خ",
                        "ج",
                        "س"
                    ],
                    "monthNames": [
                        "يسناير",
                        "فيراير",
                        "مارس",
                        "إبريل",
                        "مايو",
                        "يونيو",
                        "يوليو",
                        "أغسطس",
                        "ستمبر",
                        "أكتوبر",
                        "نوفمبر",
                        "ديسمبر"
                    ],
                    "firstDay": 1
                },
            }, cb);

            $('#datepicker').datepicker({
                language: "ar",
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
                format: "yyyy-mm-dd"
            });

            startDate = chartDate.data('daterangepicker').startDate.unix();
            endDate = chartDate.data('daterangepicker').endDate.unix();

            elChart.showBillsGraph(startDate,endDate);

            $("#btnBillsCount").click(function () {
                initChart().showBillsGraph(startDate,endDate)
            });

            $("#btnShowQuantity").click(function () {
                initChart().showQuantityGraph(startDate,endDate)
            });

            $("#btnShowMostConsumptionProducts").click(function () {
                initChart().showProductsConsumption(startDate,endDate)
            });

            $(".btn-graph").click(function () {
                $(this).removeClass("btn-secondary").addClass("btn-info")
                    .siblings().removeClass("btn-info").addClass("btn-secondary")
            });


            chartDate.on('apply.daterangepicker', function(ev, picker) {
                let start = picker.startDate.unix(),//format('YYYY-MM-DD'),
                    end = picker.endDate.unix();//format('YYYY-MM-DD');


                if ($(".btn-group #btnBillsCount").hasClass("btn-info"))
                    initChart().showBillsGraph(start,end);

                if ($(".btn-group #btnShowQuantity").hasClass("btn-info"))
                    initChart().showQuantityGraph(start,end);

                if ($(".btn-group #btnShowMostConsumptionProducts").hasClass("btn-info"))
                    initChart().showProductsConsumption(start,end);
            });


            cb(start, end);

            function cb(start, end) {
                
                $('#chartDate span').html(start.format('YYYY-MM-DD') + ' الى ' + end.format('YYYY-MM-DD'));
            }

            function initChart() {
                chart.destroy();
                return elChart
            }
        });



    </script>
@endpush
