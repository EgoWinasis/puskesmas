<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfile
{
    public function handle($request, Closure $next)
    {
        $user =  Auth::user();
        
        if ($user->image != 'user.png' && $user->jabatan != '-' && $user->nip != '-') {
            return $next($request); 
        }
        
        // Redirect or handle unauthorized access here
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
