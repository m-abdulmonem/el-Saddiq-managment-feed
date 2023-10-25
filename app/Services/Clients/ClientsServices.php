<?php


namespace App\Services\Clients;

use App\Http\Requests\Chicks\Booking\CreateRequest;
use App\Models\Chick\ChickOrder;
use App\Models\Client\Client;
use App\Services\Sms\SmsServices;
use function Composer\Autoload\includeFile;
use Exception;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Collection;

class ClientsServices extends Client
{

    /**
     * sort product by type
     *
     * @param $request
     * @return Collection
     */
    public function sortProducts($request)
    {
        if ($request->type == "sold_product")
            return $this->bySoldProduct();
        elseif ($request->type == "discarded_product")
            return $this->byReturnedProducts();
        else
            return $this->bySoldProduct()->merge($this->byReturnedProducts());
    }


    /**
     * get sold products
     *
     * @return Collection
     */
    public function bySoldProduct()
    {
        $products = mapArray($this->bills, function ($c, $bill) {
            $c->push($bill->products()->latest()->get()); });

        return mapArray($products, function ($c, $products) {
            foreach ($products as $product)
                $c->push($product);

            return $c;
        });
    }

    /**
     * get returned products
     *
     * @return Collection
     */
    public function byReturnedProducts()
    {
        $products = mapArray($this->returnBills, function ($c, $bill) {
            $c->push($bill->products()->latest()->get()); });

        return mapArray($products, function ($c, $products) {
            foreach ($products as $product)
                $c->push($product);
            return $c;
        });
    }

    /**
     *
     * @param $type
     * @return mixed
     */
    public function byType($type)
    {
        if ($type)
            return $this->where("trader", $type)->latest()->get();

        return $this->latest()->get();
    }

    /**
     * create new recorder with
     * automatically set code
     *
     * @param $data
     * @return mixed
     */
    public function createWithCode($data)
    {
        $data = array_merge($data, ['code' => $this->code(), 'is_trader' => ($data['trader'] == "true")]);

        return $this->create($data);
    }


    /**
     * @param CreateRequest $request
     * @return mixed
     */
    public function findOrNew(CreateRequest $request)
    {
        $fields = [
            'name' => $request->name,
            'phone' => $request->phone
        ];

        return !($client = $this->isExists($request->client_id)) ? $this->createWithCode($fields) : $client;
    }


    /**
     * get client debt
     *
     * @return string
     */
    public function creditor()
    {
        return (($debt = $this->totalPaid() - $this->totalBills()) < 0) ? removeMines($debt) : 0;
    }

    /**
     * get client debt
     *
     * @return string
     */
    public function debtor()
    {
        return (($debt = $this->totalPaid() - $this->totalBills()) > 0) ? $debt : 0;
    }

    /**
     * get remaining balances of client
     *
     * @return int
     */
    public function remaining()
    {
        return $this->totalPaid() - $this->totalBills();
    }

    public function prevBalance()
    {
        return (($balance = $this->totalPaidOfInvoices() - $this->totalBills()) < 0) ? removeMines($balance) : 0;
    }

    /**
     * get latest bill date
     *
     * @return string
     */
    public function latestBill()
    {
        return ($bill = $this->bills()->latest()->first()) ? $bill->created_at->format("Y-m-d") : "-";
    }

    /**
     * get total price of all client bill
     *
     * @param null $ids
     * @return int
     */
    public function totalBills($ids = null)
    {
        return ($ids)
            ? (int)$this->bills()->find($ids)->sum("price")
            : (int)$this->bills()->sum("price");
    }

    /**
     * gte total paid of invoices or get by bill id
     *
     * @param array $ids
     * @return int
     */
    public function totalPaidOfInvoices(array $ids = null)
    {
        return $ids
            ? (int)$this->balance()->whereIn("bill_id", $ids)->where("type", "catch")->whereNull("booking_id")->sum("paid")
            : (int)$this->balance()->where("type", "catch")->whereNull("booking_id")->sum("paid");
    }

    /**
     * get total paid of client
     *
     * @return int
     */
    public function totalPaid()
    {
        return (int)$this->balance()->where("type", "catch")->sum("paid");
    }



    /**
     * get latest total price of latest bill
     *
     * @return string
     */
    public function latestBalance()
    {
        return currency((($balance = $this->balance()->latest()->first()) ? $balance->total_price : 0));
    }


