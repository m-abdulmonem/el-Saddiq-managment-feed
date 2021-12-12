<?php

namespace App\Http\Controllers\Ajax\Chicks;

use App\Services\Balances\BalancesServices;
use App\Services\Balances\ClientServices;
use App\Services\Chicks\bookingServices;
use App\Http\Controllers\Controller;
use App\Models\Chick\BookingChick;
use App\Services\Sms\BookingSmsServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    protected $trans = "chicks/booking";

    protected $perm = "chick_booking";

    /**
     * @var BookingChick
     */
    private $booking;
    /**
     * @var bookingServices
     */
    private $services;
    /**
     * @var ClientServices
     */
    private $balances;

    /**
     * ChickBookingController constructor.
     *
     * @param BookingChick $booking
     * @param bookingServices $services
     * @param BalancesServices $balance
     */
    public function __construct(BookingChick $booking, bookingServices $services, BalancesServices $balance)
    {
        $this->balances = $balance;
        $this->booking = $booking;
        $this->services = $services;
    }

    /**
     * @param Request $request
     * @param bookingServices $booking $booking
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request,bookingServices $booking)
    {
        if ($request->ajax()) {
            return datatables()->of( $booking->sort($request) )
                ->addIndexColumn()
                ->addColumn("client",function ($data){
                    $route = route("clients.show",$data->client->id);
                    return "<a class='info-color' href='$route'>" . $data->client->name . "</a>";
                })
                ->addColumn("phone",function ($data){
                    return $data->client->phone;
                })
                ->addColumn("chick",function ($data){
                    $route =  route("chicks.show",$data->chick->id);
                    return "<a class='info-color' href='$route'>" . $data->chick->name . "</a>";
                })
                ->addColumn("quantity",function ($data){
                    return num_to_ar( $data->quantity );
                })
                ->addColumn("deposit",function ($data){
                    return currency( $data->deposit );
                })
                ->addColumn("status",function ($data){
                    return trans("$this->trans.option_" . $data->is_came );
                })
                ->addColumn('action', function($data){
                    $btn = $this->btnResendSms($data);
                    $btn .= $this->btnDelivered($data);
                    $btn .= $this->btnTransaction($data);
                    $btn .= $this->btnUpdate($data);
                    $btn .= $this->btnDelete($data);
                    return $btn;
                })
                ->rawColumns(['action','client','chick','transactions'])
                ->make(true);
        }
    }

    /**
     * @param Request $request
     * @param BookingChick $booking
     * @return mixed
     * @throws Exception
     */
    public function transaction(Request $request,BookingChick $booking)
    {
        if ($request->ajax()) {
            if ($request->startDate || $request->end)
                $data = $booking->balances()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
            elseif ($type = $request->type)
                $data = $booking->balances()->where("type",$type)->latest()->get();
            else
                $data = $booking->balances()->latest()->get();
            
            return $this->balances->client($data);
        }
    }

    /**
     * @param BookingSmsServices $services
     * @param BookingChick $booking
     * @return JsonResponse
     */
    public function resendSms(BookingSmsServices $services,BookingChick $booking)
    {
        $data = $this->services->smsResendDelivered($services,$booking);

        return jsonSuccess(trans("home.alert_message_sent"),$data);
    }


    /**
     * @param Request $request
     * @param bookingServices $booking
     * @return JsonResponse
     */
    public function delivered(Request $request,bookingServices $booking)
    {
        return jsonSuccess(trans("balances.alert_success_transaction"), $booking->delivered($request));
    }

    /**
     * redirect route to user page profile
     *
     * @param $data
     * @return string
     */
    private function userLink($data)
    {
        return "<a class='info-color' href='" . route("users.show",$data->user->id) . "'>" . $data->user->name() . "</a>";
    }

    /**
     * @param $data
     * @return string
     */
    private function btnResendSms($data)
    {
        if (!$data->is_came && $data->isAfterHour())
            return "<button class='btn btn-dark info-color btn-resend' data-id='$data->id' data-phone='$data->phone' title='".trans("$this->trans.resend_sms")."'><i class='fas fa-sms'></i></button>";
    }


    /**
     * @param $data
     * @return string
     */

    private function btnTransaction($data)
    {
        $trans = trans("balances.balance",['name' => $data->client->name]);

        return "<button class='btn btn-success btn-transaction' 
                        data-booking='$data->id' 
                        data-client='$data->client_id' 
                        data-name='$trans'
                        title='".trans("balances.transactions")."'><i class='fas fa-file-invoice-dollar'></i></button>";
    }

    /**
     * @param $data
     * @return string
     */
    private function btnDelivered($data)
    {
        if ( $data->order->is_came && ! $data->is_came) {

            $perm = user_can("update $this->perm") ? "btn-delivered" : "disabled";

            return "<button class='btn btn-secondary $perm'
                           data-booking-id='$data->id' 
                           data-deliveredName='".$data->client->name."'
                           data-chickPrice='".$data->order->chick_price."'
                           data-totalPrice='".$data->order->chick_price * $data->quantity."'
                           data-net='".(($data->order->chick_price * $data->quantity) - $data->deposit)."'
                           data-deliveredQuantity='$data->quantity'
                           data-delivered-deposit='$data->deposit'
                           title='".trans("$this->trans.delivered")."'><i class='fa fa-truck-loading'></i></button>";
        }
    }

    /**
     * @param $data
     * @return string
     */
    private function btnUpdate($data)
    {
        $permission =  user_can("update $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $permission' 
                        data-id='$data->id'
                        data-client-id='{$data->client->id}'
                        data-name='{$data->client->name}'
                        data-phone='{$data->client->phone}'
                        data-deposit='$data->deposit'
                        data-order-id='$data->order_id'
                        data-chick-id='$data->chick_id'
                        data-quantity='$data->quantity'
                        title='". trans("home.update") ."'><i class='fa fa-edit'></i></button>";
    }

    /**
     * @param $data
     * @return string
     */
    private function btnDelete($data)
    {

        $permission =  user_can("delete $this->perm") ? "btn-delete" : "disabled";

        return "<button class='btn btn-danger $permission' 
                        data-url='" . route("chicks.booking.destroy", $data->id) . "'
                        data-name='" . $data->client->name . " '
                        data-token='" . csrf_token()  . "'
                        data-title='" . trans("$this->trans.alert_confirm_delete") . "'
                        data-text='" . trans( "$this->trans.alert_delete", [ 'name' => $data->client->name ] ) . "'
                        title='". trans("home.delete") ."'><i class='fa fa-trash'></i></button>";
    }


}
