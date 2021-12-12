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
                                <label for="select_status">@lang("$trans.select_status")</label>
                                <select name="" id="select_status" class="form-control">
                                    {!! select_options([null,"1","0"],null,"0",$trans) !!}
                                </select>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            @can("create $perm")
                                <button class="btn btn-primary btn-add" data-toggle="modal" data-target="#OrdersModel">
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
                    <table id="ordersTable" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("$trans.name")</th>
                            <th>@lang("$trans.price")</th>
                            <th>@lang("$trans.chick_price")</th>
                            <th>@lang("$trans.quantity")</th>
                            <th>@lang("$trans.status")</th>
                            <th>@lang("chicks/chicks.chick")</th>
                            <th>@lang("$trans.came")</th>
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

    @include("site.chicks.orders.modals.index")
    @include("site.chicks.orders.modals.arrived")
    @include("site.chicks.orders.modals.arriveDate")

    @push("js")
        {!! datatable_files() !!}
        <script>
            let dt = $("#ordersTable"),
                status = $("#select_status"),
                body = $("body");



            chicksTable( status.val() );

            status.change(function () {
                dt.DataTable().destroy();
                chicksTable($(this).val())
            });


            body.on("click",".btn-order-from-supplier",function () {
                let $this = $(this);

                swal({
                    title: "@lang("home.alert_confirm")",
                    text: "@lang("chicks/orders.alert_order_text")",
                    icon: "info",
                    buttons: {
                        cancel: "@lang("home.close")",
                        order: {
                            text: "@lang("home.confirm")",
                            value: "order"
                        }
                    },
                })
                    .then((value) => {
                        if (value === "order")
                            ajaxApi({
                                url: `/ajax/chick/orders/request/${$this.data("id")}`,
                                data: {supplier: $this.data("supplier"), },
                                type: "PUT",
                                success: function (res) {
                                    if (res.data.code === 1)
                                        swal(res.data.msg,{
                                            icon:'success',
                                            timer: 3000
                                        })
                                }
                            });
                    });
            });

            function chicksTable(status = null) {
                return dt.table({
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'price', name: 'price'},
                        {data: 'sale_price', name: 'sale_price'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'status', name: 'status'},
                        {data: 'chick', name: 'chick'},
                        {data: 'came', name: 'came'},
                    ],
                    url: "{{ route("ajax.chick.orders.index") }}",
                    data: {status: status},
                    actionColumnWidth : "350px"
                });
            }//end of function

        </script>
    @endpush
@endsection
