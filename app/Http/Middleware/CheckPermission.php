<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $per = null): Response
    {
        $roles = User::find(auth()->id())->roles()->select('roles.id')->pluck('id');
        $permission = DB::table('roles')
        ->join('permission_role','roles.id','=','permission_role.role_id')
        ->join('permissions','permission_role.permission_id','=','permissions.id')
        ->whereIn('roles.id',$roles)
        ->select('permissions.*')
        ->get()->pluck('id')->unique();
        $checkPermission = Permission::where('name',$per)->value('id');
        if($permission->contains($checkPermission)){
            return $next($request);
        }else{
            return redirect()->route('403');
        }
    }
}
