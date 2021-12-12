<?php

namespace App\Http\Controllers\Ajax\Chicks;

use App\Http\Controllers\Controller;
use App\Models\Chick\Chick;
use App\Services\Chicks\ChicksServices;
use Illuminate\Http\Request;

class GraphController extends Controller
{

    /**
     * @var ChicksServices
     */
    private $services;

    /**
     * GraphController constructor.
     * @param ChicksServices $services
     */
    public function __construct(ChicksServices $services)
    {
        $this->services = $services;
    }

    /**
     * @param Chick $chick
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function prices(ChicksServices $chick,Request $request)
    {
        return jsonSuccess("prices statics",$chick->pricesStatics($request));
    }

    /**
     * @param Chick $chick
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function locations(ChicksServices $chick,Request $request)
    {
        return json(['text'=>"locations statics",'data'=>$chick->locationsStatics($request)]);
    }

}
