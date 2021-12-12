@extends("pdf.layouts.index")
@section("content")

    <div class="text-center title">@lang("$trans.daily")</div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-12 mb-3">
            <h4>@lang("users/users.user") : <span> {{ $daily->user->name() ?? "-" }} </span> </h4>
        </div>
        <!-- ./col -->
        <div class="col-6">
            <h4 class="mb-3">@lang("$trans.number") : <span> {{ ($daily->number )}} </span></h4>
            <h4 class="mb-3">@lang("$trans.time_in") : <span> {{ hour_in_ar(date("h:i a",strtotime($daily->time_in))) }} </span> </h4>
            <h4 class="mb-3">@lang("$trans.net_sales") : <span> {{ currency($daily->net_sales) }} </span> </h4>
            <h4 class="mb-3">@lang("$trans.balance") : <span> {{ currency($daily->balance) }} </span> </h4>
            <h4 class="mb-3">@lang("$trans.clients_count") : <span> {{ num_to_ar(1) }} </span> </h4>
        </div>
        <!-- /.col -->
        <div class="col-6">
            <h4 class="mb-3">@lang("home.date") : <span> {{ num_to_ar( $daily->created_at->format("Y-m-d"))  }} </span></h4>
            <h4 class="mb-3">@lang("$trans.time_out") : <span> {{ hour_in_ar(date("h:i a",strtotime($daily->time_out))) }} </span></h4>
            <h4 class="mb-3">@lang("$trans.discarded_sale") : <span> {{ currency(0) }} </span></h4>
            <h4 class="mb-3">@lang("$trans.inc_dec") : <span> {{ currency($daily->inc_dec) }}</span></h4>
            <h4 class="mb-3">@lang("$trans.sold_products_count") : <span> {{ num_to_ar(1) }}</span></h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @push("js")
        window.onafterprint = function () {
            window.location.href = "{{ route("ajax.dailies.logout") }}";
        };
    @endpush
@endsection
