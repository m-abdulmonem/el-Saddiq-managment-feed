<?php

namespace App\Http\Controllers\Site\PDF;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientBill;


class PDFController extends Controller
{

    public function index($id = null,$view_name = null)
    {

        $view = explode("-",$view_name);

        return ($data = $this->get_data($id))
            ? view("pdf.$view[0]." . str_replace("-","_",$view[1]),[
                'data' => $this->get_data($id)
            ])
            : "error";
    }

    private function get_data($id)
    {
        $id =  explode("-",$id);
        switch ($id[0]){
            case "supplierBill":
                return SupplierBill::with(['supplierBalance','products','supplier'])->find(intval($id[1]));
            case "ClientBill":
                return ClientBill::with(['products','client','balances'])->find(intval($id[1]));
            case "supplierBillReturn":
                return SupplierBillReturn::with(['supplierBalance','supplier'])->find(intval($id[1]));
            case "supplierBalance":
                return SupplierBill::with(['supplierBalance','supplier'])->find(intval($id[1]));
        }
    }
}
