<?php

namespace App\Http\Controllers\Ajax\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Category\CategoryServices;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{


    protected $trans = "categories";

    protected $perm = "category";
    /**
     * @var Category
     */
    private $category;
    /**
     * @var CategoryServices
     */
    private $services;

    /**
     * CategoriesController constructor.
     *
     * @param Category $category
     * @param CategoryServices $services
     */
    public function __construct(Category $category, CategoryServices $services)
    {
        $this->category = $category;
        $this->services = $services;
    }

    /**
     * get all categories
     *
     * @return mixed
     * @throws \Exception
     */
    public function index()
    {
        if (request()->ajax())
            return datatables()->of( Category::latest()->get())
                ->addIndexColumn()
                ->addColumn("details",function ($data){
                    return $data->details;
                })
                ->addColumn("related",function ($data){
                    $perm = user_can("read product")  ? "btn-info" : "disabled";

                    return "<a class='btn $perm' href='".route("products.index",['c'=>$data->id])."'>".trans("$this->trans.show_related")."</a>";
                })
                ->addColumn('action', function($data){

                    $btn = $this->btnUpdate($data);

                    $btn .= btn_delete($this->perm,"categories",$data);

                    return $btn;
                })
                ->rawColumns(['action','related',"image"])
                ->make(true);
    }


    /**
     * button update
     *
     * @param $data
     * @return string
     */
    private function btnUpdate($data)
    {
        $perm = user_can("update $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $perm'
                       data-id='$data->id' 
                       data-name='$data->name'
                       data-details='$data->details'><i class='fa fa-edit'></i></button>";
    }
    
}
