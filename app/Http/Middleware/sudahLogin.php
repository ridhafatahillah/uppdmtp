<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class sudahLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->role == 1) {
                return redirect()->route('admin');
            } elseif (auth()->user()->role == 0) {
                return redirect('/')->withErrors(
                    ['sudahLogin' => 'Anda sudah login']
                );
            } else {
                return redirect('aaa');
            }
        }
        return $next($request);
    }
}
