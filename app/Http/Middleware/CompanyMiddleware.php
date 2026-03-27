<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->company_id !== null && auth()->user()->role !== 'super_admin') {
            return $next($request);
        }

        abort(403, __('Неавторизиран пристап'));
    }
}
