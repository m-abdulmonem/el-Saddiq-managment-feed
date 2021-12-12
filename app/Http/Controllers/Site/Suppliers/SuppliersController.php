<?php

namespace App\Http\Controllers\Site\Suppliers;

use App\Http\Requests\Supplier\Supplier\CreateRequest;
use App\Http\Requests\Supplier\Supplier\UpdateRequest;
use App\Services\Supplier\SupplierServices;
use App\Http\Controllers\Controller;
use App\Models\SupplierBillReturn;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\SupplierBill;
use Exception;
use Illuminate\Support\Facades\Artisan;

class SuppliersController extends Controller
{
    /**
     * permission name
     *
     * @var string
     */
    protected $perm = "supplier";
    /**
     * view folders path name
     *
     * @var string
     */
    protected $folder = "site.suppliers";
    /**
     * translation folder name
     *
     * @var string
     */
    protected $trans = "suppliers/suppliers";

    /**
     * @var SupplierServices
     */
    private $supplier;


    public function __construct(SupplierServices $supplier)
    {
        $this->supplier = $supplier;

        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws Exception
     */
    public function index()
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans
        ];

        return view("$this->folder.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'title' => trans("$this->trans.create"),
            'trans' => $this->trans
        ];

        return  view("$this->folder.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return void
     */
    public function store(CreateRequest $request)
    {
        $data = $this->supplier->createCode($request->all());
        $text = trans("home.alert_success_create",['name' => $data->name]);

        return jsonSuccess($text,$data);
    }

    /**
     * Display the specified resource.
     *
     * @param SupplierServices $supplier
     * @return Response
     */
    public function show(SupplierServices $supplier)
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'supplier'=> $supplier,
            'trans' => $this->trans
        ];

        return view("$this->folder.view",$data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param SupplierServices $supplier
     * @return Response
     */
    public function edit(SupplierServices $supplier)
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'supplier'=> $supplier,
            'trans' => $this->trans
        ];

        return view("$this->folder.update",$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param SupplierServices $supplier
     * @return bool
     */
    public function update(UpdateRequest $request, SupplierServices $supplier)
    {
        return jsonSuccess(trans("home.alert_success_update"), $supplier->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SupplierServices $supplier
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(SupplierServices $supplier)
    {
        return $supplier->removeRecorder();
    }
}
