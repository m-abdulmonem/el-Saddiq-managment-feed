@extends("site.layouts.index")
@section("content")
    @push("css")
        <link rel="stylesheet" type="text/css" href="{{ admin_assets("daterangepicker.css") }}" />
        {!! datatable_files("css") !!}
    @endpush

    <div class="row">

        <div class="col-12">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title float-left">@lang("users/users.main_info")</h3>
                            @can("delete product")
                                <button class="btn btn-danger btn-delete " type="button"
                                        data-url="{{ route("clients.destroy",$product->id) }}"
                                        data-name="{{  $product->name }}" data-token="{{ csrf_token() }}"
                                        data-title="@lang("home.confirm_delete")"
                                        data-text="@lang("home.alert_delete",['name'=> $product->name])"
                                        data-back="{{ route("clients.index") }}">
                                    <a><i class="fa fa-trash"></i> @lang("home.delete")</a>
                                </button>
                            @endcan
                            @can("update product")
                                <button class='btn btn-info btn-update'
                                        data-id="{{ $product->id }}"
                                        data-name='{{$product->name}}'
                                        data-supplier_id='{{$product->supplier_id}}'
                                        data-supplier_name='{{$product->supplier->name}}'
                                        data-category_id='{{$product->category_id}}'
                                        data-category_name='{{$product->category->name}}'
                                        data-notes='{{$product->notes}}'><i class='fa fa-edit'></i> @lang("home.update")</button>
                            @endcan
                            <button class='btn btn-secondary btn-price-update'
                                    data-id='{{$product->id}}'
                                    data-price='{{$product->latestPrice()}}'
                                    data-sale_price='{{$product->salePrice()}}'
                                    title='".trans("$this->trans.update_price")."'><i class='fas fa-money-bill-alt'></i></button>
                            @can("create product")<button type="button" class="btn btn-info btn-add"><i class="fa fa-plus"></i> @lang("home.create")</button>@endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body row  main-info">
                            <div class="col-6">
                                <ul class="list-ar-numeric">
                                    <li><span class="title odd">@lang("$trans.name")</span> {{$product->name()}}</li>
                                    <li><span class="title even">@lang("$trans.discount")</span> {{currency($product->discount)}}</li>
                                    <li><span class="title odd">@lang("$trans.category")</span> {{ $product->category->name }}</li>
                                    <li><span class="title even">@lang("$trans.unit")</span> {{ $product->unit->name }}</li>
                                    <li><span class="title odd">@lang("$trans.latest_price")</span> {{currency($product->latestPrice())}}</li>
                                    <li><span class="title even">@lang("$trans.price")</span> {{currency($product->salePrice())}}</li>

                                </ul>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <ul class="list-ar-numeric">
                                    <li><span class="title even">@lang("$trans.remaining_quantity")</span> {{ $product->remainingQuantity() }}</li>
                                    <li><span class="title odd">@lang("$trans.expired")</span> {{num_to_ar($product->expired())}}</li>
                                    <li><span class="title even">@lang("$trans.quantity")</span> {{num_to_ar($product->clientProduct()->sum("quantity"))}}</li>
                                    <li><span class="title odd">@lang("$trans.returned_quantity")</span> {{num_to_ar($product->clientProductReturn()->sum("quantity"))}}</li>
                                    <li><span class="title even">@lang("balances.gain")</span> {{currency($product->debt()->sum("gain"))}}</li>
                                    <li><span class="title odd">@lang("balances.loss")</span> {{ currency($product->debt()->sum("loss")) }}</li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title float-left">@lang("$trans.locations_report")</h3>

                            <div class="card-tools float-right">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="locationsDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="chart">
                                <canvas id="locationsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>

        <!-- consumption -->
        <div class="col-12">
            <!-- BAR CHART -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("$trans.consumption_report")</h3>

                    <div class="card-tools float-right">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div id="consumptionDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="chart">
                        <canvas id="consumptionChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- ./col -->
        <!-- price -->
        <div class="col-12">
            <!-- BAR CHART -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("$trans.prices_report")</h3>

                    <div class="card-tools float-right">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div id="pricesDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="chart">
                        <canvas id="pricesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- ./col -->
        <!-- incomeStatement -->
        <div class="col-12">
            <!-- BAR CHART -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">@lang("$trans.income_statement_report")</h3>

                    <div class="card-tools float-right">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div id="incomeStatementDate" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="chart">
                        <canvas id="incomeStatementChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- ./col -->

    </div>
    <!-- /.row -->

    @include("site.products.modals.index")
    @include("site.products.modals.update_price")

    @push("js")
        <script src="{{admin_assets("datatables/table.js")}}"></script>
        <script src="{{ admin_assets("Chart.min.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("/moment.min.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("daterangepicker.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("plugins/datepicker.js") }}"></script>
        <script type="text/javascript" src="{{ admin_assets("plugins/maChart.js") }}"></script>

        <script>
            let locationsObject,consumptionObject,pricesObject,incomeStatementObject;


            $(function () {
                //locations
                locationsGraph();
                applyDate($("#locationsDate"),function (start,end) {
                    locationsObject.destroy();
                    locationsGraph(start,end);
                });
                //consumption
                consumptionGraph();
                applyDate($("#consumptionDate"),function (start,end) {
                    consumptionObject.destroy();
                    consumptionGraph(start,end);
                });
                //prices
                pricesGraph();
                applyDate($("#pricesDate"),function (start,end) {
                    pricesObject.destroy();
                    pricesGraph(start,end);
                });
                //incomeStatement
                incomeStatementGraph();
                applyDate($("#incomeStatementDate"),function (start,end) {
                    incomeStatementObject.destroy();
                    incomeStatementGraph(start,end);
                });
            });

            function applyDate(el,callback) {
                el.maDatepicker();
                el.on('apply.daterangepicker', function(ev, picker) {
                    let start = picker.startDate.format("YYYY-MM-DD"), end = picker.endDate.format("YYYY-MM-DD");
                    callback(start,end)
                });
            }


            function locationsGraph(start = null,end = null) {
                ajaxApi({
                    url: "{{ route("ajax.products.graph.locations",$product->id) }}",
                    data: {start: start,end: end},
                    success: function (result) {
                        let labels = [], quantity = [],color = [];

                        $.each(result[0],function (name,data) {
                            labels.push(name);
                            quantity.push(data[0]);
                            color.push(data[1])
                        });

                        locationsObject = $("#locationsChart").maChart({
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
            function consumptionGraph(start = null,end = null) {
                ajaxApi({
                    url: "{{ route("ajax.products.graph.consumption",$product->id) }}",
                    data: {start: start,end: end},
                    success: function (result) {
                        let labels = [], quantity = [], returned = [];

                        $.each(result[0],function (date,data) {
                            labels.push(date);
                            quantity.push(data[0]);
                            returned.push(data[1]);
                        });

                        consumptionObject = $("#consumptionChart").maChart({
                            labels: labels,
                            data: {
                                0: {
                                    label: "@lang("$trans.sold")",
                                    data: quantity,
                                    color : 'rgba(60,141,188,0.9)'
                                },
                                1: {
                                    label: "@lang("$trans.returned")",
                                    data: returned,
                                    color: 'rgba(192, 57, 43, 1)'
                                }
                            }
                        });
                    }
                });
            }
            function pricesGraph(start = null,end = null) {
                ajaxApi({
                    url: "{{ route("ajax.products.graph.prices",$product->id) }}",
                    data: {start: start,end: end},
                    success: function (result) {
                        let labels = [], prices = [];

                        $.each(result[0],function (date,price) {
                            labels.push(date);
                            prices.push(price);
                        });

                        pricesObject = $("#pricesChart").maChart({
                            labels: labels,
                            activeCurrency: true,
                            data: {
                                0: {
                                    label: "@lang("$trans.unit_price")",
                                    data: prices,
                                    color : 'rgba(60,141,188,0.9)'
                                }
                            }
                        });
                    }
                });
            }
            function incomeStatementGraph(start = null,end = null) {
                ajaxApi({
                    url: "{{ route("ajax.products.graph.income.statement",$product->id) }}",
                    data: {start: start,end: end},
                    success: function (result) {
                        let labels = [], gain = [],loss = [];

                        $.each(result[0],function (date,income) {
                            labels.push(date);
                            gain.push(income['gain']);
                            loss.push(income['loss']);
                        });

                        incomeStatementObject = $("#incomeStatementChart").maChart({
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

@endsection

