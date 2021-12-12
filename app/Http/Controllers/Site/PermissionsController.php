<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
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
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.roles.permissions.create",[
            'title' => trans("roles.permission_create_tile"),
            'roles' => old("role_id") ? Role::where("id" , "!=", old("role_id"))->get() : Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        Role::findByName(request("role_id"))->givePermissionTo(
            Permission::create($this->validate(request(),[
                'name' => 'required',
                'name_ar' => 'required',
            ]))
        );
        return back()->with("success", trans("roles.permission_success_create"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($permission = Permission::with("roles")->find($id)){

            return view("admin.roles.permissions.update",[
                'title' => trans("roles.Permission_Title_Update"),
                'permission' => $permission,
                'role' => Role::findById($this->getRoleId($permission)),
                'roles' =>  old("role_id")
                    ? Role::where("id" , "!=", old("role_id"))->where("id","!=",$this->getRoleId($permission))->get()
                    : Role::where("id","!=",$this->getRoleId($permission))->get()
            ]);
        }
        return redirect(admin_url("permissions"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id)
    {
        if ($permission = Permission::with("roles")->find($id)){
            $permission->update($this->validate(request(),[
                'name' => 'required',
                'name_ar' => 'required',
            ]));
            if ($this->getRoleId($permission) !== request("role_id")){
                Role::findById(request("role_id"))->givePermissionTo($permission);
            }
            return back()->with("success", trans("roles.Permission_Updated"));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($permission = Permission::find($id)){
            $permission->delete();
            echo json(null,1,"success");
        }
    }

    private function getRoleId($permission)
    {
        foreach ($permission->roles as $role)$role_id = $role->id;
        return $role_id;
    }

    public function search($keyword)
    {

        if (request()->ajax()){
            if ($keyword){
                $permissions = Permission::where("name" , "LIKE", "%$keyword%")->orWhere("name_ar","LIKE","%$keyword%")->get();

                $arr =[];
                if ($permissions->count() > 0) {
                    foreach ($permissions as $permission)
                        $arr[$permission->id] = json("$permission->name($permission->name_ar)");
                }else
                    $arr = trans("roles.permissions_not_founded");
                return json($arr);
            }
            return json("",404,trans("roles.Error"));
        }
            return json("",404,trans("roles.Error"));
    }
}
