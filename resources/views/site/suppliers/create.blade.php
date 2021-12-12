@extends("site.layouts.index")
@section("content")
    @push("css")
        <link rel="stylesheet" href="{{ admin_assets("package/JqueryFileUpload/jquery.fileupload.css") }}">
    @endpush
    <form action="{{ route("$trans.store") }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-9">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("users.main_info")</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang("home.create")</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="name">@lang("$trans.name")</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="@lang("$trans.name")" name="name" value="{{ old("name")  }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone">@lang("$trans.phone")</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="@lang("$trans.phone")" name="phone" value="{{ old("phone") }}">
                                    @error('phone')
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
                                    <label for="discount">@lang("$trans.discount")</label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" placeholder="@lang("$trans.discount")" name="discount" value="{{ old("discount") }}">
                                    @error('discount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="my_code">@lang("$trans.my_code")</label>
                                    <input type="text" class="form-control @error('my_code') is-invalid @enderror" id="my_code" placeholder="@lang("$trans.my_code")" name="my_code" value="{{ old("my_code") }}">
                                    @error('my_code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="opening_balance">@lang("balances.opening_balances")</label>
                                    <input type="text" class="form-control @error('opening_balance') is-invalid @enderror" id="opening_balance"
                                           placeholder="@lang("balances.opening_balances")" name="opening_balance">
                                    @error('opening_balance')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group ">
                                    <label for="address">@lang("$trans.address")</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="@lang("$trans.address")" name="address" value="{{ old("address") }}">
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
                        <h3 class="title-header">@lang("$trans.logo") </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="w-100">
                                <img src="{{ admin_assets("img/MAAdminLogo.png") }}" class="preview-img img " alt="" id="logo" />
                                <div class="btn btn-default btn-file">@lang("$trans.logo")
                                    <i class="fas fa-paperclip"></i>
                                    <input type="file" value="{{ old('picture') }}" class="upload" id="inputLogo" name="logo[]" multiple data-url="/dsuih">
                                </div>
                                <div id="files_list"></div>
                                <p id="loading"></p>
                                <input type="hidden" name="file_ids" id="file_ids" value="">
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
        <script src="{{ admin_assets("package/JqueryFileUpload/jquery.fileupload-ui.js") }}"></script>
        <script src="{{ admin_assets("package/JqueryFileUpload/jquery.fileupload.js") }}"></script>
        <script>
            $(function () {
                $("#inputLogo").fileupload({
                    dataType: 'json',
                    add: function (e, data) {
                        $('#loading').text('Uploading...');
                        data.submit();
                    },
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
                            if ($('#file_ids').val() != '') {
                                $('#file_ids').val($('#file_ids').val() + ',');
                            }
                            $('#file_ids').val($('#file_ids').val() + file.fileID);
                        });
                        $('#loading').text('');
                    }
                });
            })
        </script>
    @endpush
@endsection
