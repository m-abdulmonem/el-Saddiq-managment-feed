<?php

namespace App\Http\Controllers\Site\Clients;

use App\Http\Requests\Clients\Client\CreateRequest;
use App\Http\Requests\Clients\Client\UpdateRequest;
use App\Models\Product\ProductStock;
use App\Services\Clients\ClientsServices;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Client\Client;
use Illuminate\Http\Response;
use Exception;


class ClientsController extends Controller
{
    protected $perm = "client";

    protected $trans = "clients/clients";

    protected $folder = "site.clients";

    /**
     * @var Client
     */
    private $client;
    /**
     * @var ClientsServices
     */
    private $clientsServices;

    /**
     * ClientsController constructor.
     *
     * @param Client $client
     * @param ClientsServices $clientsServices
     */
    public function __construct(Client $client, ClientsServices $clientsServices)
    {
        $this->client = $client;
        $this->clientsServices = $clientsServices;

        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
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
     * @return Response
     */
    public function create()
    {
        $data = [
            'title' => trans("$this->trans.create"),
            'trans' => $this->trans
        ];

        return  view("$this->folder.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @param ClientsServices $client
     * @return Response
     */
    public function store(CreateRequest $request,ClientsServices $client)
    {
        $text = trans("home.alert_success_create",['name' => $request->name ]);

        return jsonSuccess($text, $client->createWithCode($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param ClientsServices $client
     * @return RedirectResponse
     */
    public function show(ClientsServices $client)
    {
        $data = [
            'title' => trans("$this->trans.view", ['name' => $client->name()]),
            'client'=> $client,
            'trans' => $this->trans,
        ];
        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ClientsServices $client
     * @return void
     */
    public function edit(ClientsServices $client)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param ClientsServices $client
     * @return Response
     */
    public function update(UpdateRequest $request, ClientsServices $client)
    {
        return jsonSuccess( trans("home.alert_success_update"), $client->update($request->all()) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ClientsServices $client
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ClientsServices $client)
    {
        return $client->removeRecorder();
    }
}
