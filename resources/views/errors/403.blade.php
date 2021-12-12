{{--@extends('errors::minimal')--}}

{{--@section('title', __('Forbidden'))--}}
{{--@section('code', '403')--}}
{{--@section('message', __($exception->getMessage() ?: 'Forbidden'))--}}
@php
    $title = trans("home.403")
@endphp
@extends('site.layouts.index')
@section('content')
    <div class="error-page">
        <h2 class="headline text-warning"> 403</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> @lang("home.403")</h3>

            <p>
                عفوا انت لاتملك صلاحية للدخول الى هذة الصفحة
                <a href="{{ url("/") }}">العودة للصفحة الرئيسية</a>
            </p>

            <form class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">

                    <div class="input-group-append">
                        <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <!-- /.input-group -->
            </form>
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
@endsection
