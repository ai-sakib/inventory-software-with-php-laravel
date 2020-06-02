<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

class DeveloperOptionPermission
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
        $setup=DB::table('tbl_setup')->where('id','1')->first();
        if(isset($setup) && $setup->developer_mode=="1"){
            if(Auth::guard('admin')->user()->id=="1000"){
                return $next($request);
            }else{
                return redirect('returntohome');  
            }
        }else{
            return redirect('returntohome');
        }
    }
}
