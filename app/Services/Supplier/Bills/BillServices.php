<?php


namespace App\Services\Supplier\Bills;

use App\Http\Requests\Supplier\Bills\UpdateRequest;
use App\Models\Product\Price;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Supplier\SupplierBalance;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier\SupplierBill;
use Illuminate\Http\Request;
use App\Models\Product\Product;
class BillServices extends SupplierBill
{

    protected $table = 'bills_suppliers';


    /**
     * sort data by supplier or get all data
     *
     * @param Request $request
     * @return BillServices[]|Collection|mixed
     */
    public function sort(Request $request)
    {
        return ($request->supplier)
            ? $this->bySupplier($request->supplier)
            : $this->all();
    }

    /**
     * create new record with code and user id
     *
     * @param $data
     * @return mixed
     */
    public function createWithCode($data)
    {
        $code = [
            'code' => $this->code(),
            'user_id' => auth()->id(),
            'quantity' => $data['total_quantity']
        ];

        return $this->create(array_merge($data,$code));
    }
    
    /**
     * get data by supplier id
     *
     * @param $id
     * @return mixed
     */
    public function bySupplier($id)
    {
        return $this->where("supplier_id",$id)->get();
    }

    /**
     * get product from stock
     *
     * @param $id
     * @return Model|HasMany|object|null
     */
    public function stock($id)
    {
        return $this->productsStocks()->where("product_id",$id)
            ->where("bill_id",$this->getKey())->first();
    }

    /**
     * get product price by given product id
     *
     * @param $id
     * @return Model|HasMany|object|null
     */
    public function price($id)
    {
        return $this->prices()->where("product_id",$id)->first();
    }

    /**
     * create new product to supplier
     *
     * @param $request
     * @param bool $update
     * @return array
     */
    public function syncProductSupplier($request,$update = false)
    {
        $callback = function ($c,$k,$v) use ($request,$update){
            if (!$update){
                $this->createPrice($request,$k,$v);
                $this->createStock($request,$k,$v);
            }

            return $c->put($v,[
                'quantity' => $request->quantity[$k],
                'price' => $request->prices[$k],
                'piece_price'=> $this->calcPiecePrice($request->prices[$k],$request->quantity[$k],$v),
            ]);
        };

        return $this->products()->sync(eachData($request->product_id,$callback)->toArray());
    }

    /**
     * sync product to stock create new if request have new instance or update exists or deleted it
     *
     * @param $request
     * @throws \Exception
     */
    public function syncStock($request)
    {
        $products = $this->products()->pluck("product_id")->toArray();

        $diff = array_diff($request->product_id,$products);

        if ( count($diff) > 0 )
            foreach ( $diff as $key => $id )
                $this->createStock($request,$key,$id);

        foreach ($products as $k => $id){
            $data = [
                'ton_price' => $request->prices[$k],
                'piece_price' => $this->calcPiecePrice($request->prices[$k],$request->quantity[$k],$id),
                'sale_price' => $request->sale_price[$k],
                'quantity' => $this->count( $request->quantity[$k],$id),
                'stock_id' => $request->stock[$k],
                'expired_at' => $request->expired_at[$k],
                'user_id' => auth()->id(),
            ];

            (!in_array($id,$request->product_id)) ? $this->stock($id)->delete() : $this->stock($id)->update($data);
        }

    }

    /**
     *
     * @param UpdateRequest $request
     * @return Model
     * @throws \Exception
     */
    public function syncReturnShipping(UpdateRequest $request)
    {

//        $collect = collect();

        return $bill = $this->returnedBills()->createWithCode(array_merge($request->excepted(),['bill_id'=>$this->getKey()]));

//        foreach ($request->product_id as $k => $id){
//            $collect->put($id,[
//                'quantity' => $request->quantity[$k],
//                'price' => $request->prices[$k],
//                'piece_price' => $this->calcPiecePrice($request->prices[$k],$request->quantity[$k],$id),
//            ]);
//
//            ( ($returnedQuantity = $this->stock($id)->quantity - $request->quantity[$k]) > 0 )
//                ? $this->stock($id)->update(['quantity' => $returnedQuantity])
//                : $this->stock($id)->delete();
//        }
//
//        $bill->products()->sync($collect->toArray());
//
//        return $bill;
    }
    /**
     * create new product to stock
     *
     * @param $request
     * @param $k
     * @param $id
     */
    public function createStock($request,$k,$id)
    {
        $data = [
            'ton_price' => $request->prices[$k],
            'piece_price' => $this->calcPiecePrice($request->prices[$k],$request->quantity[$k],$id),
            'sale_price' => $request->sale_price[$k],
            'quantity' => $this->count( $request->quantity[$k],$id),
            'stock_id' => $request->stock[$k],
            'expired_at' => $request->expired_at[$k],
            'user_id' => auth()->id(),
            'product_id' => $id
        ];

        $this->productsStocks()->create($data);
    }

    /**
     * create new product price
     *
     * @param $request
     * @param $k
     * @param $v
     * @return Model
     */
    public function createPrice($request,$k,$v)
    {
        $data = [
            'price' => $request->prices[$k],
            'sale_price' => $request->sale_price[$k],
            'quantity' => $request->quantity[$k],
            'value' => Price::calcValue($request->prices[$k],$v),
            'is_cheaper' => Price::isCheaperById($request->prices[$k],$v),
            'user_id' =>auth()->id(),
            'product_id' => $v,
        ];
        return $this->prices()->create($data);
    }

