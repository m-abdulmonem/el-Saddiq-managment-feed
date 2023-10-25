<?php

namespace App\Http\Controllers\Api\Ajax\Dailies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dailies\Daily;

class PrintDailyController extends Controller
{

    public function __construct(protected $folder = "site.dailies",protected $trans = "dailies")
    {

    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Daily $daily)
    {
        $data = [
            'trans' => $this->trans,
            'daily' => $daily->latest()->first(),
        ];
        return view("$this->folder.print.index",$data);
    }
}
