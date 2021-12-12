<?php

namespace App\Http\Controllers\Site\Chicks;

use App\Http\Requests\Chicks\Chick\CreateRequest;
use App\Http\Requests\Chicks\Chick\UpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Chick\Chick;
use App\Services\Chicks\ChicksServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

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


    public function __construct(Chick $chick,ChicksServices $services)
    {

        $this->services = $services;
        $this->chick = $chick;

        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("$this->folder.index",[
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request)
    {
        return $this->chick->createRecord($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param ChicksServices $chick
     * @return Response
     */
    public function show(ChicksServices $chick)
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'chick'=> $chick,
            'services'=> $this->services,
            'trans' => $this->trans,
        ];
        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Chick $chick
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Chick $chick)
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
    public function destroy(Chick $chick)
    {
        return $chick->removeRecorder();
    }

}
