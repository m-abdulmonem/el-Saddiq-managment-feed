<?php

namespace App\Http\Controllers\Ajax\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\UpdatePriceRequest;
use App\Models\Category;
use App\Models\Product\Product;
use App\Models\Supplier\Supplier;
use App\Models\Unit;
use App\Services\Products\ProductServices;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * @var string
     */
    protected $perm = "product";
    /**
     * @var string
     */
    protected $trans = "products/products";
    /**
     * @var string
     */
    protected $folder = "admin.products";
    /**
     * @var Product
     */
    private $product;
    /**
     * @var ProductServices
     */
    private $services;

    /**
     * ProductsController constructor.
     * @param Product $product
     * @param ProductServices $services
     */
    public function __construct(Product $product, ProductServices $services)
    {

        $this->product = $product;
        $this->services = $services;
    }

    /**
     * @param Request $request
     * @return
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of( $this->services->sort($request) )
                ->addIndexColumn()
                ->addColumn("name",function ($data){
                    return $data->nameCode();
                })
                ->addColumn("products",function ($data){
                    return $data->nameSupplier();
                })
                ->addColumn("supplier",function ($data){
                    return $this->supplierLink($data);
                })
                ->addColumn("category",function ($data){
                    return  $data->category->name;
                })
                ->addColumn("stock",function ($data){
                    return $this->stockLink($data) ?? "-";
                })
                ->addColumn("quantity",function ($data) use($request){
                    return ($request->stock)
                        ? num_to_ar($data->pivot->quantity)
                        : num_to_ar($data->stocks()->sum("quantity")) ;
                })
                ->addColumn("price",function ($data){
                    return currency(($stock = $data->stocks()->latest()->first()) ? $stock->pivot->ton_price : 0) ;
                })
                ->addColumn("sale_price",function ($data){
                    return currency($data->salePrice()) ;
                })
                ->addColumn("profit",function ($data){
                    return currency($data->profit) ;
                })
                ->addColumn("weight",function ($data){
                    return ( $data->weight() ) ?? "-";
                })
                ->addColumn("expired_at",function ($data){
                    $format = function ($date){
                        return date_ar($date)->format("Y-m-d");
                    };
                    $expired = $data->stocks()->wherePivot("quantity","!=",0);
                    return trim(implode(" | ",$expired->pluck("expired_at")->map($format)->unique()->toArray()),"|");
                })
                ->addColumn("purchase",function ($data) use ($request){
                    return $this->btnPurchase($request,$data);
                })
                ->addColumn("gain",function ($data){
                    return currency($data->debt()->sum("gain"));
                })
                ->addColumn("loss",function ($data){
                    return currency($data->debt()->sum("loss"));
                })
                ->addColumn('action', function($data) use ($request){

                    $btn = $request->index ? $this->btnChangePrice($data) : null;
                    $btn .= $request->stock ? $this->btnMove($data) : null;
                    $btn .= btn_view($this->perm,"products",$data);
                    $btn .= $this->btnUpdate($data);//$request->index ? $this->btnUpdate($data) :btn_update($this->perm,"products",$data);
                    $btn .= btn_delete($this->perm,"products",$data);
                    return $btn;
                })
                ->rawColumns(['name','action','supplier','category','stock','quantity','expired_at','purchase','move'])
                ->make(true);
        }//end if cond

    }

    public function updatePrice(ProductServices $product,UpdatePriceRequest $request)
    {
        $text = trans("$this->trans.alert_price_updated_successfully");

        return jsonSuccess($text,$product->updatePrice($request));
    }

    public function units()
    {
        $data = [];
        foreach (Unit::pluck("name","id")->toArray() as $id => $name)
            $data[] = ['id' => $id, 'text' => $name];
        return json($data);
    }

    public function suppliers()
    {
        $data = [];
        foreach (Supplier::pluck("name","id")->toArray() as $id => $name)
            $data[] = ['id' => $id, 'text' => $name];
        return json($data);
    }

    public function categories()
    {
        $data = [];
        foreach (Category::pluck("name","id")->toArray() as $id => $name)
            $data[] = ['id' => $id, 'text' => $name];
        return json($data);
    }

    public function locationsGraph(ProductServices $product, Request $request)
    {
        return json($product->locationsGraph($request->start,$request->end));
    }

    public function consumptionGraph(ProductServices $product,Request $request)
    {
        return json($product->consumptionGraph($request->start,$request->end));
    }

    public function pricesGraph(ProductServices $product,Request $request)
    {
        return json($product->pricesGraph($request->start,$request->end));
    }
    public function incomeStatementGraph(ProductServices $product,Request $request)
    {
        return json($product->gainLossGraph($request->start,$request->end));
    }


    public function search(Request $request)
    {
        $i = 1;
        $data = [];
        $products = ProductServices::with('stocks')
            ->where("name","like","%$request->keywords%")
            ->orWhere("code","like","%$request->keywords%")
            ->get();
        foreach ($products as $product)
            if ($product->stocks()->sum("quantity") >= 1)
                $data[] = [
                    'num' => ($i+1),
                    'id' => $product->id,
                    'admin' => auth()->id(),
                    'code' => $product->code,
                    'name' => $product->name(),
                    'profit' => $product->profit(),
                    'weight' => $product->weight,
                    'discount' => $product->discounts,
                    'quantity' => $product->stocks()->sum("quantity"),
                    'stocks' => $product->stocks()->pluck("stocks.name","stocks.id"),
                    'price' => (float)($product->stocks()->latest()->first()->pivot->sale_price ?? 0),
                ];
        return json($data);
    }



    private function btnChangePrice($data)
    {
        $perm =  user_can("update $this->perm") ? "btn-price-update" : "disabled";
        return "<button class='btn btn-secondary $perm'
                        data-id='$data->id'
                        data-price='{$data->latestPrice()}'
                        data-sale_price='{$data->salePrice()}'
                        title='".trans("$this->trans.update_price")."'><i class='fas fa-money-bill-alt'></i></button>";
    }


    private function btnUpdate($data)
    {
        $perm =  user_can("update $this->perm") ? "btn-update" : "disabled";
        return "<button class='btn btn-info $perm'
                        data-id='$data->id'
                        data-name='$data->name'
                        data-supplier_id='$data->supplier_id'
                        data-supplier_name='{$data->supplier->name}'
                        data-category_id='$data->category_id'
                        data-category_name='{$data->category->name}'
                        data-notes='$data->notes'><i class='fa fa-edit'></i></button>";
    }


    private function btnPurchase($request, $data)
    {
        $disabled = null;
        $price = ($price = $data->stocks()->latest()->first()) ? $price->pivot : "";

        if ($request->invoice) {
            $condition = ($data->stocks()->orWhere("products_stocks.quantity", "=", 0)->orWhereNull("products_stocks.quantity")->count() == 0 || $data->clientProduct()->where("bill_id", $request->clientBill)->first());
            $disabled = $condition ? "disabled" : null;
        }
        return "<button class='btn btn-info btn-purchased-product $disabled' $disabled id='product-$data->id'
                        title='".trans("$this->trans.btn_add_to_cart")."'
                        data-id='$data->id'
                        data-name='{$data->name()}'
                        data-category='{$data->category->name}'
                        data-total-price='".($price ? $price->ton_price : 1)."'
                        data-price='".($price ? $price->sale_price : 1)."'
                        data-query='{$data->unit->query}'
                        data-value='{$data->unit->value}'
                        data-profit='$data->profit'
                        data-discount='$data->discount'
                        data-weight='$data->weight'
                        data-stock='{$data->availableStocks()->pluck('name','id')}'
                        ><i class='fa fa-cart-plus'></i></button>";
    }

    public function btnMove($data)
    {
        return "<button class='btn btn-primary btn-move-product '  id='product-$data->id'
                        title='".trans("$this->trans.btn_move")."'
                        data-id='{$data->pivot->id}'
                        data-name='{$data->name()}'
                        data-quantity='{$data->pivot->quantity}'
                        ><i class='fas fa-people-carry'></i></button>";
    }


    /**
     * get category link
     *
     * @param $data
     * @return string
     */
    public function categoryLink($data)
    {
        return "<a class='info-color' href='" . route("categories.show",$data->category->id) . "'>" . $data->category->name . "</a>";
    }

    /**
     * get supplier link
     * @param $data
     * @return string
     */
    public function supplierLink($data)
    {
        return "<a class='info-color' href='" . route("suppliers.show",$data->supplier->id) . "' >" . $data->supplier->name  . "</a>";
    }

    /**
     * get stock link
     *
     * @param $data
     * @return string
     */
    public function stockLink($data)
    {
        $html =  [];
        foreach ($data->availableStocks() as $stock)
            $html[] = "<a class='info-color' href='" . route("stocks.show",$stock->id). "'>$stock->name</a> - ";
        return rtrim(implode(array_unique($html)));
    }

}
