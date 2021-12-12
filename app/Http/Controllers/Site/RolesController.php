<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.roles.index",[
            'title' => trans("roles.title"),
            'roles' => Role::all(),
            'permissions' => Permission::with("roles")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.roles.create",[
            'title' => trans("roles.create_title"),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $data = $this->validate(request(),[
            'name' => 'required',
            'name_ar' => 'required',
        ]);
        $data['guard_name'] = 'admin';
        Role::create($data);
        return back()->with("success", trans("roles.success_create"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(admin_url("roles"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($role = Role::with("permissions")->find($id)){
            return view("admin.roles.update",[
                'title' => trans("roles.edit_title"),
                'role' => $role
            ]);
        }
        return redirect(admin_url("roles"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id)
    {
        if ($role = Role::with("permissions")->find($id)){
            $role->update($this->validate(request(),[
                'name' => 'required',
                'name_ar' => 'required',
            ]));
            return back()->with("success", trans("roles.success_update"));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($role = Role::with("permissions")->find($id)){
            $role->delete();
            echo json(null,1,"success");
        }
    }
}
