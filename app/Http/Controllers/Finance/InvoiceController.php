<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller {
    
    public function index (Request $request) {

        $query = Invoice::query();

        if (!empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if (!empty($request->plan_id) && $request->plan_id != '---') {
            $query->where('plan_id', $request->plan_id);
        }

        if (!empty($request->payment_status) && $request->payment_status != '---') {
            $query->where('payment_status', $request->payment_status);
        }

        if (!empty($request->payment_due_date)) {
            $query->where('payment_due_date', $request->payment_due_date);
        }

        if (!empty($request->user_id) && $request->user_id != '---') {
            $query->where('user_id', $request->user_id);
        } else {
            $query->where('user_id', Auth::user()->id);
        }

        return view('app.Finance.Invoice.index', [
            'invoices'  => $query->paginate(30),
            'plans'     => Plan::where('status', 1)->get(),
            'users'     => User::where('role', 'user')->get(),
        ]);
    }

    public function update (Request $request, $uuid) {

        $invoice = Invoice::where('uuid', $uuid)->first();
        if (!$invoice) {
            return redirect()->route('invoices')->with('warning', 'Fatura não encontrada!');
        }

        $invoice->title            = $request->title;
        $invoice->description      = $request->title;
        $invoice->value            = $this->formatValue($request->value);
        $invoice->plan_id          = $request->plan_id;
        $invoice->payment_status   = $request->payment_status;
        $invoice->payment_due_date = $request->payment_due_date;
        if ($invoice->save()) {
            return redirect()->route('invoices')->with('success', 'Fatura atualizada com sucesso!');
        }

        return redirect()->route('invoices')->with('error', 'Ocorreu um erro ao atualizar a fatura, tente novamente!');
    }

    public function destroy ($uuid) {

        $invoice = Invoice::where('uuid', $uuid)->first();
        if ($invoice && $invoice->delete()) {
            return redirect()->route('invoices')->with('success', 'Fatura eliminada com sucesso!');
        }

        return redirect()->route('invoices')->with('error', 'Ocorreu um erro ao excluir a fatura, tente novamente!');
    }

    private function formatValue($valor) {
        
        $valor = preg_replace('/[^0-9,]/', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valorFloat = floatval($valor);
    
        return number_format($valorFloat, 2, '.', '');
    }
}
