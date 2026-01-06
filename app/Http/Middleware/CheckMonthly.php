<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class CheckMonthly {
    
    public function handle(Request $request, Closure $next): Response {

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Por favor, faça login para continuar!');
        }

        if ($user->created_at->greaterThanOrEqualTo(now()->subDays(7)) || $user->type === 'admin' || $user->type === 'collaborator') {
            return $next($request);
        }

        if ($user->invoices->where('payment_status', 'PENDING')->where('payment_due_date', '>=', now())->count() > 0) {
            return redirect()->route('user', ['uuid' => $user->uuid])->with('infor', 'Você possui uma fatura pendente, por favor realize o pagamento para continuar usando os serviços!');
        }

        if ($user->hasActiveSubscription()) {
            return $next($request);
        }

        return redirect()->route('buy')->with('infor', 'Você precisa de uma assinatura ativa para continuar usando os serviços!');
    }
}
