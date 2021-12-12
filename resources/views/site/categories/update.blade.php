@extends("site.layouts.index")
@section("content")

    <div class="row">
        <div class="col-12">
            <form action="{{ route("categories.update",$category->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("put")
                <div class="row">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="btn-card-group">
                                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> {{ trans("home.save") }}</button>
                                    @can("create category")<a href="{{ route("categories.create") }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ trans("home.new") }}</a>@endcan
                                </div>
                                @can("delete category")
                                    <button class="btn btn-danger btn-delete " type="button"
                                            data-url="{{ route("categories.destroy",$category->id) }}"
                                            data-name="{{  $category->name }}" data-token="{{ csrf_token() }}"
                                            data-title="{{ trans("home.confirm_delete") }}"
                                            data-text="{{ trans("home.alert_delete",['name'=> $category->name]) }}"
                                            data-back="{{ route("categories.index") }}">
                                        <a><i class="fa fa-trash"></i> {{ trans("home.delete") }}</a>
                                    </button>
                                @endcan
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="form-group-group mb-3">
                                        <label for="name">{{ trans("categories.name") }}</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ trans("categories.name") }}" name="name" value="{{ old("name") ? old("name") : $category->name }}">
                                        @error("name")
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- ./col-12 -->
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="details">{{ trans("categories.details") }}</label>
                                        <textarea class="form-control @error('details') is-invalid @enderror" id="details" placeholder="{{ trans("categories.details") }}" name="details" style="min-height: 125px">{{ old("details") ? old("details") : $category->details }}</textarea>
                                        @error("details")
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- ./col-12 -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- ./col-9 -->
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ trans("home.upload_image") }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <!-- ./col-12 -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <img src="{{ image($category->image,true) }}" class="preview-img img w-100" alt="" id="logo" />
                                        <div class="btn btn-default btn-file">{{ trans("home.chose_image") }}
                                            <i class="fas fa-paperclip"></i>
                                            <input type="file" value="{{ old('content') }}" class="btn btn-primary upload " name="image">
                                        </div>
                                    </div>
                                </div>
                                <!-- ./col-12 -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- ./col-3 -->
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    @push("js")
        <script src="{{ admin_assets("/js/datatables/btn_delete.js") }}"></script>
        <script> btn_delete() </script>
    @endpush
@endsection
