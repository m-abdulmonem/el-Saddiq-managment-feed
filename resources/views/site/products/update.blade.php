@extends("site.layouts.index")
@section("content")
    @push("css")
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
    @endpush
        <form action="{{ route("products.update",$product->id) }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    @csrf
                    @method("PUT")
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title float-left">@lang("$trans.main_info")</h3>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang("home.save")</button>
                            @can("create product")<a href="{{ route("products.create") }}" class="btn btn-info"><i class="fa fa-plus"></i> @lang("home.new")</a>@endcan
                            @can("delete product")
                                <button class="btn btn-danger btn-delete " type="button"
                                        data-url="{{ route("products.destroy",$product->id) }}"
                                        data-name="{{  $product->name }}" data-token="{{ csrf_token() }}"
                                        data-title="@lang("home.confirm_delete")"
                                        data-text="@lang("home.alert_delete",['name'=> $product->name])"
                                        data-back="{{ route("products.index") }}">
                                    <a><i class="fa fa-trash"></i> @lang("home.delete")</a>
                                </button>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group ">
                                        <label for="name">@lang("$trans.name")</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="@lang("$trans.name")" name="name" value="{{ old("name") ? old("name") : $product->name }}">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- ./row -->

                            <div class="row">

                                <div class="col-4">
                                    <div class="form-group ">
                                        @php $suppliers = \App\Models\Supplier\Supplier::all()->pluck("name","id") @endphp
                                        <label for="supplier_id">@lang("$trans.select_supplier_id")</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                            {{ select_options_db($suppliers,"supplier_id",$product->supplier_id) }}
                                        </select>
                                        @error('supplier_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- ./col-4 -->
                                <div class="col-4">
                                    <div class="form-group ">
                                        @php use App\Models\Category;$category = Category::all()->pluck("name","id") @endphp
                                        <label for="category_id">@lang("$trans.select_category_id")</label>
                                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                            {{ select_options_db($category,"category_id",$product->category_id) }}
                                        </select>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- ./col-4-->
                            </div>
                            <!-- ./row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="details">@lang("$trans.notes")</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" placeholder="@lang("$trans.notes")" name="notes" style="min-height: 125px">{{ old("notes") ? old("notes") : $product->notes }}</textarea>
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
                <div class="col-3">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="title-header">@lang("$trans.image") </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="w-100">
                                    <img src="{{ image($product->image,true) }}" class="preview-img img " alt="" id="logo" />
                                    <div class="btn btn-default btn-file">@lang("$trans.image")
                                        <i class="fas fa-paperclip"></i>
                                        <input type="file" value="{{ old('picture') }}" class="upload" name="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </form>

    @push("js")
        <script src="{{ admin_assets("/js/select2.full.min.js") }}"></script>
        <script src="{{ admin_assets("/js/lang/select2_ar.js") }}" ></script>
        <!-- Select2 -->
{{--        <script src="{{ admin_assets("/js/datatables/btn_delete.js") }}" async></script>--}}
        <script>
            //initialize select  plugin
            $("#supplier_id,#category_id").select2({
                dir:"rtl",
                language: "ar"
            });

            {{--$("#ton_price").change(function () {--}}
            {{--    let ton = $(this).val().replace(",",""),--}}
            {{--        old_ton = parseInt("{{ ($stock ?? '' ? $stock ?? ''->ton_price: null) }}");--}}
            {{--    $("#sale_price").val(--}}
            {{--        ton / parseInt("{{ ($stock ?? '' ? piece_count($stock ?? ''->piece_weight): null) }}")--}}
            {{--        //ton_price / piece_count--}}
            {{--    );--}}
            {{--    $("#difference_value").val(--}}
            {{--        ton-old_ton--}}
            {{--    );--}}


            {{--    $('select[name="status"]').find('option[value="' + (ton < old_ton ? "cheap" : "hyperbole") + '"]').attr('selected', true);--}}

            {{--});--}}
            //initialize money format
            // $("#ton_price,#sale_price,#difference_value").simpleMoneyFormat()
        </script>
    @endpush
    {{--    {{ dd(old("permissions")) }}--}}

@endsection
