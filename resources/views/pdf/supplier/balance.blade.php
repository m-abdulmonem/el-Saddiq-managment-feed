@extends("pdf.layouts.index")

@section("content")
    @push("title") الحركات المالية لفاتورة شراء @endpush

    <style>
        .invoice-info,
        .list,
        .total{
            margin-top: 30px !important;
        }
        @media print {
            .invoice-info,.table{
                font-size: 20px;
            }
        }

    </style>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-6">
            <h4>المورد/الشركة : <small> {{ to_arabic_int($data->supplier->code) }} - {{ $data->supplier->name }} </small> </h4>
            <h4>كود الفاتورة : <small> {{ to_arabic_int($data->code_number )}} </small></h4>
            <h4>رقم الفاتورة : <small> {{ to_arabic_int($data->bill_number) }} </small></h4>
        </div>
        <!-- /.col -->
        <div class="col-6">
            <h4>تاريخ الفاتورة : <small> {{ date_ar_format($data->created_at) }} </small></h4>
            <h4>إجمالى الفاتورة : <small> {{ num_to_arabic($data->total_price) }} </small></h4>
            <h4>الخصم : <small> {{ num_to_arabic($data->discount) }} </small></h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="list">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans("suppliers_balances.transaction_id") }}</th>
                <th>{{ trans("suppliers_balances.transaction_type") }}</th>
                <th>{{ trans("suppliers_balances.paid") }}</th>
                <th>{{ trans("suppliers_balances.date") }}</th>
                <th>{{ trans("suppliers_balances.note") }}</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 1; @endphp
            @foreach($data->supplierBalance as $balance)
                <tr>
                    <th>{{ $i++ }}</th>
                    <th>{{ $balance->transaction_id }}</th>
                    <th>{{ trans("suppliers_balances.$balance->transaction_type") }}</th>
                    <th>{{ num_to_arabic($balance->paid) }}</th>
                    <th>{{ to_arabic_int(date_ar($balance->created_at)->diffForHumans()) }} - {{  date_ar_format($balance->created_at) }}</th>
                    <th>{{ $balance->note ?? "-" }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row total">
        <div class="col-6">
            {{ trans("suppliers_bills.total_paid") }} :  <h4 class="primary-color ml-3">  {{ num_to_arabic($data->supplierBalance()->where("transaction_type","payment")->sum("paid")) }}</h4>
        </div>
        <div class="col-6">
            المتبقى :   <h4 class="primary-color ml-3">  {{ num_to_arabic(($data->total_price - $data->discount) - $data->supplierBalance()->sum("paid")) }}</h4>
        </div>
    </div>
@endsection
