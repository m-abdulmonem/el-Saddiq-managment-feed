@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css",false) !!}
        <!--  amsifysuggestags  -->
        <link rel="stylesheet" href="{{ admin_assets('/css/amsify.suggestags.css') }}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
        <!-- tostar -->
        <link rel="stylesheet" href="{{ admin_assets("/css/toastr.min.css") }}">

        <link rel="stylesheet" href="{{ admin_assets("package/bootstrapDatepicker/css/bootstrap-datepicker.min.css") }}">
        <style>
            .sold-products input{
                max-width: 100px!important;
            }
            #final-products-list .sale-price{
                width: 100px;
            }
        </style>
    @endpush
    <form action="{{ route("bills.update",$bill->id) }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="totalQuantity" name="tQuantity">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("products.title")</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body products-list">
                        <div class="row  mb-4">
                            <div class="form-inline">
                                <label for="search" class=" mr-2">@lang("suppliers_bills.search")</label>
                                <input class="form-control" name="search" value="{{ old('search') }}"
                                       placeholder="@lang("suppliers_bills.search")" id="search" data-role="tagsinput">
                            </div>
                            <!-- ./search -->
                            <div class="row" style="margin-left: 16px;margin-right: auto;">
                                <span class=" btn btn-secondary btn-refresh mr-3"><i class="fa fa-redo-alt"></i></span>
                                <span class=" btn btn-primary btn-create"><i class="fa fa-plus"></i></span>
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
                    <div class="card-footer">

                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-6">
                @csrf
                @method("PUT")
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("users.main_info")</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang("home.save")</button>
                        {!! btn_view($perm,"bills",$bill,true) !!}
                        {!! btn_create($perm,"bills") !!}
                        {!! btn_delete($perm,"bills",$bill,"code_number",true,true) !!}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <input type="hidden" name="supplier_id" value="{{ $bill->supplier_id }}">
                                    <label for="supplier_id">@lang("$trans.select_supplier_id")</label>
                                    <select name="supplier_id" disabled  id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror disabled">
                                        <option value="{{ $bill->supplier_id }}" selected>{{ $bill->supplier->name }}</option>
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
                                    <input class="form-control" name="driver" value="{{ old('driver') ?? $bill->driver }}"
                                           placeholder="@lang("$trans.driver")" id="driver"  disabled >
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="is_returned">@lang("$trans.is_returned")</label>
                                    <select name="is_returned" id="is_returned" class="form-control @error('is_returned') is-invalid @enderror" >
                                        {{ select_options(['0','1'],"is_returned",$bill->type,"$trans.is_returned") }}
                                    </select>
                                    @error('is_returned')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="discount">@lang("suppliers/suppliers.discount")</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" disabled id="discount" placeholder="@lang("suppliers/suppliers.discount")" name="discount" value="{{ old("discount")  ?? $bill->discount}}">
                                    @error('discount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="bill_number">@lang("$trans.bill_number")</label>
                                    <input type="number" step="any" class="form-control @error('bill_number') is-invalid @enderror"  disabled id="bill_number" placeholder="@lang("$trans.bill_number")" name="bill_number" value="{{ old("bill_number") ?? $bill->bill_number }}">
                                    @error('bill_number')
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
                                    <textarea class="form-control @error('notes') is-invalid @enderror" disabled id="notes" placeholder="@lang("suppliers_bills.notes")" name="notes" style="min-height: 125px">{{ old("notes") ?? $bill->notes }}</textarea>
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
                <div class="card print">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("$trans.purchases")</h3>
                        <button type="button" class="btn btn-info btn-paid">@lang("$trans.btn_add_paid")</button>
                        <button type="button" class="btn btn-default btn-print"><i class="fa fa-print"></i> @lang("home.print")</button>
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
                            <tbody id="purchasedProductsTable">
                                @foreach($bill->products as $product)
                                    @php($key = "product-".$product->id)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                            <input type="hidden" name="query[]" value="{{ $product->unit->query }}">
                                            {{ $product->name() }}
                                        </td>
                                        <td>
                                            <label>
                                                <select class="stocks form-control"  name="stock[]" data-key="{{ $key }}">
                                                    {{ select_options_db($stocks,null, $bill->stock($product->id)->stock_id ?? 1) }}
                                                </select>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-inline">
                                                <input type='number' step="any" class='quantity form-control' style="width: 100px;"
                                                       data-key="{{ $key }}" name='quantity[]' value="{{ $product->pivot->quantity }}"
                                                       data-price='{{ $product->pivot->price }}' placeholder='@lang("$trans.quantity")'>
                                                {{ $product->unit->name }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input type="number" step="any" class="ton-price form-control" style="width: 100px;" minlength="1" name='prices[]'
                                                       data-weight="{{ $product->weight }}" data-discount="{{ $product->discount }}" data-key="{{ $key }}"
                                                       data-profit-ratio="{{ $product->profit }}" data-query="{{$product->unit->query}}"
                                                       data-value="{{ $product->unit->value }}" data-quantity="{{ $product->pivot->quantity }}" placeholder='@lang("$trans.price")'
                                                       value="{{ $product->pivot->price }}"/>
                                            </label> ج.م
                                        </td>
                                        <td class="purchase-price info-color">{{ currency($product->pivot->piece_price) }}</td>
                                        <td class="discount-price info-color">
                                            {{ $product->discount ? currency( ( $product->pivot->price - $product->discount ) / $bill->count($product->pivot->quantity,$product->id) ) : "-" }}
                                        </td>
                                        <td>
                                            <label>
                                                <input type="number" step="any" class="sale-price form-control" style="width: 100px;" name='sale_price[]'
                                                       data-key="{{ $key }}" placeholder='@lang("$trans.sale_price")' value="{{ $bill->stock($product->id)->sale_price ?? 1 }}"/>
                                            </label> ج.م </td>
                                        <td>
                                            <label class="date">
                                                <input class="expire_at form-control" style="width: 120px;" name='expired_at[]'
                                                       data-key="{{ $key }}" autocomplete="off"
                                                       value="{{ $stock->expired_at ?? 1 }}"
                                                       title='@lang("$trans.expired_at")' />
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </label>
                                        </td>
                                        <td><span data-id="{{ $key }}" class="btn btn-info btn-anther-stock"  >أضافة</span></td>
                                        <td><span class='btn btn-danger btn-product-remove' data-id="{{ $key }}"><i class='fa fa-trash'></i></span> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer" id="final-products-list-footer">
                        <input type="hidden" name="price" class="total-price-input">
                        <div class="row">
                            <h3 class="ml-5">المجموع الكلى : <span class="net primary-color">{{ currency($bill->price) }}</span></h3>
                            <h3 class="ml-5">بعد الخصم : <span class="after-discount primary-color">0</span> <small>ح.م</small></h3>
                            <h3 class="ml-5">المدفوع : <span class="paid primary-color">{{ currency($bill->balances()->sum("paid")) }}</span> <small>ح.م</small></h3>
                            <h3 class="ml-5">المتبقى : <span class="remainingAmount primary-color">{{ currency(($bill->total_price - $bill->discount) - $bill->balances()->sum("paid")) }}</span> <small>ح.م</small></h3>

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
        <script>let stocks = "{{ select_options_db($stocks,'stock') }}";</script>
        <!-- numbers format -->
        <script src="{{ admin_assets("/js/jquery.number.min.js") }}"></script>
        <script src="{{ admin_assets("/js/persianumber.min.js") }}"></script>
        <!-- Select2 -->
        <script src="{{ admin_assets("/js/select2.full.min.js") }}"></script>
        <script src="{{ admin_assets("/js/lang/select2_ar.js") }}"></script>
        <script src="{{ admin_assets("/package/bootstrapDatepicker/js/bootstrap-datepicker.min.js") }}"></script>
        <script src="{{ admin_assets("/package/bootstrapDatepicker/js/locales/bootstrap-datepicker.ar.min.js") }}"></script>

        <script>

            $(".btn-print").click(function () {
                window.open("/print/{{ $bill->id  }}/supplier-bill","_blank")
            });
            $(".btn-close").click(function () {
                $(".btn-paid").removeSpanner()
            });
            $('.date').datepicker({
                language: "ar",
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
                format: "yyyy-mm-dd",
                orientation: "top left"
            });

            $("#productsListTable").table({
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'category', name: 'category'},
                    {data: 'stock', name: 'stock'},
                    {data: 'weight', name: 'weight'},
                    {data: 'purchase', name: 'purchase'},
                ],
                url :"{{ route("ajax.products.index") }}",
                data: {
                    supplier : "{{$bill->supplier_id}}",
                    bill: "{{ $bill->id }}"
                },
                notColumns: [
                    'actions',
                    '#'
                ]
            })
        </script>

        <script src="{{ admin_assets("/js/datatables/bills/purchase.js") }}"></script>


    @endpush
@endsection
