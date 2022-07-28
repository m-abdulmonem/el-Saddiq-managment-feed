<?php


namespace App\Services\User;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserServices extends User
{

    /**
     * create new record with code
     *
     * @param $request
     * @return RedirectResponse
     */
    public function createWithCode($request)
    {
        $add = [
            'code' => $this->code(),
            'password' => Hash::make($request->password),
            'picture' => storeImage($request,"picture",'pictures')
        ];

        $data = $this->create(array_merge($request->toArray(),$add));

        $data->syncPermissions($request->permissions);

        return back()->with('success',trans("home.alert_success_create", ['name' => $data->name ] ) );
    }

    /**
     * update specific record
     *
     * @param $request
     * @return JsonResponse|RedirectResponse
     */
    public function updateRecord($request)
    {
        $add = [
            'picture' => updateImage($request,"picture",$this->image,'pictures')
        ];

        $this->update(array_merge($request->toArray(),$add));

        $this->syncPermissions($request->permissions);

        return back()->with('success',trans("home.alert_success_update") );
    }

    /**
     * get client invoices statics in [date,bills count of the date]
     *
     * @return array
     */
    public function clientBillsStatics()
    {
        $data = function ($c,$v){
            $date = $this->clientBills()->whereMonth("created_at",$v->format("m"))
                ->whereYear("created_at",$v->format("Y"))->count();

            return $c->put($v->format("Y-m-d"),$date);
        };

        return mapArray($this->clientBills()->pluck("created_at"),$data)->toArray();
    }

    /**
     * get client invoices return statics in [date,bills count of the date]
     *
     * @return array
     */
    public function clientBillsReturnStatics()
    {
        $data = function ($c,$v){
            $date = $this->clientBillsReturn()->whereMonth("created_at",$v->format("m"))
                ->whereYear("created_at",$v->format("Y"))->count();

            return $c->put($v->format("Y-m-d"),$date);
        };

        return mapArray($this->clientBillsReturn()->pluck("created_at"),$data)->toArray();
    }

    /**
     * get client invoices and client returned invoices statics in [date,bills count of the date]
     *
     * @return Collection
     */
    public function clientsBillsStatics()
    {
        return collect($this->clientBillsStatics())->merge($this->clientBillsReturnStatics());
    }

    /**
     * get supplier bills statics in [date,bills count of the date]
     *
     * @return array
     */
    public function supplierBillsStatics()
    {
        $data = function ($c,$v){
            $date = $this->supplierBill()->whereMonth("created_at",$v->format("m"))
                ->whereYear("created_at",$v->format("Y"))->count();

            return $c->put($v->format("Y-m-d"),$date);
        };

        return mapArray($this->supplierBill()->pluck("created_at"),$data)->toArray();
    }

    /**
     * get supplier bills return statics in [date,bills count of the date]
     *
     * @return array
     */
    public function supplierBillReturnStatics()
    {
        $data = function ($c,$v){
            $date = $this->supplierBillReturn()->whereMonth("created_at",$v->format("m"))
                ->whereYear("created_at",$v->format("Y"))->count();

            return $c->put($v->format("Y-m-d"),$date);
        };

        return mapArray($this->supplierBillReturn()->pluck("created_at"),$data)->toArray();

    }

    /**
     * get chicks booking statics in [dates=> count of date]
     * @return array
     */
    public function chicksBookingStatics()
    {
        $data = function ($c,$v){
            $date = $this->chicksBooking()->whereMonth("created_at",$v->format("m"))
                ->whereYear("created_at",$v->format("Y"))->count();

            return $c->put($v->format("Y-m-d"),$date);
        };

        return mapArray($this->chicksBooking()->pluck("created_at"),$data)->toArray();
    }

    /**
     * check if the user is this day is holiday || absence || attended
     *
     * @param $query
     */
    public function scopeIsAttended($query)
    {

        foreach ($this->where("is_active",true)->where("id","!=", 1)->get() as $user){

            $date = $user->attendances()->last($user->id) == now()->format("Y-m-d");
            $holidayDate = $user->attendances()->latestHoliday($user->id) == now()->format("Y-m-d");

            if (date("D") == $this->daysToEnglish(settings("holiday")))
                $user->attendances()->create([
                    'is_exist' => false,
                    'is_holiday' => true,
                    'date' => now()
                ]);

            if (count($user->attendances()->holidayByNow($user->id)) == 0 && !$holidayDate)
                foreach ($this->daysToEnglish($user->holidays) as $day){
                    if (date("D") == $day )
                        $user->attendances()->create([
                            'is_exist' => false,
                            'is_holiday' => true,
                            'date' => now()
                        ]);
                }
            else
                if (count($user->attendances()->byNow($user->id)) <= 0 && !$date && date("H") > 10)
                    $user->attendances()->create([
                        'is_exist'=> false,
                        'date' => now()
                    ]);
        }
    }

    /**
     * convert arabic days name to english name
     *
     * @param $data
     * @return array
     */
    public function daysToEnglish($data)
    {
        $inArabic = ['الاثنين','الثلاثاء','الاربعاء','الخميس','الجمعة','السبت','الاحد'];
        $inEnglish = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        $days = str_replace($inArabic,$inEnglish,explode(",",$data ?? ""));

        return array_map("ucfirst",$days);
    }


    public function monthly()
    {
        return $this->salaries()->whereNotNull("salary")
            ->whereYear("created_at",now()->format("Y"))
            ->whereMonth("created_at",now()->format("m"))
            ->latest();
    }
    public function daily()
    {
        return $this->salaries()->whereNotNull("salary")
            ->whereYear("created_at",now()->format("Y"))
            ->whereMonth("created_at",now()->format("m"))
            ->whereDay("created_at",now()->format("d"))
            ->latest();
    }

    public function isType($type)
    {
        return ($this->salary_type === $type);
    }


    public function isMonthlyPaid()
    {
        return ($salary = $this->monthly()->first())
            ? ($salary->created_at->diffInDays(now()) < 28)
            : false;
    }

    public function isDailyPaid()
    {
        return ($salary = $this->daily()->first())
            ? ($salary->created_at->diffInHours(now()) < 22)
            : false;
    }

    public function disabled()
    {
        if ($this->isType("monthly") && $this->isMonthlyPaid())
            return 1;
        else if ($this->isType("daily") && $this->isDailyPaid())
            return 1;
        else
            return 0;
    }

    public function calcSalary()
    {
        return ($this->isType("monthly"))
            ? $this->salary + $this->monthly()->sum("increase") - $this->monthly()->sum("discount")
            : $this->salary + $this->daily()->sum("increase") - $this->daily()->sum("discount");
    }

    public function a()
    {

    }

    /**
     * set code number to the new record
     *
     * @return int
     */
    public function code()
    {
        return $this->all()->count() +1 ;
    }

    /**
     * get client name with code
     *
     * @param $query
     * @return string
     */
    public function scopeName($query)
    {
        return num_to_ar( $this->code ) . " - $this->name";;
    }



}
