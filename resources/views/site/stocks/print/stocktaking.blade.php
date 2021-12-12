@extends("pdf.layouts.index")
@section("content")
    @push("title")@lang("$trans.stocktaking")@endpush

    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-12">
            <h4>@lang("$trans.code") : <span> {{ num_to_ar($stock->code )}} </span></h4>
            <h4>@lang("$trans.name") : <span> {{ num_to_ar($stock->name )}} </span></h4>
            <h4>@lang("$trans.address") : <span> {{ $stock->address }} </span> </h4>
        </div>
    </div>
    <!-- /.row -->

    <div class="list">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang("products/products.name")</th>
                <th>@lang("products/products.quantity")</th>
                <th>@lang("products/products.expired_at")</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 1; @endphp
            @foreach($stock->products()->where("products_stocks.quantity","!=",0)->whereNull("products_stocks.deleted_at")->get() as $product)
                <tr>
                    <th>{{ $i++ }}</th>
                    <th>{{ $product->name() }}</th>
                    <th>{{ num_to_ar($product->pivot->quantity) }}</th>
                    <th>{{ carbon_parse($product->pivot->expired_at,"Y-m-d") }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @push("js")
        window.onafterprint = function () {
            window.location.href = "{{ route("stocks.index") }}"
        };
    @endpush
@endsection