    /*
     * Graph
     */
    /**
     * get all invoices dates
     *
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function invoicesDate($start = null, $end = null)
    {
        if ($start || $end) {
            $bills = $this->bills()->whereBetween("created_at", [startDate($start), endDate($end)])->pluck("created_at")->toArray();
            $return = $this->returnBills()->whereBetween("created_at", [startDate($start), endDate($end)])->pluck("created_at")->toArray();
        }
        else {
            $bills = $this->bills()->pluck("created_at")->toArray();
            $return = $this->returnBills()->pluck("created_at")->toArray();
        }

        return collect($bills)->merge($return)->map(function ($v) {
            return $v->format("Y-m-d"); })->unique()->sort();
    }

    /**
     * get products quantity report dates
     *
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function quantityDate($start = null, $end = null)
    {
        if ($start || $end) {
            $products = $this->bySoldProduct()->whereBetween("pivot.created_at", [startDate($start), endDate($end)])->pluck("pivot.created_at");
            $returned = $this->byReturnedProducts()->whereBetween("pivot.created_at", [startDate($start), endDate($end)])->pluck("pivot.created_at");
        }
        else {
            $products = $this->bySoldProduct()->pluck("pivot.created_at");
            $returned = $this->byReturnedProducts()->pluck("pivot.created_at");
        }

        return collect($products->map(function ($date) {
            return $date->format("Y-m-d"); })->unique()->toArray())
            ->merge($returned->map(function ($date) {
            return $date->format("Y-m-d"); })->unique()->toArray())
            ->unique()->sort()->toArray();
    }

    /**
     * get most requested products report dates
     *
     * @return Collection
     */
    public function consumptionProductsIds()
    {
        $callback = function ($data, $product) {
            return $data->put($product->name(), $product->id);
        };
        return mapArray($this->bySoldProduct(), $callback);
    }

    /**
     * get booking report dates
     *
     * @param null $start
     * @param null $end
     * @return Collection
     */
    public function BookingDate($start = null, $end = null)
    {
        $bills = ($start || $end) ? $this->booking()->whereBetween("created_at", [startDate($start), endDate($end)]) : $bills = $this->booking();

        return $bills->pluck("created_at")->map(function ($v) {
            return $v->format("Y-m-d"); })->unique()->sort();
    }

    /**
     * get booking quantity report dates
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function bookingQuantityDates($start = null, $end = null)
    {
        $products = ($start || $end)
            ? $this->booking()->whereBetween("created_at", [startDate($start), endDate($end)])->pluck("created_at")
            : $this->booking()->pluck("created_at");

        return $products->map(function ($date) {
            return $date->format("Y-m-d"); })->sort()->unique()->toArray();
    }

    /**
     * get most  requested chicks report dates
     *
     * @return Collection
     */
    public function consumptionChicksIds()
    {
        $callback = function ($data, $booking) {
            return $data->put($booking->chick->name, $booking->chick_id);
        };
        return mapArray($this->booking, $callback);
    }

    /**
     * get income statement report dates
     *
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function gainLossDates($start = null, $end = null)
    {
        if ($start || $end) {
            $products = $this->clientProduct()->whereBetween("created_at", [startDate($start), endDate($end)])->pluck("created_at");
            $booking = $this->booking()->where("is_came", true)->whereBetween("created_at", [startDate($start), endDate($end)])->pluck("created_at");
        }
        else {
            $products = $this->clientProduct()->pluck("created_at");
            $booking = $this->booking()->where("is_came", true)->pluck("created_at");
        }

        return collect($products)->merge($booking)->map(function ($date) {
            return $date->format("Y-m-d"); })->unique();
    }

    /**
     * get all count of invoices by dates
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function invoicesGraph($start = null, $end = null)
    {
        $data = [];
        foreach ($this->invoicesDate($start, $end) as $date) {
            $invoices = $this->bills()->whereBetween("created_at", [startDate($date), endDate($date)]);

            $returned = $this->returnBills()->whereBetween("created_at", [startDate($date), endDate($date)]);

            $data[$date] = [$invoices->count(), -$returned->count()];
        }
        return $data;
    }

    /**
     * get quantity of products report
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function quantityGraph($start = null, $end = null)
    {
        $data = [];
        foreach ($this->quantityDate($start, $end) as $date) {
            $invoices = $this->bills()->whereBetween("created_at", [startDate($date), endDate($date)]);

            $returned = $this->returnBills()->whereBetween("created_at", [startDate($date), endDate($date)]);

            $data[$date] = [$invoices->sum("quantity"), -$returned->sum("quantity")];
        }
        return $data;
    }

    /**
     * get most requested products report
     *
     * @param $start
     * @param $end
     * @return callable|Collection
     */
    public function consumptionGraph($start, $end)
    {
        $callback = function ($data, $name, $id) use ($start, $end) {
            $product = $this->bySoldProduct()->where("id", $id);

            $quantity = ($start || $end) ? $product->whereBetween("pivot.created_at", [startDate($start), endDate($end)]) : $product;

            return $data->put($name, [$quantity->sum("pivot.quantity"), rand_color(true)]);
        };

        return eachData($this->consumptionProductsIds(), $callback);
    }

