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
                                    {!! select_options([null,1,0],null,"false",$trans) !!}
                                </select>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-6">
                            @can("create client")
                                <button class="btn btn-primary btn-add" data-toggle="modal" data-target="#chickBooking">
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
                    <table id="ma-admin-datatable" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("clients/clients.name")</th>
                            <th>@lang("clients/clients.phone")</th>
                            <th>@lang("chicks/chicks.name")</th>
                            <th>@lang("chicks/orders.quantity")</th>
                            <th>@lang("$trans.deposit")</th>
                            <th>@lang("chicks/orders.status")</th>
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

    @push("js") {!! datatable_files() !!} @endpush

    @include("site.chicks.booking.modals.index")
    @include("site.chicks.booking.modals.delivered")
    @include("site.chicks.booking.modals.transactions")


    @push("js")
        <script>
            let dt = $("#ma-admin-datatable"),
                status = $("#select_status");

            chicksTable( status.val() );

            status.change(function () {
                dt.DataTable().destroy();
                chicksTable($(this).val())
            });
          
            $("body").on("click",".btn-resend",function (e) {
                e.preventDefault();

                swal({
                  title: "@lang("$trans.resend_sms")",
                  text: "@lang("$trans.resend_sms_text")",
                  icon: "info",
                  buttons: true,
                }).then((resendSms) => {
                      if (resendSms)
                          ajaxApi({
                              url : `/ajax/chick/booking/resend/${ $(this).data("id") }`,
                              success: function (data) {
                                  if (data.code === 1)
                                      swal(data.text,{
                                          icon: "success",
                                          timer: 3000
                                      })
                              }
                          });
                });

            });
          

            function chicksTable(status = null) {
                return dt.table({

                    columns: [
                        {data: 'client', name: 'client'},
                        {data: 'phone', name: 'phone'},
                        {data: 'chick', name: 'chick'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'deposit', name: 'deposit'},
                        {data: 'status', name: 'status'},
                    ],
                    url: "{{ route("ajax.booking.index") }}",
                    data: {status: status},
                    actionColumnWidth : "300px"
                });
            }//end of function

        </script>
    @endpush
@endsection
