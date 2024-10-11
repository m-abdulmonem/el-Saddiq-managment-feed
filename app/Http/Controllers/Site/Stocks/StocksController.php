<?php

namespace App\Http\Controllers\Site\Stocks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stock\CreateRequest;
use App\Http\Requests\Stock\UpdateRequest;
use App\Models\Product;
use App\Services\Stock\StockServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Http\Response;

class StocksController extends Controller
{

    protected $folder = "site.stocks";

    protected $trans = "stocks";

    protected $perm = "stock";

    /**
     * StocksController constructor.
     */
    public function __construct()
    {
        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return
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
     * @param StockServices $stock
     * @return JsonResponse
     */
    public function store(CreateRequest $request,StockServices $stock)
    {
        return $stock->createWithCode($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param StockServices $stock
     * @return Response
     */
    public function show(StockServices $stock)
    {
//        dd($stock->stock());
        $data = [
            'title' => trans("$this->trans.view",['name' => $stock->name]),
            'trans' => $this->trans,
            'stock' => $stock,
        ];

        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Stock $stock
     * @return void
     */
    public function edit(Stock $stock)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Stock $stock
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, StockServices $stock)
    {
        return $stock->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Stock $stock
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Stock $stock)
    {
        return $stock->removeRecorder();
    }
}
