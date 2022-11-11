<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;


use Closure;
use Illuminate\Http\Request;

class CheckJson
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
        if ($request->hasHeader('accept') &&  Str::lower($request->header('accept')) == 'application/json') {
            return $next($request);
        }

        return response()->json([
            'msg' => 'Your sended data must be a json type'
        ]);
    }
}
