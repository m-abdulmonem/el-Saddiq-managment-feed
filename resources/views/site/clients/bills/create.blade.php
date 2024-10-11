@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css",false) !!}
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ admin_assets("select2.min.css") }}">
    @endpush

    {!! errors($errors) !!}

    <form action="{{ route("invoices.store") }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("products.title")</h3>
                        <button class="btn btn-secondary btn-refresh"  type="button"><a ><i class="fa fa-redo-alt"></i> @lang("home.refresh")</a></button>
                        <!-- ./btn-refresh -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body products-list">
                        <div class="row  mb-4">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="search">@lang("home.search")</label>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="@lang("home.search")">
                                </div>
                            </div>
                            <!-- ./search -->

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="supplier_id">@lang("$trans.select_supplier")</label>
                                    <select name="" id="supplier_id" class="form-control">
                                        <option value="">@lang("$trans.select_supplier")</option>
                                        {!! select_options_db(\App\Models\Supplier\Supplier::all()->pluck("name","id")->toArray()) !!}
                                    </select>
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="category_id">@lang("$trans.select_category")</label>
                                    <select name="" id="category_id" class="form-control">
                                        <option value="">@lang("categories.categories")</option>
                                        {!! select_options_db(\App\Models\Category::all()->pluck("name","id")->toArray()) !!}
                                    </select>
                                </div>
                            </div>


                        </div>
                        <!-- ./row -->
                        <table class="table table-bordered table-striped" id="products-list">
                            <thead>
                                <tr>
                                    <th>@lang("products.product")</th>
                                    <th>@lang("products.unit_price")</th>
                                    <th>@lang("stocks.stock")</th>
                                    <th>@lang("products.piece_weight")</th>
                                    <th>@lang("products.quantum")</th>
                                    <th>@lang("home.actions")</th>
                                </tr>
                            </thead>
                            <tbody id="products-list"></tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-5">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("users.main_info")</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang("home.create")</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="client_id">@lang("clients.select_client")</label>
                                        </div>
                                        <div class="col-6">
                                            <span class="btn btn-sm btn-link btn-add-client"><i class="fa fa-user-plus"></i> @lang("clients.add")</span>
                                        </div>
                                    </div>
                                    <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror"></select>
                                    @error('client_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="discount">@lang("suppliers.discount")</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount"
                                           placeholder="@lang("suppliers.discount")" name="discount" value="{{ old("discount") }}">
                                    @error('discount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="status">@lang("$trans.select_status")</label>
                                    <select name="status" id="status" class="form-control">
                                        {{ select_options(['draft','loaded','onWay','delivered','canceled'],"status",null,"clients/bills") }}
                                    </select>
                                    @error('status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="debt">@lang("suppliers_bills.select_debt")</label>
                                    <select name="debt" id="debt" class="form-control @error('debt') is-invalid @enderror">
                                        {{ select_options(['cash','postpaid'],"debt",null,"suppliers_bills") }}
                                    </select>
                                    @error('debt')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="postpaid">@lang("$trans.paid")</label>
                                    <input type="number" step="any" class="form-control @error('postpaid') is-invalid @enderror"  id="postpaid" placeholder="@lang("$trans.paid")" name="postpaid" value="{{ old("postpaid") }}">
                                    @error('postpaid')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="notes">@lang("suppliers_bills.notes")</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" placeholder="@lang("suppliers_bills.notes")" name="notes" style="min-height: 125px">{{ old("notes") }}</textarea>
                                    @error("notes")
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-12 -->
                        </div>
                        <!-- ./row -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("suppliers_bills.purchases")</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang("products.product")</th>
                                <th>@lang("products.stocks")</th>
                                <th>@lang("products.piece_weight")</th>
                                <th>@lang("products.quantity")</th>
                                <th>@lang("products.total_weight")</th>
                                <th>@lang("products.unit_price")</th>
                                <th>@lang("products.total_price")</th>
                                <th>@lang("home.actions")</th>
                            </tr>
                            </thead>
                            <tbody id="final-products-list"></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer" id="final-products-list-footer">
                        <input type="hidden" name="total_price" class="total-price-input">
                        <input type="hidden" name="total_quantity" class="total-quantity" value="">
                        <div class="row">
                            <div class="row">
                                <h3 class="ml-5">المجموع الكلى : <span class="total-price primary-color">0</span> <small>ح.م</small></h3>
                                <h3 class="ml-5">بعد الخصم : <span class="after-discount primary-color">0</span> <small>ح.م</small></h3>
                            </div>
                            <div class="row ml-auto">
                                <h3 class="ml-5">المدفوع : <span class="paid primary-color">0</span> <small>ح.م</small></h3>
                                <h3 class="ml-5">المتبقى : <span class="residual primary-color">0</span> <small>ح.م</small></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </form>
    @include("site.clients.modals.client")
    @push("js")
        {!! datatable_files("js",false) !!}
        <!-- numbers format -->
        <script src="{{ admin_assets("jquery.number.min.js") }}"></script>
        <script src="{{ admin_assets("persianumber.min.js") }}"></script>
        <!-- Select2 -->
        <script src="{{ admin_assets("select2.full.min.js") }}"></script>
        <script src="{{ admin_assets("lang/select2_ar.js") }}"></script>

        <!-- plugging triggers -->
        <script>
            let search = $("#search"),
                supplier = $("#supplier_id"),
                category = $("#category_id"),
                clients  = $("#client_id");
            //init dataTables
            dataTables();

            $("#search,#supplier_id,#category_id").on("keyup change",function () {
                $("#products-list").DataTable().destroy();
                dataTables(search.val(),supplier.val(),category.val())
            });



            clients.select2({
                placeholder: "{{ trans("$trans.select_client") }}",
                ajax: {
                    url: '{{ route("ajax.clients.names") }}',
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data[0]
                        }
                    }
                }
            });


            $(".btn-add-client").click(function () {
                $("#client").modal("show");
                // clients.empty();
            });

            //initialize select debt
            $("#debt").change(function () {
                if ($(this).val() === "cash")
                    $(".paid").text(  $(".total-price").text() );

                $("#postpaid").prop("disabled"  ,$(this).val() !== "postpaid" );
            });

            //functions

            function dataTables(keyword = null,supplier = null,category = null) {

                $("#products-list").table({
                    columns: [
                        {data:"products",name:"products"},
                        {data:"sale_price",name:"sale_price"},
                        {data:"stock",name:"stock"},
                        {data:"weight",name:"weight"},
                        {data:"quantity",name:"quantity"},
                        {data:"purchase",name:"purchase"},
                    ],
                    notColumns: [
                        '#',
                        'actions'
                    ],
                    "searching": false,
                    actionColumnWidth : "60px",
                    url:"{{ route("ajax.products.index") }}",
                    data: {keyword: keyword,supplier: supplier,category: category,invoice: true},
                    buttons: ""
                })
            }

        </script>
        <!-- My Script -->
        <script src="{{ admin_assets("bills/clients.js") }}"></script>
    @endpush
@endsection
