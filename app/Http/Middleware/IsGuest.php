<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() == FALSE ){
            //jika chek nya false atau belum login maka di perbolehkan akses
            return $next($request);
        }else{
            //jika true atau sudah login, balikin ke halaman homr
            return redirect()->route('home.page')->with('failed', 'GABISA AKSES WOI');
        }
        
    }
}