    /**
     * create transactions when create new bill
     *
     * @param $request
     */
    public function createBalances($request)
    {
        $balances = ['mashal' => $request->mashal, 'tip' => $request->tip, 'payment' => $request->postpaid];

        foreach ($balances as $type => $balance) {

            $data = [
                'code' => SupplierBalance::code(),
                'remaining_amount' => $type== "payment" ?  $request->price - $request->postpaid : 0,
                'paid' => $balance,
                'type' => $type,
                'supplier_id' => $request->supplier_id,
                'user_id'=>auth()->id(),
            ];

            $this->balances()->create($data);
        }
    }

    /**
     * update bill with total products quantity
     *
     * @param $quantity
     * @return bool
     */
    public function updateQuantity($quantity)
    {
        $data = [
            'code' => $this->code(),
            'quantity' => $quantity,
            'user_id' => auth()->id()
        ];
        return $this->update($data);
    }

    /**
     * get total quantity sold
     *
     * @return float|int|mixed
     */
    public function quantitySold()
    {
        $quantity = 0;
        $remainingQuantity =  $this->productsStocks()->sum("quantity");
        foreach ($this->products as $product)
            $quantity += $this->count($product->quantity,$product->id);
        return ( ($diff = $quantity - $remainingQuantity) > 0) ? $diff : 0;
    }

    /**
     * get total of returned quantity
     *
     * @return float|int
     */
    public function returnedQuantity()
    {
        $quantity = 0;
        foreach ($this->returnedBills as $bill){
            foreach ($bill->products as $product)
                $quantity += $this->count($product->quantity,$product->id);
        }
        return $quantity;
    }

    /**
     * get total of expired products quantity
     *
     * @return float|int
     */
    public function expiredQuantity()
    {
        $quantity = 0;
        foreach ($this->productsStocks as $productsStock){
            if ($productsStock->expired_at->diffInDays() <= 0)
                $quantity += $productsStock->quantity;
        }
        return $quantity;
    }

    /**
     * get total price of bill
     *
     * @return mixed
     */
    public function totalPrice()
    {
        return $this->price + $this->balances()->whereIn('type',['mashal','tip'])->sum("paid");
    }

    /**
     * get remaining price of bill
     *
     * @return mixed
     */
    public function remaining()
    {
        $tips =  $this->balances()->whereIn('type',['mashal','tip'])->sum("paid");

        return $paid = ($this->price + $tips) - $this->balances()->sum("paid");
    }

    public function remainingBalance()
    {
        return  $this->totalPaid() - $this->price;
    }

    public function totalPaid()
    {
        return $this->balances()->where("type","payment")->sum("paid");
    }

    /**
     * get the value of bill
     *
     * @return float|int
     */
    public function gainLoss()
    {
        $profit = 0;

        foreach ($this->productsStocks as $productsStock){
            $quantity =  $this->products()->where("product_id",$productsStock->product_id)->sum("quantity") ;

            if ($quantity < $productsStock->quantity)
                $profit += ($productsStock->sale_price - $productsStock->piece_price) * ($quantity - $productsStock->quantity);
        }

        return $profit;
    }

    /**
     * get gain value
     *
     * @return float|int
     */
    public function gain()
    {
        return  (($debt = $this->gainLoss()) > 0) ? $debt : 0;
    }

    /**
     * get loss value
     *
     * @return int
     */
    public function loss()
    {
        return (($debt = $this->gainLoss()) < 0 ) ? removeMines($debt) : 0;
    }

    public function debt()
    {
        return  $this->balances()->where("type","payment")->sum("paid") - ($this->price - $this->discount);
    }

    public function creditor()
    {
        return (($debt = $this->debt()) < 0 ) ? removeMines($debt) : 0;
    }

    public function debtor()
    {
        return (($debt = $this->debt()) < 0 ) ? $debt : 0;
    }

    /**
     * calc piece price
     *
     * @param $price
     * @param $quantity
     * @param $id
     * @return float|int
     */
    public function calcPiecePrice($price,$quantity,$id)
    {
        return ($weight = $this->findProduct($id)->weight) ? $price / (1000/$weight) : $price/$quantity;
    }

    /**
     * count all product quantity
     *
     * @param $quantity
     * @param $id
     * @return float|int
     */
    public function count($quantity,$id)
    {
        return ($weight = $this->findProduct($id)->weight) ? ($quantity * 1000 / $weight) : $quantity;
    }

    /**
     * status tags
     *
     * @return string
     */
    public function statusTag()
    {
        return "<span class='".$this->getStatusTag()."'>".trans("clients/bills.option_$this->status")."</span>";
    }

    /**
     * status css classes
     *
     * @return mixed
     */
    public function getStatusTag()
    {
        return [
            'draft'=> 'draft-status',
            'loaded' => 'loaded-status',
            'onWay' => 'onWay-status',
            'delivered' => 'shipped-status',
            'shipped' => 'shipped-status',
            'canceled'=>"canceled-status"
        ][$this->status];
    }

    /**
     * @param $id
     * @return mixed
     */
    private function findProduct($id)
    {
        return Product::find($id);
    }
}
