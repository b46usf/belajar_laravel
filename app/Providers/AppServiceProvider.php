<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Link;
use Menu;

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
        view()->composer('*', function ($view) 
        {
            if (Auth::check()) {
                $akses  =   DB::table('model_has_roles')
                ->join('users', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('users.uniqID_user',Auth::user()->uniqID_user)->first();
                $permissions    =   
                DB::table('permissions')
                ->select(DB::raw("distinct SUBSTRING_INDEX(name, '-', 1) as pagepermission"))
                ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id', '=', $akses->role_id);
                $pages  =
                DB::table('pages')
                ->select(DB::raw('distinct pages.id,pages.name,pages.url'))
                ->joinSub($permissions, 'permissions', function ($join) {
                    $join->on('pages.name', '=', 'permissions.pagepermission');
                }); 
                $results    =   $pages->get();
                $view->with('pages', $results );
            }
        });
    }
}