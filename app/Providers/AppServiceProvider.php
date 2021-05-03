<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Pages;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $pages  = Pages::get();dd(Auth::check());
        // $id     = Auth::user();dd($id);
        // $akses  = DB::table('model_has_roles')->join('users', 'users.id', '=', 'model_has_roles.model_id')->where('users.uniqID_user',$id)->get(); 
        // foreach ($akses as $key => $value) {
        //     if ($value->role_id==1) {
        //         $pages  = Pages::get();
        //     }
        // }
    }
}
