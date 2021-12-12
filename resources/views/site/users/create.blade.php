@extends("site.layouts.index")
@section("content")
    @php
        use App\Models\Job;
    @endphp
    @push("css")
        <link rel="stylesheet" href="{{ admin_assets('/css/amsify.suggestags.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ admin_assets("/css/icheck-bootstrap.min.css") }}">
    @endpush
    <form action="{{ route("users.store") }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-9">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("$trans.main_info")</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang("home.create")</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="name">@lang("$trans.name")</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="@lang("$trans.name")" name="name" value="{{ old("name") }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-6 -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="username">@lang("$trans.username")</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="@lang("$trans.username")" name="username" value="{{ old("username") }}">
                                    @error('username')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-6 -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="email">@lang("$trans.email")</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="@lang("$trans.email")" name="email" value="{{ old("email") }}">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="phone">@lang("$trans.phone")</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="@lang("$trans.phone")" name="phone" value="{{ old("phone") }}">
                                    @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="salary">@lang("$trans.salary")</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="salary" placeholder="@lang("$trans.salary")" name="salary" value="{{ old("salary") }}">
                                    @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                        </div>
                        <!-- ./row -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="address">@lang("$trans.address")</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="@lang("$trans.address")" name="address" value="{{ old("address") }}">
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="holidays">@lang("$trans.select_holiday")</label>
                                    <input class="form-control" name="holidays" value="{{ old('holidays') }}"
                                           placeholder="@lang("$trans.select_holiday")" id="holidays" data-role="tagsinput">
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- ./row -->
                        <div class="row">

                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="salary_type">@lang("$trans.select_salary_type")</label>
                                    <select name="salary_type" id="salary_type" class="form-control @error('salary_type') is-invalid @enderror">
                                        {{ select_options(['daily','monthly'],"salary_type",null,$trans) }}
                                    </select>
                                    @error('salary_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group ">
                                    @php $status = ['1','0'] @endphp
                                    <label for="status">@lang("$trans.select_status")</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        {{ select_options($status,"status",null,$trans) }}
                                    </select>
                                    @error('status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4-->
                            <div class="col-4">
                                <div class="form-group ">
                                    @php $jobs = Job::all()->pluck("name","id") @endphp
                                    <label for="job_id">@lang("$trans.select_job_title")</label>
                                    <select name="job_id" id="job_id" class="form-control @error('job_id') is-invalid @enderror">
                                        {{ select_options_db($jobs,"job_id") }}
                                    </select>
                                    @error('job_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4-->

                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="credit_limit">@lang("clients/clients.credit_limit")</label>
                                    <input type="number" step="any" class="form-control @error('credit_limit') is-invalid @enderror" id="credit_limit" value="{{old("credit_limit")}}"
                                           placeholder="@lang("clients/clients.credit_limit")" name="credit_limit">
                                    @error('credit_limit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="discount_limit">@lang("$trans.discount_limit")</label>
                                    <input type="number" step="any" class="form-control @error('discount_limit') is-invalid @enderror" id="discount_limit" value="{{old("discount_limit")}}"
                                           placeholder="@lang("$trans.discount_limit")" name="discount_limit">
                                    @error('discount_limit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>


                        <!-- ./row -->
                        <div class="col-12">
                            @php
                                $models = [
                                    //products
                                    'products/products'=>'product',
                                    //stocks
                                    'stocks'=>'stock',
                                    //users
                                    'users/users' => 'user',
                                    //clients
                                    'clients/clients' => 'client',
                                    'clients/balances' => 'client_balance',
                                    'clients/bills' => 'client_bill',
                                    //suppliers
                                    'suppliers/suppliers' => 'supplier',
                                    'suppliers/balances' => 'supplier_balance',
                                    'suppliers/bills' => 'supplier_bill',
                                    //categories
                                    'products/categories'=>'category',
                                    'users/attendances'=>'attendance',
                                    'balances'=>'balance',
                                    'settings'=>'setting',
                                    'users/jobs' => 'job',
                                    'chicks/chicks' => 'chick',
                                    'chicks/orders' => 'chick_order',
                                    'chicks/booking' => 'chick_booking',
                                    'transactions/expenses' => 'expenses',
                                    'transactions/receipts' => 'receipts',
                                    'transactions/payments' => 'payments ',
                                    'transactions/banks' => 'banks',
                                    'dailies' => 'daily',
                                    'products/medicines' => 'medicine',
                                ];
                                $cruds = ['create','read','update',"delete"]
                            @endphp
                            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                                @foreach($models as $index => $model)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index =="products"? "active": "" }}" data-toggle="pill"  href="#{{ $model }}" role="tab" aria-controls="{{ $model }}" >{{ trans($index . ".title") }}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="custom-content-above-tabContent">
                                @foreach($models as $index=>$model)
                                    <div class="tab-pane fade show {{ $index =="products"? "active": "" }}" id="{{ $model }}" role="tabpanel" aria-labelledby="{{$model}}">
                                        <div class="d-flex">
                                            @foreach($cruds as $key => $crud)
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="{{$crud}}_{{ $model }}" name="permissions[]" value="{{$crud}} {{$model}}"
                                                           data-key="{{ old("permissions") ? array_key_exists($key,old("permissions"))  ?  "checked": "" : "" }}" >
                                                    <label for="{{$crud}}_{{ $model }}">
                                                        <span>{{ trans("home." . $crud) }}</span>
                                                    </label>
                                                </div>
                                                <!-- ./icheck-primary -->
                                            @endforeach
                                        </div>
                                        <!-- ./d-flex -->
                                    </div>
                                    <!-- ./tab-pane -->
                                @endforeach
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
                        <h3 class="title-header">@lang("$trans.picture") </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="w-100">
                                <img src="{{ admin_assets("img/MAAdminLogo.png") }}" class="preview-img img " alt="" id="logo" />
                                <div class="btn btn-default btn-file">@lang("$trans.picture")
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
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("$trans.password")</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group ">
                                <label for="password">@lang("login.password")</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="@lang("login.password")" name="password" value="{{ old("password") }}">
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group ">
                                <label for="password_confirmation">@lang("login.password_confirm")</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="{@lang("login.password_confirm")" name="password_confirmation" value="{{ old("password_confirmation") }}">
                                @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <!-- /.row -->
    @push("js")
        <script src="{{ admin_assets('/js/jquery.amsify.suggestags.js') }}"></script>
        <script>

            $('#holidays').amsifySuggestags({
                suggestions: ['الجمعة','السبت','الاحد','الاثنين','الثلاثاء','الاربعاء','الخميس'],
                whiteList: true
            })
            $(function () {
                $("input[type=checkbox]").each(function (index,item) {
                    if ($(item).data("key").length>0 && $(item).data("key")=== "checked")
                        $(item).attr("checked", "checked");
                })
            });

            function log(data) {
                console.log(data)
            }
        </script>
    @endpush

@endsection
