<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PermissionGate
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
        $user = Auth::user();

        if (!app()->runningInConsole() && $user) {
            $roles = Role::with(['permissions'])->get();
            $permissionArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permission) {
                    $permissionArray[$permission->name][] = $role->id;
                }
            }

            foreach ($permissionArray as $permissionName => $roleArray) {
                Gate::define($permissionName, function (User $user) use ($roleArray) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $roleArray)) > 0;
                });
            }
        }

        return $next($request);
    }
}
