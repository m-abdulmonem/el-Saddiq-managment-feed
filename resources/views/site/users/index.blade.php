@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    @can("create $perm")
                        <a href="{{ route("users.create") }}" class="btn btn-primary "><i class="fa fa-plus"></i> @lang("home.new")</a>
                    @endcan
                    <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="userTable" class="table table-bordered table-striped" data-url="{{ route("users.index") }}">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang("$trans.name")</th>
                                <th>@lang("$trans.phone")</th>
                                <th>@lang("$trans.address")</th>
                                <th>@lang("$trans.salary")</th>
                                <th>@lang("$trans.salary_type")</th>
                                <th>@lang("$trans.balances")</th>
                                <th>@lang("$trans.job")</th>
                                <th>@lang("$trans.status")</th>
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

    @include("site.users.modals.salary")

    @push("js")
        {!! datatable_files() !!}
        <script>
            $("#userTable").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {data: 'salary', name: 'salary'},
                    {data: 'salary_type', name: 'salary_type'},
                    {data: 'balances', name: 'balances'},
                    {data: 'job', name: 'job'},
                    {data: 'status', name: 'status'},
                ],
                actionColumnWidth: "300px",
                url: "{{ route("ajax.users.index") }}",
            });

            $("body").on("click",".btn-create-attendance",function (e) {
                e.preventDefault();
                ajaxApi({
                    url: `/ajax/users/attendance/${$(this).data("id")}`,
                    type: "post",
                    success: function (data) {
                        if (data.code === 1){
                            $("#userTable").DataTable().draw();
                            swal({
                                icon: "success",
                                timer: 2000
                            })
                        }
                    }
                })
            });
            $("body").on("click",".btn-create-departure",function (e) {
                e.preventDefault();
                ajaxApi({
                    url: `/ajax/users/departure/${$(this).data("id")}`,
                    type: "put",
                    success: function (data) {
                        if (data.code === 1){
                            $("#userTable").DataTable().draw();
                            swal({
                                icon: "success",
                                timer: 2000
                            })
                        }
                    }
                })
            });

        </script>
    @endpush
@endsection
