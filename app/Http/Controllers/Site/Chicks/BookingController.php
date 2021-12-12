<?php

namespace App\Http\Controllers\Site\Chicks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chicks\Booking\CreateRequest;
use App\Http\Requests\Chicks\Booking\UpdateRequest;
use App\Models\Chick\BookingChick;
use App\Models\Sms;
use App\Services\Chicks\bookingServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $folder = "site.chicks.booking";

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


    public function __construct(BookingChick $booking, bookingServices $services)
    {
        $this->booking = $booking;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @param bookingServices $booking
     * @return JsonResponse
     */
    public function store(CreateRequest $request, bookingServices $booking)
    {
        return $booking->createWithCode( $request );
    }

    /**
     * Display the specified resource.
     *
     * @param BookingChick $booking
     * @return RedirectResponse
     */
    public function show(BookingChick $booking)
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'booking'=> $booking,
            'trans' => $this->trans,
        ];

        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param BookingChick $booking
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, BookingChick $booking)
    {
        return $booking->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BookingChick $booking
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(BookingChick $booking)
    {
        $booking->order()->update([
            'quantity' => $booking->order->quantity - $booking->quantity
        ]);
        return $booking->removeRecorder( $this->trans );
    }

}
