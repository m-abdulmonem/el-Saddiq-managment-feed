<?php

namespace App\Http\Controllers\Site\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Models\ClientProduct;
use App\Models\Price;
use App\Models\Product\Product;
use App\Models\ProductStock;
use App\Models\SupplierProduct;
use App\Services\Products\ProductServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductsController extends Controller
{

    protected $perm = "product";

    protected $trans = "products/products";

    protected $folder = "site.products";
    /**
     * @var Product
     */
    private $product;
    /**
     * @var ProductServices
     */
    private $services;


    public function __construct(Product $product,ProductServices $services)
    {
        $this->product = $product;
        $this->services = $services;

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
     * @return void
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return Response
     */
    public function store(CreateRequest $request)
    {
        $data = $this->services->createWithCode($request->all());

        return jsonSuccess(trans("home.alert_success_create"), $data);
    }

    /**
     * Display the specified resource.
     *
     * @param $product
     * @return Response
     */
    public function show(ProductServices $product)
    {
        $data = [
            'title' => trans("$this->trans.view",['name' => $product->name()]),
            'trans' => $this->trans,
            'product'=> $product,
        ];
        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return void
     */
    public function edit(Product $product)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Product $product
     * @return JsonResponse|Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $data = $product->update($request->all());

        return jsonSuccess(trans('home.alert_success_update'),$data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Product $product)
    {
        return $product->removeRecorder();
    }
}