    /**
     * get chicks booking report
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function bookingGraph($start = null, $end = null)
    {
        $data = [];
        foreach ($this->BookingDate($start, $end) as $date)
            $data[$date] = [$this->booking()->whereBetween("created_at", [startDate($date), endDate($date)])->count()];

        return $data;
    }

    /**
     * get booking quantity report
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function bookingQuantityGraph($start = null, $end = null)
    {
        $data = [];
        foreach ($this->bookingQuantityDates($start, $end) as $date)
            $data[$date] = [$this->booking()->whereBetween("created_at", [startDate($date), endDate($date)])->sum("quantity")];
        return $data;
    }

    /**
     * get most chicks requested from client
     *
     * @param null $start
     * @param null $end
     * @return callable|Collection
     */
    public function chicksConsumptionGraph($start = null, $end = null)
    {
        $callback = function ($data, $name, $id) use ($start, $end) {
            $booking = $this->booking()->where("chick_id", $id);

            $quantity = ($start || $end) ? $booking->whereBetween("created_at", [startDate($start), endDate($end)]) : $booking;

            return $data->put($name, [$quantity->sum("quantity"), rand_color(true)]);
        };

        return eachData($this->consumptionChicksIds(), $callback);
    }

    /**
     * get income statement report
     *
     * @param null $start
     * @param null $end
     * @return Collection
     */
    public function gainLossGraph($start = null, $end = null)
    {
        $callback = function ($c, $date) {
            $products = $this->clientProduct()->whereBetween("created_at", [startDate($date), endDate($date)]);
            foreach ($products->get() as $product) {
                $gain = ($product->piece_price - $product->purchase_price) * $product->quantity;
                $loss = ($loss = $this->totalPaidOfInvoices($products->pluck("bill_id")->toArray()) - $this->totalBills($products->pluck("bill_id")));
                $gainLoss = $loss < 0 ? ['gain' => 0, 'loss' => $loss] : ['gain' => $gain, 'loss' => 0];
                $c->put($date, $gainLoss);
            }

        };
        return mapArray($this->gainLossDates($start, $end), $callback);
    }


    /**
     * get client data
     *
     * @param $id
     * @return mixed
     */
    public function isExists($id)
    {
        return $this->find($id);
    }


    /**
     * search in clients name only
     *
     * @param $keyword
     * @return mixed
     */
    public function searchName($keyword)
    {        //        $keywords = explode(" ", $keyword);
//
//        $keywords = count($keywords) == 1 ? strlen($keywords[0]) : null;
//
//        return (is_array($keywords)) ? $this->whereIn("name",$keywords)->get() :
        return $this->where("name", "like", "%$keyword%")->get();
    }

    /**
     * get latest client code
     *
     * @return int
     */
    public function code()
    {
        return 22 . ($this->count() + 1);
    }


    public function getCode()
    {
        return $this->code;
    }


    /**
     * get client account type
     *
     * @return array|Translator|string|null
     */
    public function type()
    {
        return trans("clients/clients.option_" . ($this->is_trader ? "trader" : "customer"));
    }


    public function scopeCreditDaysLimit($q)
    {
        foreach ($this->all() as $client) {
            if ($balance = $client->balance()->latest()->first()) {
                if ($client->creditor() > 0
                && $client->balance()->latest()->first()->created_at->diffInDays(now()) >= $client->maximum_repayment_period) {
                    $text = trans("clients/clients.alert_credit_days_limit");
                    // return SmsServices::createClientSms(nexmo($this->client->phone, $text), $this->client_id);
                }
            }
        }
    }


}
