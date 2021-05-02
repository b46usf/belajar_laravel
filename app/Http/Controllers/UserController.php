<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5); // dd($data);
        return view('pages.indexUsers',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('uniqID_user','=',$id)->get();
        $roles = Role::pluck('name','name')->all();
        return view('pages.formUsers',compact('user','roles'));
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
            'inputroles' => 'required',
            'inputactivated' => 'required',
        ],
        [
            'inputroles.required'    => 'Masukan Pilihan Roles',
            'inputactivated.required'   => 'Masukan Pilihan Activated',
        ]);
    
        $input = $request->all();
        $user = User::where('uniqID_user','=',$id)->get();
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('inputroles'));

        $response   = array('status' => 200,'message' => 'User updated successfully.','success' => 'OK','location' => '/pages/indexUsers');
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
        User::where('uniqID_user','=',$id)->delete();
        
        $response   = array('status' => 200,'message' => 'User deleted successfully.','success' => 'OK','location' => '/pages/indexUsers');
        echo json_encode($response);
    }
}
