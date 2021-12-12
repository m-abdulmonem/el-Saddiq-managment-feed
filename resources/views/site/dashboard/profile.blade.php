@extends("site.layouts.index")
@section("content")

    @push("css")
        <link rel="stylesheet" href="{{ admin_assets('/css/amsify.suggestags.css') }}">
    @endpush
    <form action="{{ url("profile/edit") }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-9">
                @csrf
                @method("PUT")
                <div class="card">
                    <div class="card-header">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans("home.save") }}</button>
                        @if(profile("id") !== 1)
                            <div class="btn btn-danger btn-delete float-right"
                                 data-url="{{ route("users.destroy",profile("id")) }}"
                                 data-name="{{ profile("username") }}" data-token="{{ csrf_token() }}"><i class="fa fa-trash"></i> {{ trans("home.delete") }}</div>
                        @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="d-flex">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="name">{{ trans("users.name") }}</label>
                                    <input type="text" class="form-control" id="name" placeholder="{{ trans("users.name") }}" name="name" value="{{ old("name") ? old("name") : profile("name") }}">
                                </div>
                            </div>
                            <!-- ./col-6 -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="username">{{ trans("users.username") }}</label>
                                    <input type="text" class="form-control" id="username" placeholder="{{ trans("users.username") }}" name="username" value="{{ old("username") ? old("username") : profile("username") }}">
                                </div>
                            </div>
                            <!-- ./col-6 -->
                        </div>
                        <!-- ./d-flex -->
                        <div class="d-flex">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="email">{{ trans("users.email") }}</label>
                                    <input type="text" class="form-control" id="email" placeholder="{{ trans("users.email") }}" name="email" value="{{ old("email") ? old("email") : profile("email") }}">
                                </div>
                            </div>
                            <!-- ./col-6 -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone">{{ trans("users.phone") }}</label>
                                    <input type="text" class="form-control" id="phone" placeholder="{{ trans("users.phone") }}" name="phone" value="{{ old("phone") ? old("phone") : profile("phone") }}">
                                </div>
                            </div>
                            <!-- ./col-6 -->

                        </div>
                        <!-- ./col-12 -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="permissions">{{ trans("roles.permission_title") }}</label>
                                <input class="form-control"  value="{{ old('permissions') }}"
                                       placeholder="{{ trans("roles.permission_title") }}" id="permissions" data-role="tagsinput" disabled>
                            </div>
                        </div>
                        <!-- ./col-12 -->


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
                            <div class="form-group">
                                <img src="{{ image(profile("picture"),true) }}" class="preview-img img" alt="" id="logo"  />
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
    <div class="col-9">
        <!-- /.row -->
        <div class="card">
            <form action="{{ url("profile/password/edit") }}" method="post">
                @csrf
                @method("PUT")
                <div class="card-header">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans("home.save") }}</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="d-flex">
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="password">{{ trans("users.password") }}</label>
                                <input type="password" class="form-control" id="password" placeholder="{{ trans("users.password") }}"
                                       name="password" value="{{ old("password")  }}">
                            </div>
                        </div>
                        <!-- ./col-6 -->
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="password_confirmation">{{ trans("users.password_confirmation") }}</label>
                                <input type="password" class="form-control" id="password_confirmation" placeholder="{{ trans("users.password_confirmation") }}"
                                       name="password_confirmation" value="{{ old("password_confirmation") }}">
                            </div>
                        </div>
                        <!-- ./col-6 -->
                    </div>
                </div>
                <!-- /.card-body -->
            </form>
        </div>
    </div>

    @push("js")
        <script src="{{ admin_assets('/js/jquery.amsify.suggestags.js') }}"></script>

    @endpush

@endsection
