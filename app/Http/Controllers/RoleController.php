<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Pages;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('pages.indexRoles',compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages  = Pages::get();
        $data   = $pages;
        return view('pages.formRoles',compact('data'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, 
        [
            'inputName'     => 'required|unique:roles,name',
            'permission'    => 'required',
        ],
        [
            'inputName.unique'      => 'Nama roles sudah ada',
            'permission.required'   => 'Silakan pilih permission',
        ]);
    
        $permissions = $request->input('permission');
    
        foreach ($permissions as $permission) {
            $check      = Permission::where('name','=',ucwords($permission));
            if ($check->count() < 1) {
                Permission::create(['name' => $permission]);
            }
        }

        $role = Role::create(['name' => $request->input('inputName')]);
        $role->syncPermissions($request->input('permission'));
    
        $response   = array('status' => 200,'message' => 'Role created successfully.','success' => 'OK','location' => '/roles/index');
        echo json_encode($response);
    }
    public function addPages(Request $request)
    {
        $check      = Pages::where('name','=',ucwords($request->input('inputNamePages')));
        if ($check->count() > 0) {
            $response       =   array('status' => 400,'message' => 'Data is store.','success' => 'Error','location' => '/roles/create');
        } else {
            $pages      = Pages::create(['name' => ucwords($request->input('inputNamePages')),'url' => $request->input('inputUrlPages')]);
            $response   = array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/roles/create');
        }
        echo json_encode($response);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data   = Pages::get();
        $role   = Role::find($id)->get();
        $permission         = Permission::get();
        $rolePermissions    = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
        return view('pages.formRoles',compact('data','role','permission','rolePermissions'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, 
        [
            'inputName'     => 'required',
            'permission'    => 'required',
        ],
        [
            'inputName.required'    => 'Nama roles harus di isi',
            'permission.required'   => 'Silakan pilih permission',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('inputName');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));

        $response   = array('status' => 200,'message' => 'Role updated successfully.','success' => 'OK','location' => '/roles/index');
        echo json_encode($response);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        $response   = array('status' => 200,'message' => 'Role deleted successfully.','success' => 'OK','location' => '/roles/index');
        echo json_encode($response);
    }
}
