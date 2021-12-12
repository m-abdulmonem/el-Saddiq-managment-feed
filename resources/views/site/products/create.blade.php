@extends("site.layouts.index")
@section("content")
    @push("css")
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ admin_assets("/css/select2.min.css") }}">
    @endpush
    <form action="{{ route("products.store") }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-9">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">{{ trans("users.main_info") }}</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans("home.create") }}</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group ">
                                    <label for="name">{{ trans("products.name") }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ trans("products.name") }}" name="name" value="{{ old("name") }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group ">
                                    @php $units = \App\Models\Unit::all()->pluck("name","id") @endphp
                                    <label for="unit_id">{{ trans("products.select_unit_id") }}</label>
                                    <select name="unit_id" id="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                                        {{ select_options_db($units,"unit_id") }}
                                    </select>
                                    <div class="alert alert-danger"></div>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->

                        <div class="row">

                            <div class="col-4">
                                <div class="form-group ">
                                    @php $suppliers = \App\Models\Supplier\Supplier::all()->pluck("name","id") @endphp
                                    <label for="supplier_id">{{ trans("products.select_supplier_id") }}</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                                        {{ select_options_db($suppliers,"supplier_id") }}
                                    </select>
                                    @error('supplier_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group ">
                                    @php $category = \App\Models\Category::all()->pluck("name","id") @endphp
                                    <label for="category_id">{{ trans("products.select_category_id") }}</label>
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        {{ select_options_db($category,"category_id") }}
                                    </select>
                                    @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4-->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="code">{{ trans("products.code") }}</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" placeholder="{{ trans("products.code") }}" name="code" value="{{ old("code") }}">
                                    @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="details">{{ trans("products.notes") }}</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" placeholder="{{ trans("products.notes") }}" name="notes" style="min-height: 125px">{{ old("notes") }}</textarea>
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
                        <h3 class="title-header">{{ trans("products.image") }} </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="w-100">
                                <img src="{{ admin_assets("img/MAAdminLogo.png") }}" class="preview-img img " alt="" id="logo" />
                                <div class="btn btn-default btn-file">{{ trans("products.image") }}
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
    </form>
    <!-- /.row -->
    @push("js")
        <script src="{{ admin_assets("/js/select2.full.min.js") }}"></script>
        <script src="{{ admin_assets("/js/lang/select2_ar.js") }}"></script>
        <!-- Select2 -->
        <script>

            //initialize select  plugin
            $("#supplier_id,#category_id").select2({
                dir:"rtl",
                language: "ar"
            });

        </script>
    @endpush

@endsection
