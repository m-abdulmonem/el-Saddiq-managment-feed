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
    <form action="{{ route("users.update",$user->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-9">
                @csrf
                @method("put")
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-left">@lang("$trans.main_info")</h3>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang("home.save")</button>
                        @can("create user")<a href="{{ route("users.create") }}" class="btn btn-info"><i class="fa fa-plus"></i> @lang("home.new")</a>@endcan
                        @can("delete user")
                            <button class="btn btn-danger btn-delete " type="button"
                                    data-url="{{ route("users.destroy",$user->id) }}"
                                    data-name="{{  $user->name }}" data-token="{{ csrf_token() }}"
                                    data-title="@lang("home.confirm_delete")"
                                    data-text="@lang("home.alert_delete",['name'=> $user->name])"
                                    data-back="{{ route("users.index") }}">
                                <a><i class="fa fa-trash"></i> @lang("home.delete")</a>
                            </button>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="name">@lang("$trans.name")</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                           placeholder="@lang("$trans.name")"  value="{{ old("name") ? old("name") : $user->name }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-6 -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="username">@lang("$trans.username")</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                                           placeholder="@lang("$trans.username")"  value="{{ old("username") ? old("username") : $user->username }}" disabled>
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
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                           placeholder="@lang("$trans.email")" value="{{ old("email") ? old("email") : $user->email }}" disabled>
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="phone">@lang("$trans.phone")</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                                           placeholder="@lang("$trans.phone")"  value="{{ old("phone") ? old("phone") : $user->phone }}" >
                                    @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="salary">@lang("$trans.salary")</label>
                                    <input type="text" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary"
                                           placeholder="@lang("$trans.salary")"  value="{{ old("salary") ? old("salary") : $user->salary }}" >
                                    @error('salary')
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
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                           placeholder="@lang("$trans.address")" value="{{ old("address") ? old("address") : $user->address }}" >
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="holidays">@lang("$trans.select_holidays")</label>
                                    <input class="form-control" name="holidays" value="{{ old('holidays') ? old("holidays") : $user->holidays }}"
                                           placeholder="@lang("$trans.select_holidays")" id="holidays" data-role="tagsinput">
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
                                        {{ select_options( ['daily','monthly'],"salary_type",$user->salary_type,$trans) }}
                                    </select>
                                    @error('salary_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./col-4 -->
                            <div class="col-4">
                                <div class="form-group ">
                                    <label for="is_active">@lang("$trans.select_status")</label>
                                    <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                        {{ select_options(['1','0'],"status",$user->is_active,$trans) }}
                                    </select>
                                    @error('is_active')
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
                                        {{ select_options_db($jobs,"job_id",$user->job_id) }}
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
                                    <input type="number" step="any" class="form-control @error('credit_limit') is-invalid @enderror" id="credit_limit" value="{{old('credit_limit') ? old("credit_limit") : $user->credit_limit}}"
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
                                    <input type="number" step="any" class="form-control @error('discount_limit') is-invalid @enderror" id="discount_limit" value="{{old('discount_limit') ? old("discount_limit") : $user->discount_limit}}"
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
                                    'users/jobs'=>'job',
                                    'chicks/chicks' => 'chick',
                                    'chicks/orders' => 'chick_order',
                                    'chicks/booking' => 'chick_booking',

                                    'transactions/expenses' => 'expenses',
                                    'transactions/receipts' => 'receipts',
                                    'transactions/payments' => 'payments ',
                                    'transactions/banks' => 'banks',
                                    'products/medicines' => 'medicine',
                                    'dailies' => 'daily',


                                ];
                                $cruds = ['create','read','update',"delete"]
                            @endphp
                            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                                @foreach($models as $index => $model)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index =="products"? "active": "" }}" data-toggle="pill"  href="#{{ $model }}" role="tab" aria-controls="{{ $model }}" >@lang($index . ".title")</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="custom-content-above-tabContent">
                                @foreach($models as $index=>$model)
                                    <div class="tab-pane fade show {{ $index =="products"? "active": "" }}" id="{{ $model }}" role="tabpanel" aria-labelledby="{{$model}}">
                                        <div class="d-flex">
                                            @foreach($cruds as $key => $crud)
                                                {{--                                                {{ old("permissions") ? array_key_exists($key,old("permissions"))  ?   : "" : ""  }}--}}
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="{{$crud}}_{{ $model }}" name="permissions[]" value="{{$crud}} {{$model}}"  {{ user_can("$crud $model",null,$user->id) ? "checked":"" }}
                                                           data-key="{{ old("permissions") ? (array_key_exists($key,old("permissions"))) ?  old("permissions")[$key] : "" : "" }}" >
                                                    <label for="{{$crud}}_{{ $model }}">
                                                        <span>@lang("home." . $crud)</span>
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
                                <img src="{{ image($user->picture,true) }}" class="preview-img img " alt="" id="logo" />
                                <div class="btn btn-default btn-file">@lang("$trans.picture")
                                    <i class="fas fa-paperclip"></i>
                                    <input type="file" value="{{ old('picture') }}" class="upload" >
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
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="@lang("login.password")"  value="{{ old("password") }}" disabled>
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group ">
                                <label for="password_confirmation">@lang("login.password_confirm")</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="@lang("login.password_confirm")"  value="{{ old("password_confirmation") }}" disabled>
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
        <script src="{{ admin_assets("/js/datatables/btn_delete.js") }}"></script>

        <script>

            $('#rest_days').amsifySuggestags({
                suggestions: ['الجمعة','السبت','الاحد','الاثنين','الثلاثاء','الاربعاء','الخميس'],
                whiteList: true
            });

            btn_delete();
            $(function () {

                $("input[type=checkbox]").each(function (index,item) {

                    if ($(this).data("key").length>0 && $(this).data("key")=== $(this).val()) {
                        $(this).attr("checked", "checked");
                        console.log($(this))
                    }

                })
            })
        </script>
    @endpush


@endsection
