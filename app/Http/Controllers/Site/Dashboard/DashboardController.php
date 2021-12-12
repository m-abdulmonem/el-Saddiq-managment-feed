<?php

namespace App\Http\Controllers\Site\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller
{

    protected $folder = "site.dashboard";


    /**
     * @return Factory|View
     */
    public function index()
    {
        $data = [
            'title' => trans("home.title")
        ];

        return view("$this->folder.index",$data);
    }
}
