<?php


namespace App\Services\Balances;


use App\Http\Requests\Chicks\Booking\CreateRequest;
use App\Models\Chick\BookingChick;
use App\Models\Chick\ChickOrder;
use App\Models\Client\ClientBalance;
use Illuminate\Http\Request;

class ClientServices
{

    /**
     * @var ClientBalance
     */
    private $balance;
    /**
     * @var ChickOrder
     */
    private $order;

    /**
     * 
     * ClientBalanceServices constructor.
     * @param ClientBalance $balance
     */
    public function __construct(ClientBalance $balance,ChickOrder $order)
    {

        $this->balance = $balance;
        $this->order = $order;
    }

    /**
     * @param $request
     * @param $order
     * @return mixed
     */
    public function sort($request,$order)
    {
        if ($request->type)
            return $this->byType($request->type,$order);

        elseif ($request->start || $request->end)
            return $this->byType($request->type,$order);

        else
            return $this->byBooking($order)->get();
    }

    public function orders($id)
    {
        $orders = ChickOrder::where("chick_id",$id)->get();

        $booking = BookingChick::whereIn("order_id",$orders)->pluck("id");

        return $this->balance->whereIn("booking_id",$booking);
    }
    
    /**
     * get all balances record by chick id and orders id and booking id
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function byOrders($request)
    {
        $balances = $this->orders($request->id);

        if ($request->type)
            return $balances->where("type",$request->type)->get();

        elseif ($request->start||$request->end)
            return $balances->whereBetween("created_at",[startDate($request->start),endDate($request->end)])->get();

        else
            return $balances->get();
    }

    /**
     * get all record has [booking_id] fill
     *
     * @param $order
     * @return mixed
     */
    public function byBooking($order)
    {
        return $this->balance->whereIn("booking_id",$this->orderBookingId($order));
    }

    /**
     * @param $type
     * @param $order
     * @return mixed
     */
    public function byType($type,$order)
    {
        if (is_array($type))
            return $this->byBooking($order)->whereIn("type",$type)->get();

        return $this->byBooking($order)->where("type",$type)->get();
    }

    /**
     * @param $order
     * @return mixed
     */
    public function orderBookingId($order)
    {
        return $order->booking()->pluck("id")->toArray();
    }

    /**
     * @param $order
     * @return mixed
     */
    public function remaining($order)
    {
        return $this->byType(["catch","deposit"],$order)->sum("remaining_amount");
    }

    public function totalBookingPrice($order,$property = "chick_price")
    {
        return $order->booking()->sum("quantity") * $order->$property;
    }

    public function totalPaid($id)
    {
        $callback = function ($order){
            return $this->paid($order);
        };

        return $this->order->where("chick_id",$id)->get()->map($callback)->sum();
    }

    public function totalCreditor($id)
    {
        $callback = function ($order){
            return $this->creditor($order);
        };

        return $this->order->where("chick_id",$id)->get()->map($callback)->sum();
    }

    public function totalDebtor($id)
    {
        $callback = function ($order){
            return $this->debtor($order);
        };

        return $this->order->where("chick_id",$id)->get()->map($callback)->sum();
    }

    /**
     * @param $order
     * @return mixed
     */
    public function paid($order)
    {
        return $this->byType(["catch","deposit"],$order)->sum("paid");
    }

    /**
     * @param $order
     * @return mixed
     */
    public function creditor($order)
    {
        if ( ($creditor = $this->totalBookingPrice($order) - $this->paid($order)) < 0 )
            return removeMines($creditor);
    }

    /**
     * @param $order
     * @param string $property
     * @return float|int|mixed
     */
    public function debtor($order,$property = "chick_price")
    {
        if ( ($debtor = $this->totalBookingPrice($order,$property) - $this->paid($order) ) >= 0 )
            return $debtor;
    }


    
    /**
     * @param CreateRequest $request
     * @param $booking
     * @return mixed
     */
    public function createBooking(CreateRequest $request ,$booking)
    {
        return $this->balance->create($this->bookingFields($request,$booking->id));
    }

    /**
     * @param BookingChick $booking
     * @param Request $request
     * @return mixed
     */
    public function createDeliveredBooking(BookingChick $booking,$request)
    {
        $total = $request->paid - $booking->balances()->sum('paid');

        return $booking->balances()->create([
            'code' => $this->code(),
            'remaining_amount' => $total,
            'paid' => $request->paid,
            'type' => 'payment',
            'user_id' => auth()->id(),
            'client_id' => $request->client_id,
        ]);

//        return $this->balance->create($this->bookingFields($request,$booking->id,$total));
    }

    /**
     * find booking deposit record
     *
     * @param $data
     * @return mixed
     */
    public function bookingDeposit($data)
    {
        return $this->balance->where("booking_id", $data->id)->first();
    }


    /**
     * get booking fields
     *
     * @param $request
     * @param $id
     * @param int $total
     * @return array
     */
    public function bookingFields($request,$id,$total = 0)
    {
        return array_merge($this->fields($request,$total),['booking_id'=>$id]);
    }

    /**
     * check if paid property are exists
     *
     * @param $request
     * @return array
     */
    public function bookingPaidField($request)
    {
        return isset($request->paid)
            ? ['paid'=>$request->paid,'type'=>'catch']
            : ['paid'=>$request->deposit,'type'=>'deposit'];
    }

    /**
     *
     * @param Request $request
     * @param int $total
     * @param $note
     * @return array
     */
    public function fields($request,$total = 0,$note = null)
    {
        $paid = $this->bookingPaidField($request);

        return [
            'code' => $this->code(),
            'remaining_amount' => $total,
            'paid' => $paid['paid'],
            'type' => $paid['type'],
            'notes' => $note,
            'client_id' => $request->client_id,
            'user_id' => auth()->id()
        ];
    }


    /**
     * get latest record code
     *
     * @return int
     */
    public function code()
    {
        return $this->balance->all()->count() + 1;
    }

}
