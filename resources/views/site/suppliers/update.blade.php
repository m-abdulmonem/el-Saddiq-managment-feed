@extends("site.layouts.index")
@section("content")
    <form action="{{ route("$trans.update",$supplier->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-9">
                @csrf
                @method("PUT")
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">{{ trans("users.main_info") }}</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans("home.save") }}</button>
                        @can("create supplier")<a href="{{ route("$trans.create") }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ trans("home.new") }}</a>@endcan
                        @can("delete supplier")
                            <button class="btn btn-danger btn-delete " type="button"
                                    data-url="{{ route("$trans.destroy",$supplier->id) }}"
                                    data-name="{{  $supplier->name }}" data-token="{{ csrf_token() }}"
                                    data-title="{{ trans("home.confirm_delete") }}"
                                    data-text="{{ trans("home.alert_delete",['name'=> $supplier->name]) }}"
                                    data-back="{{ route("$trans.index") }}">
                                <a><i class="fa fa-trash"></i> {{ trans("home.delete") }}</a>
                            </button>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="name">{{ trans("$trans.name") }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ trans("$trans.name") }}" name="name" value="{{ old("name") ?? $supplier->name }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone">{{ trans("$trans.phone") }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="{{ trans("$trans.phone") }}" name="phone" value="{{ old("phone") ?? $supplier->phone }}">
                                    @error('phone')
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
                                    <label for="discount">{{ trans("$trans.discount") }}</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" placeholder="{{ trans("$trans.discount") }}" name="discount" value="{{ old("discount") ?? $supplier->discount }}">
                                    @error('discount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="my_code">{{ trans("$trans.my_code") }}</label>
                                    <input type="text" class="form-control @error('my_code') is-invalid @enderror" id="my_code" placeholder="{{ trans("$trans.my_code") }}" name="my_code" value="{{ old("my_code") ?? $supplier->my_code }}">
                                    @error('my_code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group ">
                                    <label for="address">{{ trans("$trans.address") }}</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="{{ trans("$trans.address") }}" name="address" value="{{ old("address") ?? $supplier->address }}">
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

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
                        <h3 class="title-header">{{ trans("$trans.logo") }} </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="w-100">
                                <img src="{{ image($supplier->logo,true) }}" class="preview-img img " alt="" id="logo" />
                                <div class="btn btn-default btn-file">{{ trans("$trans.logo") }}
                                    <i class="fas fa-paperclip"></i>
                                    <input type="file" value="{{ old('picture') }}" class="upload" name="logo">
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
        <script src="{{ admin_assets("datatables/btn_delete.js") }}"></script>
        <script >btn_delete()</script>
    @endpush
@endsection
