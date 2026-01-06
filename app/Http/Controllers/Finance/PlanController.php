<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller {
    
    public function index(Request $request) {

        $query = Plan::query();
        if (!empty($request->title)) {
            $query->where('name', 'like', '%' . $request->title . '%');
        }

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        if (!empty($request->time)) {
            $query->where('time', $request->time);
        }

        $query->withCount([
            'invoices as paid_invoices_count' => function ($q) {
                $q->where('payment_status', 'PAID');
            }
        ]);

        return view('app.Finance.Plan.index', [
            'plans' => $query->paginate(30),
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'title'       => 'required|string|max:255',
            'caption'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'time'        => 'required',
            'image'       => 'nullable|image|max:2048',
        ], [
            'title.required'       => 'O campo título é obrigatório.',
            'title.string'         => 'O campo título deve ser um texto.',
            'title.max'            => 'O campo título não pode ter mais que 255 caracteres.',
            'caption.string'       => 'O campo legenda deve ser um texto.',
            'caption.max'          => 'O campo legenda não pode ter mais que 255 caracteres.',
            'description.string'   => 'O campo descrição deve ser um texto.',
            'time.required'        => 'O campo tempo é obrigatório.',
            'image.image'          => 'O arquivo enviado deve ser uma imagem.',
            'image.max'            => 'A imagem não pode ter mais que 2MB.',
        ]);
      
        $plan               = new Plan();
        $plan->uuid         = Str::uuid();
        $plan->title        = $request->title;
        $plan->caption      = $request->caption;
        $plan->description  = $request->description;
        $plan->value        = $this->formatValue($request->value);
        $plan->status       = $request->status == 'true' ? true : false;
        $plan->time         = $request->time;

        if ($request->hasFile('image')) {
            $plan->image = $request->file('image')->store('plans-images', 'public');
        }

        if ($plan->save()) {
            return redirect()->back()->with('success', 'Plano cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Não foi possível cadastrar o plano, verifique os dados e tente novamente!');
    }

    public function update(Request $request, $uuid) {

        $plan = Plan::where('uuid', $uuid)->first();
        if (!$plan) {
            return redirect()->back()->with('infor', 'Não foi possível encontrar os dados do plano, verifique os dados e tente novamente!');
        }

        if (!empty($request->title)) {
            $plan->title = $request->title;
        }
        if (!empty($request->caption)) {
            $plan->caption = $request->caption;
        }
        if (!empty($request->description)) {
            $plan->description = $request->description;
        }
        if (!empty($request->value)) {
            $plan->value = $this->formatValue($request->value);
        }
        if (!empty($request->status)) {
            $plan->status = $request->status == 'true' ? true : false;
        }
        if (!empty($request->time)) {
            $plan->time = $request->time;
        }

        if ($request->hasFile('image')) {
            if ($plan->image && Storage::disk('public')->exists($plan->image)) {
                Storage::disk('public')->delete($plan->image);
            }
            $plan->image = $request->file('image')->store('plans-images', 'public');
        }

        if ($plan->save()) {
            return redirect()->back()->with('success', 'Plano atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Não foi possível cadastrar o plano, verifique os dados e tente novamente!');
        
    }

    public function destroy(Request $request, $uuid) {

        $plan = Plan::where('uuid', $uuid)->first();
        if ($plan) {
            if ($plan->image && Storage::disk('public')->exists($plan->image)) {
                Storage::disk('public')->delete($plan->image);
            }
            if ($plan->delete()) {
                return redirect()->back()->with('success', 'Plano deletado com sucesso!');
            }
        }

        return redirect()->back()->with('error', 'Não foi possível deletar o plano, verifique os dados e tente novamente!');
    }

    private function formatValue($valor) {
        
        $valor = preg_replace('/[^0-9,]/', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valorFloat = floatval($valor);
    
        return number_format($valorFloat, 2, '.', '');
    }
}
