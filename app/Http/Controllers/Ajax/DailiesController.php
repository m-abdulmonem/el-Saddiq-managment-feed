<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Dailies\Daily;
use App\Services\Clients\bills\InvoicesServices;
use Illuminate\Http\Request;

class DailiesController extends Controller
{

    public function __construct(Request $request)
    {
        if (!$request->ajax())
            redirect("/");
    }

    protected $folder = "site.dailies";
    protected $trans = "dailies";
    protected $perm = "receipts";

    public function index(Request $request)
    {
        if ($request->ajax()){
        }
    }

    public function close(Daily $daily,InvoicesServices $invoice,Request $request)
    {
        $this->validate($request,[
            'balance' => 'required'
        ]);

        $update = $daily->today()->update([
            'net_sales' => $daily->netSales(),
            'inc_dec' => ($request->balance - $daily->netSales()),
            'time_out' => now()
        ]);

        return $update ? jsonSuccess("",route("ajax.dailies.print")) : jsonError(trans("$this->trans.alert_daily_not_saved"));
    }

    public function print(Daily $daily)
    {
        $data = [
            'trans' => $this->trans,
            'daily' => $daily->latest()->first(),
        ];
        return view("$this->folder.print.index",$data);
    }


}
