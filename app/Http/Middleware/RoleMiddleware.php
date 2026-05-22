<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // [cite: 481]
use Symfony\Component\HttpFoundation\Response; // [cite: 482]

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }
        if (!Auth::user()->hasAnyRole($roles)) {
            abort(403, 'Bu işlem için yetkiniz bulunmamaktadır.');
        }
        return $next($request);
    }
}
