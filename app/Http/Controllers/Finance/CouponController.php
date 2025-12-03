<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller {

    public function index(Request $request) {

        $query = Coupon::query();

        if (!empty($request->code)) {
            $query->where('code', 'LIKE', "%{$request->code}%");
        }

        if (!empty($request->user_id) && $request->user_id != '---') {
            $query->where('user_id', $request->user_id);
        }

        if (!empty($request->discount_amount)) {
            $query->where('discount_amount', $this->formatValue($request->discount_amount));
        }

        if (!empty($request->discount_percent)) {
            $query->where('discount_percent', $request->discount_percent);
        }

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        if (!empty($request->quantity)) {
            $query->where('quantity', $request->quantity);
        }

        return view('app.Finance.Coupon.index', [
            'coupons'  => $query->paginate(30),
            'users'    => User::where('role', 'user')->get(),
        ]);
    }

    public function store(Request $request) {

        if (empty($request->discount_amount) && empty($request->discount_percent)) {
            return redirect()->back()->with('infor', 'Informe o valor do desconto ou a porcentagem do desconto.');
        }

        if (!empty($request->user_id) && $request->user_id != '---') {
            $user = User::find($request->user_id);
            if (!$user) {
                return redirect()->back()->with('infor', 'Usuário inválido. Verifique os dados e tente novamente!');
            }
        }

        $coupon = new Coupon();
        $coupon->uuid             = Str::uuid();
        $coupon->code             = $request->code ?? strtoupper(uniqid());
        $coupon->description      = $request->description;
        $coupon->user_id          = $user->id ?? null;
        $coupon->discount_amount  = $this->formatValue($request->discount_amount);
        $coupon->discount_percent = $this->formatPercent($request->discount_percent);
        $coupon->quantity         = $request->quantity;
        $coupon->status           = $request->status;
        if ($coupon->save()) {
            return redirect()->back()->with('success', 'Cupom criado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao criar cupom.  Tente novamente mais tarde!');
    }

    public function update(Request $request, $uuid) {

        $coupon = Coupon::where('uuid', $uuid)->first();
        if (!$coupon) {
            return redirect()->back()->with('infor', 'Cupom inválido. Verifique os dados e tente novamente!');
        }

        if (!empty($request->user_id) && $request->user_id != '---') {
            $user = User::find($request->user_id);
            if (!$user) {
                return redirect()->back()->with('infor', 'Usuário inválido. Verifique os dados e tente novamente!');
            }
        }

        if ($request->has('description')) {
            $coupon->description = $request->description;
        }
        if (isset($user)) {
            $coupon->user_id = $user->id;
        }
        if ($request->has('discount_amount')) {
            $coupon->discount_amount = $this->formatValue($request->discount_amount);
        }
        if ($request->has('discount_percent')) {
            $coupon->discount_percent = $this->formatPercent($request->discount_percent);
        }
        if ($request->has('quantity')) {
            $coupon->quantity = $request->quantity;
        }
        if ($request->has('status')) {
            $coupon->status = $request->status;
        }
        if ($coupon->save()) {
            return redirect()->back()->with('success', 'Cupom atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao atualizar cupom.  Tente novamente mais tarde!');
    }

    public function destroy($uuid) {

        $coupon = Coupon::where('uuid', $uuid)->first();
        if ($coupon && $coupon->delete()) {
            return redirect()->back()->with('success', 'Cupom excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao excluir cupom. Verifique os dados e tente novamente!');
    }

    private function formatValue($valor) {
        $valor      = preg_replace('/[^0-9,]/', '', $valor);
        $valor      = str_replace(',', '.', $valor);
        $valorFloat = floatval($valor);
        return number_format($valorFloat, 2, '.', '');
    }

    private function formatPercent($percent) {
        $percent        = preg_replace('/[^0-9,]/', '', $percent);
        $percent        = str_replace(',', '.', $percent);
        $percentFloat   = floatval($percent);
        $percentFloat   = max(0, min(100, $percentFloat));
        return number_format($percentFloat, 2, '.', '');
    }
}
