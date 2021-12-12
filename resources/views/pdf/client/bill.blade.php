@extends("pdf.layouts.index")

@section("content")
    @push("title") فاتورة مبيعات @endpush

    <style>


        .invoice-info,
        .list,
        .total{
            margin-top: 30px !important;
        }

        .page-header{
            margin-bottom: 80px;
        }
        @media print {
            .invoice-info,.table{
                font-size: 27px;
            }
        }

    </style>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-6">
            <h4>العميل : <small> {{ to_arabic_int($data->client->code) }} - {{ $data->client->name }} </small> </h4>
            <h4>كود الفاتورة : <small> {{ to_arabic_int($data->code )}} </small></h4>
            <h4>نوع الدفع : <small> {{ trans("suppliers_bills.$data->debt")}} </small></h4>
        </div>
        <!-- /.col -->
        <div class="col-6">
            <h4>تاريخ الفاتورة : <small> {{ date_ar_format($data->created_at) }} </small></h4>
            <h4>الخصم : <small> {{ num_to_arabic($data->discount) }} </small></h4>
            <h4>الكمية : <small> {{ to_arabic_int($data->product()->get()->sum("quantity")) }} {{ trans("products.count") }}</small></h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="list">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans("products.name") }}</th>
                <th>{{ trans("products.unit_price") }}</th>
                <th>{{ trans("products.count") }}</th>
                <th>{{ trans("products.kilo") }}</th>
                @if($data->client->trader === "true")
                    <th>{{ trans("products.quantum") }}</th>
                @endif
                <th>{{ trans("products.total_price") }}</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 1; @endphp
            @foreach($data->product()->get() as $product)
                @php($prod = \App\Models\Product::find($product->product_id))
                <tr>
                    <th>{{ $i++ }}</th>
                    <th>{{ to_arabic_int($prod->code) }} - {{ $prod->name }}</th>
                    <th>{{ num_to_arabic($product->piece_price) }}</th>
                    <th>{{ to_arabic_int($product->quantity) }}</th>
                    <th>{{ to_arabic_int($product->quantity * $prod->weight) ?? "-" }}</th>
                    @if($data->client->trader === "true")
                        <th>{{ trans("products.ton",['ton' => to_arabic_int(($product->quantity * $product->quantity) / 1000)]) }}</th>
                    @endif
                    <th>{{ num_to_arabic($product->total_price) }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row total">
        <div class="col-4 float-right" >
            {{ trans("suppliers_bills.total_price") }} :  <h4 class="primary-color ml-3">  {{ num_to_arabic($data->total_price) }}</h4>
        </div>
        <div class="col-4">
            رصيد سابق :   <h4 class="primary-color ml-3">  {{ num_to_arabic($data->total_price ) }}</h4>
        </div>
        <div class="col-4" style="text-align: left;padding-left: 100px;">
            الصافى :   <h4 class="primary-color ml-3">  {{ num_to_arabic($data->total_price ) }}</h4>
        </div>

    </div>
    <div class="row">
        فقط{{ spell_out( $data->total_price - $data->discount  ) }}
    </div>
    @push("js")
        window.onafterprint = function () {
            window.location.href = "{{ route("sales.index") }}"
        };
    @endpush
@endsection
