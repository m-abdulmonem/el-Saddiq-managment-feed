<?php

namespace App\Http\Controllers\Site\Chicks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chicks\Chick\CreateRequest;
use App\Http\Requests\Chicks\Chick\UpdateRequest;
use App\Models\Chick\Chick;
use App\Services\Chicks\ChicksServices;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChicksController extends Controller
{

    protected $folder = "site.chicks";

    protected $trans = "chicks/chicks";

    protected $perm = "chick";
    /**
     * @var Chick
     */
    private $chick;
    /**
     * @var ChicksServices
     */
    private $services;


    public function __construct(Chick $chick, ChicksServices $services)
    {

        $this->services = $services;
        $this->chick = $chick;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans
        ];

        return view("$this->folder.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        return $this->chick->createRecord($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param ChicksServices $chick
     * @return Application|Factory|View
     */
    public function show(ChicksServices $chick): View|Factory|Application
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'chick' => $chick,
            'services' => $this->services,
            'trans' => $this->trans,
        ];

        return view("$this->folder.view", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Chick $chick
     * @return void
     */
    public function edit(Chick $chick): void
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Chick $chick
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Chick $chick): JsonResponse
    {
        return $chick->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Chick $chick
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Chick $chick): JsonResponse
    {
        return $chick->removeRecorder();
    }

}
