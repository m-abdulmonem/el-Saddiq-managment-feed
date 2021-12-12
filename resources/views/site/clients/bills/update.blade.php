@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css",false) !!}
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
    @endpush

    {!! errors($errors) !!}
    <form action="{{ route("invoices.update",$bill->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" name="search" id="search" class="form-control" placeholder="إبحث">
                                </div>
                            </div>
                            <!-- ./search -->

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="supplier_id">@lang("suppliers/bills.select_supplier_id")</label>
                                    <select name="" id="supplier_id" class="form-control">
                                        <option value="">@lang("suppliers/bills.select_supplier_id")</option>
                                        {!! select_options_db(\App\Models\Supplier\Supplier::all()->pluck("name","id")) !!}
                                    </select>
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="category_id">@lang("products/products.select_category_id")</label>
                                    <select name="" id="category_id" class="form-control">
                                        <option value="">@lang("products/products.select_category_id")</option>
                                        {!! select_options_db(\App\Models\Category::all()->pluck("name","id")) !!}
                                    </select>
                                </div>
                            </div>


                        </div>
                        <!-- ./row -->
                        <table class="table table-bordered table-striped" id="products-list">
                            <thead>
                            <tr>
                                <th>@lang("products/products.product")</th>
                                <th>@lang("products/products.unit_price")</th>
                                <th>@lang("stocks.stock")</th>
                                <th>@lang("products/products.piece_weight")</th>
                                <th>@lang("products/products.quantum")</th>
                                <th>@lang("home.purchase")</th>
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
                @method("PUT")
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("users.main_info")</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang("home.save")</button>
                        @can("create client_bill")<a href="{{ route("invoices.create") }}" class="btn btn-info"><i class="fa fa-plus"></i> @lang("home.new")</a>@endcan
                        @can("delete client_bill")
                            <button class="btn btn-danger btn-delete " type="button"
                                    data-url="{{ route("invoices.destroy",$bill->id) }}"
                                    data-name="{{  $bill->code }}" data-token="{{ csrf_token() }}"
                                    data-title="@lang("home.confirm_delete") }}"
                                    data-text="@lang("home.alert_delete",['name'=> $bill->code])"
                                    data-back="@lang("invoices.index")">
                                <a><i class="fa fa-trash"></i> @lang("home.delete")</a>
                            </button>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">

                                    <label for="client_id">@lang("$trans.select_client")</label>
                                    <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror">
                                        @foreach ( \App\Models\Client\Client::all() as $option)
                                            <option value='{{ $option->id  }}' {{ (($option->id ==0 || $option->id  == old("client_id") || $bill->client_id == $option->id ) ? "selected" :"") }} >{{ ($option->code) }} - {{ $option->name  }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="discount">@lang("suppliers.discount")</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" placeholder="@lang("suppliers.discount")" name="discount" value="{{ old("discount") }}">
                                    @error('discount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="type">@lang("$trans.select_type")</label>
                                    <select name="type" id="type" class="form-control">
                                        {{ select_options(['sale','discarded_sale'],"type",'sale',"clients/bills") }}
                                    </select>
                                    @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status">@lang("$trans.select_status")</label>
                                    <select name="status" id="status" class="form-control">
                                        {{ select_options(['draft','loaded','onWay','delivered','canceled'],"status",$bill->status,"clients/bills") }}
                                    </select>
                                    @error('status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-6">
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
                            <div class="col-6">
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
                                <th>@lang("products/products.name")</th>
                                <th>@lang("stocks.stock")</th>
                                <th>@lang("products/products.piece_weight")</th>
                                <th>@lang("products/products.count")</th>
                                <th>@lang("products/products.total_weight")</th>
                                <th>@lang("products/products.unit_price")</th>
                                <th>@lang("products/products.total_price")</th>
                                <th>@lang("home.actions")</th>
                            </tr>
                            </thead>
                            <tbody id="final-products-list">
                            @php($total_price = 0)
                                @foreach($bill->products()->where("clients_products.deleted_at",null)->get() as $product)
                                    <tr>
                                        <th><input type="hidden" name="products[]" value="{{ $product->id }}">{{ $product->name() }}</th>
                                        <th>
                                            <select name="stock_id[]" class="form-control">
                                                {!! select_options_db($product->stocks()->pluck("name","stocks.id"),null,$product->pivot->stock_id) !!}
                                            </select>
                                        </th>
                                        <th class="weight">{{ num_to_ar($product->weight) }} {{ $product->unit->min }}</th>
                                        <th>
                                            <input type="number" class="form-control form-control-sm quantity"
                                                   name="quantity[]" value="{{ ($product->pivot->quantity) }}" min="1"
                                                   data-weight="{{ $product->weight }}" data-price='{{ $product->pivot->piece_price }}'>
                                        </th>
                                        <th class="kilo">{{ num_to_ar( ($product->pivot->quantity * $product->weight) ) }} {{ $product->unit->min }}</th>
                                        <th><input type="hidden" value="{{ ($product->pivot->piece_price)  }}" name="unitPrice[]"> {{ currency($product->pivot->piece_price)  }}</th>
                                        <th class="price"> <input type="hidden" name="price[]" value="{{ $product->pivot->price }}"> <span>{{ currency($product->pivot->price) }}</span></th>
                                        <th><span class="btn btn-danger btn-remove" data-id="product-{{ $product->id }}"><i class="fa fa-trash"></i></span></th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer" id="final-products-list-footer">
                        <input type="hidden" name="total_price" class="total-price-input" value="{{ $bill->price }}">
                        <input type="hidden" name="total_quantity" class="total-quantity" value="">
                        <div class="row">
                            <div class="row">
                                <h3 class="ml-5">المجموع الكلى : <span class="total-price primary-color" >{{ $bill->price }}</span> <small>ح.م</small></h3>
                                <h3 class="ml-5">بعد الخصم : <span class="after-discount primary-color">0</span> <small>ح.م</small></h3>
                            </div>
                            <div class="row ml-auto">
                                <h3 class="ml-5">المدفوع : <span class="paid primary-color">{{ $bill->balances()->where("type","catch")->sum("paid") }}</span> <small>ح.م</small></h3>
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
    @push("js")
        {!! datatable_files("js",false) !!}
        <!-- numbers format -->
        <script src="{{ admin_assets("/js/jquery.number.min.js") }}"></script>
        <script src="{{ admin_assets("/js/persianumber.min.js") }}"></script>
        <!-- Select2 -->
        <script src="{{ admin_assets("/js/select2.full.min.js") }}"></script>
        <script src="{{ admin_assets("/js/lang/select2_ar.js") }}"></script>
        <!-- My Script -->
        <script src="{{ admin_assets("/js/bills/clients.js") }}"></script>


        <!-- plugging triggers -->
        <script>
            let search = $("#search"),
                supplier = $("#supplier_id"),
                category = $("#category_id");

            $(".total-price").persiaNumber("ar");

            //init dataTables
            dataTables();

            $("#search,#supplier_id,#category_id").on("keyup change",function () {
                $("#products-list").DataTable().destroy();
                dataTables(search.val(),supplier.val(),category.val())
            });


            $("#client_id").select2();

            //initialize select debt
            $("#debt").change(function () {
                $("#postpaid").prop("disabled" , $(this).val() !== "postpaid" );
            });


            //functions

            function dataTables(keyword = null,supplier = null,category = null) {

                $("#products-list").table({
                    columns: [
                        {data:"products",name:"products"},
                        {data:"price",name:"price"},
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
                    data: {keyword: keyword,supplier: supplier,category: category, clientBill: "{{ $bill->id }}",invoice: true},
                    buttons: ""
                })
            }

        </script>
    @endpush
@endsection
