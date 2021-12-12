<?php

namespace App\Http\Controllers\Site\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoriesController extends Controller
{

    protected $folder = "site.categories";

    protected $trans = "products/categories";

    protected $perm = "category";
    /**
     * @var Category
     */
    private $category;


    public function __construct(Category $category)
    {
        $this->category = $category;

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
        $data =  [
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans,
            'perm' => $this->perm
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request)
    {
        return $this->category->createRecord($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $category
     * @return void
     */
    public function show($category)
    {

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
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Category $category)
    {
        return $category->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        return $category->removeRecorder();
    }


}
