<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Plan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BuyController extends Controller {
    
    public function index() {

        $plans = Plan::where('status', 1)->get();
        return view('app.Finance.Buy.index', [
            'plans' => $plans
        ]);
    }

    public function store(Request $request, $plan) {
        
        $plan = Plan::where('uuid', $plan)->first();
        if (!$plan) {
            return redirect()->back()->with('error', 'Plano indisponível!');
        }

        if (isset($plan) && $plan->time == 'lifetime') {
            $coupon = Coupon::where('code', $request->code)->first();
            if ($coupon) {
                if ($coupon->quantity > 0) {
                    $coupon->quantity -= 1;
                    if ($coupon->quantity == 0) {
                        $coupon->status = 2;
                    }
                    $coupon->save();
                } else {
                    return redirect()->back()->with('error', 'Cupom inválido ou expirado!');
                }
            } else {
                return redirect()->back()->with('error', 'Cupom inválido!');
            }
        }

        $invoice                    = new Invoice();
        $invoice->uuid              = Str::uuid();
        $invoice->user_id           = Auth::user()->id;
        $invoice->plan_id           = $plan->id;
        $invoice->title             = $plan->title;
        $invoice->description       = $plan->description;
        $invoice->payment_due_date  = now()->addDays(7);
        
        if ($plan->time !== 'lifetime') {
            $invoice->value = $plan->value;
            if ($invoice->save()) {
                Invoice::where('user_id', Auth::id())->where('payment_status', '!=', 'paid')->where('id', '!=', $invoice->id)->delete();
                return redirect()->back()->with('success', 'Parabéns, sua compra foi realizada com sucesso!'); 
            }
        } else {
            $invoice->value = 0;
            $invoice->payment_status = 'paid';
            if ($invoice->save()) {
                Invoice::where('user_id', Auth::id())->where('payment_status', '!=', 'paid')->where('id', '!=', $invoice->id)->delete();
                return redirect()->back()->with('success', 'Parabéns, sua compra foi realizada com sucesso!'); 
            }
        }
        
    }

    private function formatValue($valor) {
        
        $valor = preg_replace('/[^0-9,]/', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valorFloat = floatval($valor);
    
        return number_format($valorFloat, 2, '.', '');
    }
}
