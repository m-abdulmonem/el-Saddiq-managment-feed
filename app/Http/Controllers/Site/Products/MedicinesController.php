<?php

namespace App\Http\Controllers\Site\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\Medicines\CreateRequest;
use App\Http\Requests\Products\Medicines\UpdateRequest;
use App\Models\Product\Medicine;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MedicinesController extends Controller
{
    protected $folder = "site.products.medicines";
    protected $trans = "products/medicines";
    protected $perm = "medicine";

    public function __construct()
    {
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
            'trans' => $this->trans,
            'perm' => $this->perm
        ];
        return view("$this->folder.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @param Medicine $medicine
     * @return Response
     */
    public function store(CreateRequest $request, Medicine $medicine)
    {
        return $medicine->createWith($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Medicine $medicine
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Medicine $medicine)
    {
        return $medicine->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Medicine $medicine)
    {
        return $medicine->removeRecorder();
    }
}
