
@extends("site.layouts.index")
@section("content")
    @push("css")
        <link rel="stylesheet" href="{{ admin_assets('/css/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ admin_assets('/css/jquery.datetimepicker.css') }}">

        <!-- iOS Style: Rounded -->
        <style>
            .checkbox input:checked + span:before {
                background-color:#a5dc86 !important;
            }
            .checkbox span:before  {
                background: #e74c3cd1 !important;
            }
        </style>
    @endpush
    <div class="row">
        <div class="col-12">

            @if(user_can("read setting"))
                <div class="card">
                    <form action="{{ route("settings.update") }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="card-header">
                            <h3 class="card-title float-left">@lang('users/users.main_info')</h3>
                            <button class="btn btn-info float-right" type="submit">@lang("home.save")</button>
                            <div class="check-box float-right d-flex align-items-baseline" style="margin-right: 30px">
                                <label class="checkbox">
                                    <input type="checkbox" {{ settings('status') == 'open' ? "checked value='close' " : "unchecked value='open'" }} name="status">
                                    <span><small class="checkbox-title">@lang("settings.status")</small></span>
                                </label>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="site_name_ar">@lang("settings.name_ar")</label>
                                        <input class="form-control" name="site_name_ar" value="{{ old('name_ar') ? old('name_ar') : settings('name_ar') }}"
                                               placeholder="@lang("settings.name_ar")" id="site_name_ar">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="site_name_en">@lang("settings.name_en")</label>
                                        <input class="form-control" name="site_name_en" value="{{ old('name_ar') ? old('name_en') : settings('name_en') }}"
                                               placeholder="@lang("settings.name_en")" id="site_name_en">
                                    </div>
                                </div>
                            </div>
                            <!-- ./d-flex -->
                            <div class="d-flex">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="email">@lang("settings.email")</label>
                                        <input class="form-control" name="email" value="{{ old('email') ? old('email') : settings('email') }}"
                                               placeholder="@lang("settings.email")" id="email" type="email">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="phone">@lang("settings.phone")</label>
                                        <input class="form-control" name="phone" value="{{ old('phone') ? old('phone') : settings('phone') }}"
                                               placeholder="@lang("settings.phone")" id="phone" type="tel" minlength="11" >
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="paginate">@lang("settings.paginate")</label>
                                        <input class="form-control" name="paginate" value="{{ old('paginate') ? old('paginate') : settings('paginate') }}"
                                               placeholder="@lang("settings.paginate")" id="paginate" type="number">
                                    </div>
                                </div>
                            </div>
                            <!-- ./d-flex -->


                            <div class="col-12">
                                <div class="form-group">
                                    <label for="keywords">@lang("settings.keywords")</label>
                                    <input class="form-control" name="keywords" value="{{ old('keywords') ? old('keywords') : settings('keywords') }}"
                                           placeholder="@lang("settings.keywords")" id="keywords" data-role="tagsinput">
                                </div>
                            </div>
                            <!-- ./col-12 -->


                            <div class="col-md-12" style="display: flex; flex-wrap: wrap">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img src="{{ image(settings('logo'),true) }}" class="preview-img img" alt="" id="logo" {{ settings('logo') ? 'style=display:block' : null }} />
                                        <div class="btn btn-default btn-file">@lang("settings.logo")
                                            <i class="fas fa-paperclip"></i>
                                            <input type="file" value="{{ old('content') }}" class="upload" name="logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img src="{{ image(settings('icon'),true) }}" class="preview-img img" alt="" id="icon" {{ settings('icon') ? 'style=display:block' : null }} />
                                        <div class="btn btn-default btn-file">@lang("settings.icon")
                                            <i class="fas fa-paperclip"></i>
                                            <input type="file" value="{{ old('content') }}" class="upload" name="icon">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ./col-12 -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">@lang("settings.description")</label>
                                    <textarea class="form-control" name="description" placeholder="@lang("settings.description")"
                                              id="description" style="min-height: 270px">{{ old('description') ? old('description') : settings('description') }}</textarea>
                                </div>
                            </div>
                            <!-- ./col-12 -->

                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>
                <!-- /.card -->
            @endif
{{--            <div class="card">--}}
{{--                <form action="{{ url("settings/mobile-apps") }}" method="post">--}}
{{--                    @csrf--}}
{{--                    @method("PUT")--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="card-title">{{ trans('settings.Apps_Title') }}</h3>--}}
{{--                        <button class="btn btn-info float-right" type="submit">{{ trans("home.save") }}</button>--}}
{{--                    </div>--}}
{{--                    <!-- /.card-header -->--}}
{{--                    <div class="card-body d-flex">--}}
{{--                        <div class="col-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="ios_app_link">{{ trans("settings.Ios_link") }}</label>--}}
{{--                                <input class="form-control" name="ios_app_link" value="{{ old('ios_app_link') ? old('ios_app_link') : settings('ios_app_link') }}"--}}
{{--                                       placeholder="{{ trans("settings.Ios_link") }}" id="ios_app_link" type="text"  >--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="android_app_link">{{ trans("settings.Android_link") }}</label>--}}
{{--                                <input class="form-control" name="android_app_link" value="{{ old('android_app_link') ? old('android_app_link') : settings('android_app_link') }}"--}}
{{--                                       placeholder="{{ trans("settings.Android_link") }}" id="android_app_link" type="text"  >--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                    <!-- /.card-body -->--}}
{{--                </form>--}}
{{--            </div>--}}
{{--            <!-- /.card -->--}}

{{--            <div class="card">--}}
{{--                <form action="{{ url("settings/maintenance") }}" method="post">--}}
{{--                    @csrf--}}
{{--                    @method("PUT")--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="card-title">{{ trans('settings.Maintenance_tile') }}</h3>--}}
{{--                        <button class="btn btn-info float-right" type="submit">{{ trans("home.save") }}</button>--}}
{{--                        <div class="check-box float-right d-flex align-items-baseline" style="margin-right: 30px">--}}
{{--                            <label class="checkbox">--}}
{{--                                <input type="checkbox" {{ settings('status') == 'maintenance' ? "checked value=open " : "unchecked value=maintenance" }} name="status">--}}
{{--                                <span><small class="checkbox-title">{{ trans("settings.Status") }}</small></span>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- /.card-header -->--}}
{{--                    <div class="card-body">--}}


{{--                        <div class="d-flex">--}}
{{--                            <div class="col-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="maintenance_start_at">{{ trans("settings.Maintenance_start_at") }}</label>--}}
{{--                                    <input type="text" class="form-control" name="maintenance_start_at" id="maintenance_start_at"--}}
{{--                                           value="{{ old('maintenance_start_at') ? old('maintenance_start_at') : \Illuminate\Support\Carbon::parse(settings('maintenance_start_at'))->format("Y-m-d H:i:s") }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- ./col-6 -->--}}
{{--                            <div class="col-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="maintenance_end_at">{{ trans("settings.Maintenance_end_at") }}</label>--}}
{{--                                    <input type="text" class="form-control" name="maintenance_end_at" id="maintenance_end_at"--}}
{{--                                           value="{{ old('maintenance_end_at') ? old('maintenance_end_at') : \Illuminate\Support\Carbon::parse(settings('maintenance_end_at'))->format("Y-m-d H:i:s") }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- ./col-6 -->--}}
{{--                        </div>--}}
{{--                        <!-- ./d-flex -->--}}


{{--                        <div class="col-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="maintenance_message">{{ trans("settings.maintenance_message") }}</label>--}}
{{--                                <textarea class="form-control" name="maintenance_message" placeholder="{{ trans("settings.maintenance_message") }}"--}}
{{--                                          id="maintenance_message" style="min-height: 270px">{{ old('maintenance_message') ? old('maintenance_message') : settings('maintenance_message') }}</textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- ./col-12 -->--}}

{{--                    </div>--}}
{{--                    <!-- /.card-body -->--}}
{{--                </form>--}}
{{--            </div>--}}
{{--            <!-- /.card -->--}}

{{--            <div class="card">--}}
{{--                <form action="{{ url("settings/social-media") }}" method="post">--}}
{{--                    @csrf--}}
{{--                    @method("PUT")--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="card-title">{{ trans('settings.Social_title') }}</h3>--}}
{{--                        <button class="btn btn-info float-right" type="submit">{{ trans("home.save") }}</button>--}}
{{--                    </div>--}}
{{--                    <!-- /.card-header -->--}}
{{--                    <div class="card-body ">--}}

{{--                        <div class="col-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="fb">{{ trans("settings.FB_link") }}</label>--}}
{{--                                <input class="form-control" name="fb" value="{{ old('fb') ? old('fb') : settings('fb') }}"--}}
{{--                                       placeholder="{{ trans("settings.FB_link") }}" id="fb" type="url">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="in">{{ trans("settings.TW_link") }}</label>--}}
{{--                                <input class="form-control" name="tw" value="{{ old('tw') ? old('tw') : settings('tw') }}"--}}
{{--                                       placeholder="{{ trans("settings.TW_link") }}" id="tw" type="url">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                    <!-- /.card-body -->--}}
{{--                </form>--}}
{{--            </div>--}}
{{--            <!-- /.card -->--}}

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @push("js")
        <script src="{{ admin_assets('/js/bootstrap-tagsinput.js') }}"></script>
        <script src="{{ admin_assets('/js/jquery.datetimepicker.full.min.js') }}"></script>
        <script>
            $("#maintenance_start_at,#maintenance_end_at").datetimepicker({
                // format: 'yy/mm/dd',
            })
        </script>
    @endpush
@endsection
