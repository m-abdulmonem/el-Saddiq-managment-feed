@extends('site.layouts.auth')

@section("content")
    @push("css")
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ admin_assets("/css//icheck-bootstrap.min.css") }}">
    @endpush
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans("login.welcome") }}</p>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route("login") }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="{{ trans("login.auth") }}" name="email" autofocus required value="{{ old("email") }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-at"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('email') is-invalid @enderror" placeholder="{{ trans("login.password") }}" name="password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')--}}
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" {{ old('remember_me') == 'on' ? "checked" : "unchecked" }} name="remember">
                            <label for="remember">
                                <span>{{ trans("login.remember_me") }}</span>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">{{ trans("login.title") }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-1">
                <a href="{{ route('password.request') }}">{{ trans("login.password_forget") }}</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
    @push("js")

    @endpush
@endsection
