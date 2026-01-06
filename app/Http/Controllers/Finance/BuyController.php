<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\CoraController;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Plan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BuyController extends Controller {
    
    public function index() {

        $plans = Plan::where('status', 1)->get();
        return view('app.Finance.Buy.index', [
            'plans' => $plans
        ]);
    }

    public function store(Request $request, $plan) {

        $coraController = new CoraController();
        
        $plan = Plan::where('uuid', $plan)->first();
        if (!$plan) {
            return redirect()->back()->with('infor', 'Plano indisponível!');
        }

        $coupon = $this->applyCoupon($request->code, $plan->value);
        if ($coupon === false) {
            return back()->with('error', 'Cupom inválido ou expirado!');
        }

        $payment = $coraController->createdCharge(Auth::user(), $couponResult['final_value'] ?? $plan->value, $plan->title);
        if ($payment['status'] !== 'success') {
            return redirect()->back()->with('infor', $payment['message']);
        }
        
        $invoice = new Invoice();
        $invoice->uuid             = Str::uuid();
        $invoice->user_id          = Auth::id();
        $invoice->plan_id          = $plan->id;
        $invoice->title            = $plan->title;
        $invoice->description      = $plan->description;
        $invoice->value            = $couponResult['final_value'] ?? $plan->value;
        $invoice->payment_token    = $payment['id'];
        $invoice->payment_url      = $payment['invoiceUrl'];
        $invoice->payment_due_date = now()->addDays(1);
        if ($invoice->save()) {

            Invoice::where('user_id', Auth::id())->where('payment_status', '!=', 'paid')->where('id', '!=', $invoice->id)->delete();

            $qrSvg = QrCode::format('svg')->size(300)->generate($payment['qrCode']);
            return redirect()->back()->with([
                'qrCodeImg'   => 'data:image/svg+xml;base64,' . base64_encode($qrSvg),
                'qrCode'      => $payment['qrCode'],
                'invoiceUrl'  => $payment['invoiceUrl'],
            ]);
        }

        return back()->with('error', 'Houve um problema ao processar sua compra, tente novamente mais tarde!');
    }

    protected function applyCoupon(?string $code, float $baseValue) {
        // Cupom não é obrigatório
        if (!$code) {
            return null;
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || $coupon->quantity <= 0) {
            return false;
        }

        // Exemplo de estrutura esperada do cupom
        // $coupon->type = 'fixed' | 'percent'
        // $coupon->value = 10 | 20

        if ($coupon->type === 'percent') {
            $discount = ($baseValue * $coupon->value) / 100;
        } else {
            $discount = $coupon->value;
        }

        $finalValue = max(0, $baseValue - $discount);

        // Atualiza cupom
        $coupon->decrement('quantity');

        if ($coupon->quantity === 0) {
            $coupon->status = 2;
            $coupon->save();
        }

        return [
            'coupon_id'   => $coupon->id,
            'discount'    => $discount,
            'final_value' => number_format($finalValue, 2, '.', ''),
        ];
    }

    private function formatValue($valor) {
        
        $valor = preg_replace('/[^0-9,]/', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valorFloat = floatval($valor);
    
        return number_format($valorFloat, 2, '.', '');
    }
}
