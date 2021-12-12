@extends("site.layouts.index")
@section("content")
    <form action="{{ route("clients.update",$client->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-9">
                @csrf
                @method("PUT")
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">{{ trans("users.main_info") }}</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans("home.save") }}</button>
                        @can("create client")<a href="{{ route("clients.create") }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ trans("home.new") }}</a>@endcan
                        @can("delete client")
                            <button class="btn btn-danger btn-delete " type="button"
                                    data-url="{{ route("clients.destroy",$client->id) }}"
                                    data-name="{{  $client->name }}" data-token="{{ csrf_token() }}"
                                    data-title="{{ trans("home.confirm_delete") }}"
                                    data-text="{{ trans("home.alert_delete",['name'=> $client->name]) }}"
                                    data-back="{{ route("clients.index") }}">
                                <a><i class="fa fa-trash"></i> {{ trans("home.delete") }}</a>
                            </button>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="name">{{ trans("clients.name") }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ trans("clients.name") }}" name="name" value="{{ old("name") ? old("name") : $client->name }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="phone">{{ trans("clients.phone") }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="{{ trans("clients.phone") }}" name="phone" value="{{ old("phone") ? old("phone") : $client->phone }}">
                                    @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="code">{{ trans("users.code") }}</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" placeholder="{{ trans("users.code") }}" name="code" value="{{ old("code") ? old("code") : $client->code }}">
                                    @error('code')
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
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="{{ trans("users.address") }}" name="address" value="{{ old("address") ? old("address") : $client->address }}">
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="discount">{{ trans("clients.discount") }}</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" placeholder="{{ trans("clients.discount") }}" name="discount" value="{{ old("discount") ? old("discount") : $client->discount }}">
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
                                <img src="{{ image($client->picture,true) }}" class="preview-img img " alt="" id="logo" />
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
        <script src="{{ admin_assets("/js/datatables/btn_delete.js") }}"></script>
        <script >btn_delete()</script>
    @endpush
@endsection
