<?php

namespace App\Http\Controllers\Site\Chicks;

use App\Http\Requests\Chicks\Orders\CreateRequest;
use App\Http\Requests\Chicks\Orders\UpdateRequest;
use App\Http\Controllers\Controller;
use App\Services\Chicks\OrdersServices;
use Illuminate\Http\JsonResponse;
use App\Models\Chick\ChickOrder;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Hash;

class OrdersController extends Controller
{


    protected $folder = "site.chicks.orders";

    protected $trans = "chicks/orders";

    protected $perm = "chick_order";
    /**
     * @var ChickOrder
     */
    private $order;
    /**
     * @var OrdersServices
     */
    private $services;


    /**
     * OrdersController constructor.
     * @param ChickOrder $order
     * @param OrdersServices $services
     */
    public function __construct(ChickOrder $order,OrdersServices $services)
    {
        $this->order = $order;
        $this->services = $services;

        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans,
            'perm' => $this->perm
        ];

        return view("$this->folder.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return JsonResponse|Response
     */
    public function store(CreateRequest $request)
    {
        return $this->order->createRecord( $request->all() );
    }

    /**
     * Display the specified resource.
     *
     * @param ChickOrder $order
     * @return Response
     */
    public function show(OrdersServices $order)
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'order'=> $order,
            'services' => $this->services->supplierStatics(),
            'clientServices' => $this->services->clientStatics(),
            'trans' => $this->trans,
        ];

        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ChickOrder $order
     * @return void
     */
    public function edit(ChickOrder $order)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param $order
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, ChickOrder $order)
    {
        return $order->updateRecord( $request->all() );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ChickOrder $order
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ChickOrder $order)
    {
        return $order->removeRecorder();
    }

}
