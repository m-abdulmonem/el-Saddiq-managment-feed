@extends("site.layouts.index")
@section("content")
    <form action="{{ route("clients.store") }}" method="POST" enctype="multipart/form-data">
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
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="name">{{ trans("$trans.name") }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ trans("$trans.name") }}" name="name" value="{{ old("name") }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="phone">{{ trans("$trans.phone") }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="{{ trans("$trans.phone") }}" name="phone" value="{{ old("phone") }}">
                                    @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="trader">{{ trans("$trans.trader") }}</label>
                                    <select class="form-control  @error('trader') is-invalid @enderror" name="trader" id="trader">
                                        {{ select_options(['false','true'],"trader",null,"$trans") }}
                                    </select>
                                    @error('trader')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group ">
                                    <label for="address">{{ trans("users.address") }}</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="{{ trans("users.address") }}" name="address" value="{{ old("address") }}">
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="discount">{{ trans("$trans.discount") }}</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" disabled placeholder="{{ trans("$trans.discount") }}" name="discount" value="{{ old("discount") }}">
                                    @error('discount')
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
                        <h3 class="title-header">{{ trans("users.picture") }} </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="w-100">
                                <img src="{{ admin_assets("img/MAAdminLogo.png") }}" class="preview-img img " alt="" id="logo" />
                                <div class="btn btn-default btn-file">{{ trans("users.picture") }}
                                    <i class="fas fa-paperclip"></i>
                                    <input type="file" value="{{ old('picture') }}" class="upload" name="picture">
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
        <script>
            $("#trader").change(function () {
                $("#discount").prop("disabled",($(this).val() !== "true"))
            })
        </script>
    @endpush
@endsection
