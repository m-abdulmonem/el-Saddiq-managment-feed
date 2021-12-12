<?php

namespace App\Http\Controllers\Site\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierBalance;
use function Composer\Autoload\includeFile;
use Illuminate\Http\Request;

class supplierBalancesController extends Controller
{

    protected $folder = "";

    protected $trans  = "suppliers_balances";

    protected $perm = "";

    /**
     * Display a listing of the resource.
     *
     * @param Supplier $supplier
     * @return void
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request->all());
        // check if user has this page permission or not to display 403 page error
        check_perm("create $this->perm",null,null,"json");
        //validate inputs
        $validator = $this->validation($request);
        //add authenticated user id to request
        $request->merge(['user_id' => auth()->id()]);
        //check if request only has paid and token or not
        $data = count($request->all()) > 2
            ? $request->only("paid","total_price","bill_id","user_id","debt")
            : $request->only("paid");

        //check if validate has no errors
        if (! $validator->fails()){
            $balance = SupplierBalance::create($data);
            return json($balance,1,trans("$this->trans.alert_success_create"));
        }
        //return validate errors
        return json($validator->errors(),0);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function validation(Request $request,$id = null)
    {
        //validate inputs

         if (count($request->all()) > 2)
             return validator($request->all(),[
                 'paid' => 'required|numeric',
                 'total_price' => 'required|integer',
                 'bill_id' => 'required|integer',
                 'debt' => 'required|in:creditor,debtor,finished'
             ],[],[
                 'paid' => trans("$this->trans.paid"),
                 'total_price' => trans("$this->trans.total_price"),
                 'bill_id' => trans("$this->trans.bill_id"),
                 'debt' => trans("$this->trans.debt")
             ]);

         return validator($request->all(),[
             'paid' => 'required|numeric',
         ],[],[
             'paid' => trans("$this->trans.paid")
         ]);
    }
}
