<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Lütfen önce giriş yapınız.');
        }
        
        if (!auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Bu sayfaya erişim yetkiniz yok. Yalnızca admin kullanıcıları erişebilir.');
        }

        return $next($request);
    }
}
