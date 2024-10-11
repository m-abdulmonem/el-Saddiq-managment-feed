@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
        <!--  amsifysuggestags  -->
        <link rel="stylesheet" href="{{ admin_assets('amsify.suggestags.css') }}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ admin_assets("select2.min.css") }}">

        <link rel="stylesheet" href="{{ admin_assets(path: "bootstrapDatepicker/css/bootstrap-datepicker.min.css",fullPath: true) }}">
    @endpush

{{--    {!! errors($errors) !!}--}}

    <form action="{{ route("bills.store") }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("products/products.title")</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body products-list">
                        <div class="row  mb-4">
                            <div class="form-inline">
                                <label for="search" class=" mr-2">@lang("$trans.search")</label>
                                <input class="form-control" name="search" value="{{ old('search') }}"
                                       placeholder="@lang("$trans.search")" id="search" data-role="tagsinput">
                            </div>
                            <!-- ./search -->
                            <div class="row" style="margin-left: 16px;margin-right: auto;">
                                <span class=" btn btn-secondary btn-refresh mr-3" title="@lang("home.refresh")"><i class="fa fa-redo-alt"></i></span>
                                <span class=" btn btn-info btn-create" title="@lang("products.create")"><i class="fa fa-plus"></i></span>
                                <!-- ./btn-refresh -->
                            </div>
                        </div>
                        <!-- ./row -->
                        <table id="productsListTable" class="table table-bordered table-striped" >
                            <thead>
                                <tr>
                                    <th>@lang("products/products.product")</th>
                                    <th>@lang("products/products.category")</th>
                                    <th>@lang("stocks.stock")</th>
                                    <th>@lang("products/products.product_weight")</th>
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
            <div class="col-6">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("users/users.main_info")</h3>
                        <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> @lang("home.create")</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="supplier_id">@lang("$trans.select_supplier_id")</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                        {{ select_options_db(\App\Models\Supplier\Supplier::pluck("name","id"),"supplier_id") }}
                                    </select>
                                    @error('supplier_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="driver">@lang("$trans.driver")</label>
                                    <input class="form-control" name="driver" value="{{ old('driver') }}"
                                           placeholder="@lang("$trans.driver")" id="driver" data-role="tagsinput">
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="discount">@lang("suppliers/suppliers.discount")</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount"
                                           placeholder="@lang("suppliers/suppliers.discount")" name="discount" value="{{ old("discount") }}">
                                    @error('discount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="number">@lang("$trans.bill_number")</label>
                                    <input type="number" step="any" class="form-control @error('number') is-invalid @enderror" id="number"
                                           placeholder="@lang("$trans.bill_number")" name="number" value="{{ old("number") }}">
                                    @error('number')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="is_cash">@lang("$trans.select_debt")</label>
                                    <select name="is_cash" id="is_cash" class="form-control @error('is_cash') is-invalid @enderror">
                                        {{ select_options([true,false],"is_cash",null,$trans) }}
                                    </select>
                                    @error('is_cash')
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
                                    <label for="mashal">@lang("$trans.mashal")</label>
                                    <input type="number" step="any" class="form-control @error('mashal') is-invalid @enderror" id="mashal"
                                           placeholder="@lang("$trans.mashal")" name="mashal" value="{{ old("mashal") }}">
                                    @error('mashal')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="tip">@lang("$trans.tips")</label>
                                    <input type="number" step="any" class="form-control @error('tip') is-invalid @enderror" id="tip"
                                           placeholder="@lang("$trans.tips")" name="tip" value="{{ old("tip") }}">
                                    @error('mastiphal')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="postpaid">@lang("balances.paid")</label>
                                    <input type="number" step="any" class="form-control @error('postpaid') is-invalid @enderror"  id="postpaid"
                                           placeholder="@lang("balances.paid")" name="postpaid" value="{{ old("postpaid") }}">
                                    @error('postpaid')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="notes">@lang("$trans.notes")</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                                              placeholder="@lang("$trans.notes")" name="notes" style="min-height: 125px">{{ old("notes") }}</textarea>
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
                        <h3 class="card-title float-left">@lang("$trans.purchases")</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang("products/products.product")</th>
                                <th>@lang("stocks.stock") </th>
                                <th>@lang("$trans.quantity") </th>
                                <th>@lang("$trans.price") </th>
                                <th>@lang("products/products.purchase_price") </th>
                                <th>@lang("$trans.price_after_discount") </th>
                                <th>@lang("products/products.sale_price") </th>
                                <th>@lang("products/products.expired_at")</th>
                                <th>@lang("$trans.anther_stock") </th>
                                <th>@lang("home.actions")</th>
                            </tr>
                            </thead>
                            <tbody id="purchasedProductsTable"></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer" id="final-products-list-footer">
                        <input type="hidden" name="price" class="total-price-input">
                        <input type="hidden" name="total_quantity" class="total-quantity-input">
                        <ul class="row list-unstyled font-weight-bold" style="font-size: 21px">
                            <li class="pl-2 w-25">@lang("suppliers/bills.total_price") : <span class="net info-color">0 <small>ح.م</small></span> </li>
                            <li class="pl-2 w-25">@lang("balances.net") : <span class="after-discount  info-color">0 <small>ح.م</small></span></li>
                            <li class="pl-2 w-25">@lang("balances.paid") : <span class="paid info-color">0 <small>ح.م</small></span> </li>
                            <li class="pl-2 w-25">@lang("balances.remaining") : <span class="remainingAmount info-color">0 <small>ح.م</small></span></li>
                        </ul>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </form>
    @push("js")
        {!! datatable_files("js",false) !!}
        <script>let stocks = "{{ select_options_db(\App\Models\Stock::pluck("name","id"),'stock') }}";</script>
        <!-- numbers format -->
        <script src="{{ admin_assets("jquery.number.min.js") }}"></script>
        <!--  amsifysuggestags  -->
        <script src="{{ admin_assets('jquery.amsify.suggestags.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ admin_assets("select2.full.min.js") }}"></script>
        <script src="{{ admin_assets("lang/select2_ar.js") }}"></script>
        <!-- My Script -->

        <script src="{{ admin_assets(path: "bootstrapDatepicker/js/bootstrap-datepicker.min.js",fullPath: true) }}"></script>
        <script src="{{ admin_assets(path: "bootstrapDatepicker/locales/bootstrap-datepicker.ar.min.js",fullPath: true) }}"></script>


        <!-- plugging triggers -->
        <script>

            //initialize amsifySuggestags  plugin
            $('#driver').amsifySuggestags({
                suggestions: ("{{ array_extract(\App\Models\Supplier\SupplierBill::all(),"driver") }}").split(","),
                whiteList: true
            });

            $('.date').datepicker({
                language: "ar",
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
                format: "yyyy-mm-dd",
                orientation: "top left"
            });
            /**
             * initialize select  plugin
             * @type {jQuery}
             */
            supplier =$("#supplier_id").select2({
                dir:"rtl",
                language: "ar"
            }).on("change", function (e) {
                e.preventDefault();
                finalProductList.find("tr").remove();
                $("#productsListTable").DataTable().destroy();
                productListTable($(this).val())
            });

            productListTable();

            function productListTable(supplier = 1) {
                $("#productsListTable").table({
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'category', name: 'category'},
                        {data: 'stock', name: 'stock'},
                        {data: 'weight', name: 'weight'},
                        {data: 'purchase', name: 'purchase'},
                    ],
                    url :"{{ route("ajax.products.index") }}",
                    data: {supplier : supplier},
                    notColumns: [
                        'actions',
                        '#'
                    ]
                })
            }
        </script>

        <script src="{{ admin_assets("datatables/bills/purchase.js") }}"></script>
    @endpush
@endsection
