<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RestrictSuperAdminDataAccess
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
        $routePath = $request->path();
        $method = $request->method();

        $conditionsForRoleInPermissions=($method === "GET" && $routePath === "admin/role-in-permissions/1/edit")
        || ($method === "POST" && $routePath === "admin/role-in-permissions/1")
        || ($method === "DELETE" && $routePath === "admin/role-in-permissions/1");

        $conditionsForAdminManage=($method === "GET" && $routePath === "admin/admin-manage/1/edit")
        || ($method === "POST" && $routePath === "admin/admin-manage/1")
        || ($method === "DELETE" && $routePath === "admin/admin-manage/1");


        if ($conditionsForRoleInPermissions) {
            return to_route("admin.role-in-permissions.index", [
                "page" => $request->page,
                "per_page" => $request->per_page,
                "sort" => $request->sort,
                "direction" => $request->direction,
            ])->with("error", "Cannot access data related to super admin role.");
        }

        if ($conditionsForAdminManage) {
            return to_route("admin.admin-manage.index", [
                "page" => $request->page,
                "per_page" => $request->per_page,
                "sort" => $request->sort,
                "direction" => $request->direction,
            ])->with("error", "Cannot access data related to super admin.");
        }

        return $next($request);
    }
}
