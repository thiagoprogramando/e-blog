<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin {
    
    public function handle(Request $request, Closure $next): Response {
        
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Faça login para acessar os benefícios da sua conta!');
        }

        if ($user->role == 'admin') {
            return $next($request);
        }

        return redirect()->route('app')->with('infor', 'Acesso negado!');
    }
}
