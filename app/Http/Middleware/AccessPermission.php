<?php

namespace App\Http\Middleware;

use App\Models\Account;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class AccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $id = request()->cookie('id_customer');
        $account = Account::find($id);
        $role = Role::all();
        if($account->id_role == $role[0]->id_role){
            return $next($request);
        }else{
            return redirect()->route('admin.dashboard')->with('alertMiddleware','Bạn không có quyền để sử dụng chức năng này');
        }
    }
}
