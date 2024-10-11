<?php

namespace App\Http\Controllers\Dashboard\Daillies;

use Illuminate\Http\Request;
use App\Models\Dailies\Daily;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DailliesControler extends Controller
{

    public function __construct(
        protected $folder = "site.dailies.daily",
        protected $trans = "dailies"
    ){
        $this->middleware("auth");
        $this->registerToday();
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Factory|View
     */
    public function __invoke(Request $request): Factory|View
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans
        ];

        return view("$this->folder.index", $data);
    }


    private function registerToday(): void
    {
        $daily = new Daily;

        if (!$daily->today())
            $daily->create([
                'number' => $daily->code(),
                'time_in' => now(),
                'user_id' => \auth()->id() ?: 1
            ]);
    }
}
