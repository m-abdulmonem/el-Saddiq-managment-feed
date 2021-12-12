@extends("site.layouts.index")
@section("content")

    <div class="row">
        <div class="col-12">

            <form action="{{ route("roles.store") }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans("home.create") }}</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="name">{{ trans("categories.name") }}</label>
                            <input type="text" class="form-control" id="name" placeholder="{{ trans("categories.name") }}" name="name" value="{{ old("name") }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name_ar">{{ trans("categories.name_ar") }}</label>
                            <input type="text" class="form-control" id="name_ar" placeholder="{{ trans("categories.name_ar") }}" name="name_ar" value="{{ old("name_ar") }}">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


@endsection
