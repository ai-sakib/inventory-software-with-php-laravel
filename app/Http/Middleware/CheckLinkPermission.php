<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Auth;
use DB;
use App\Models\MainMenu;
use App\Models\SubMenu;

class CheckLinkPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $except = array('get-active-menu');
        $route = explode('/',Route::current()->uri)[0];
        if(!in_array($route, $except)){
            $subMenu = SubMenu::where('link',$route)->first();

            $role_id = Auth::user()->role_id;
            $allSubMenuArray = array();

            $allSubMenusForRole = DB::table('sub_menu_permission')->where('role_id',$role_id)->get();

            if(isset($allSubMenusForRole[0]->id)){
                foreach ($allSubMenusForRole as $value) {
                    array_push($allSubMenuArray, $value->sub_menu_id);
                }
                if($role_id == 1){
                    if(Auth::id() != 1){
                        $exTraSubMenu = SubMenu::where('main_menu_id',5)->get();
                    }else{
                        $exTraSubMenu = SubMenu::whereIn('main_menu_id',[4,5])->get();
                    }
                    if(isset($exTraSubMenu[0]->id)){
                        foreach ($exTraSubMenu as $value) {
                            array_push($allSubMenuArray, $value->id);
                        }
                    }
                }
                
                if(in_array($subMenu->id, $allSubMenuArray)){
                    return $next($request);
                }else{
                    session()->flash('error','You do not have the permission to this link !');
                    return redirect('/');
                }
            }else{
                session()->flash('error','You do not have the permission to this link !');
                    return redirect('/');
            }
        }else{
            return $next($request);
        }
    }
}
