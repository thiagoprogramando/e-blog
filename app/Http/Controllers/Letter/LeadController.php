<?php

namespace App\Http\Controllers\Letter;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LeadController extends Controller {
    
    public function index(Request $request) {

        $userId = Auth::id();
        $query  = Lead::query()
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                ->orWhere('company_id', $userId);
            })
            ->when($request->filled('name'), fn($q) =>
                $q->where('name', 'like', '%' . $request->name . '%')
            )
            ->when($request->filled('email'), fn($q) =>
                $q->where('email', $request->email)
            )
            ->when($request->filled('phone'), fn($q) =>
                $q->where('phone', $request->phone)
            )
            ->when($request->filled('type'), fn($q) =>
                $q->where('type', $request->type)
            )->when($request->filled('group_id'), fn($q) =>
                $q->where('group_id', $request->group_id)
            );

        return view('app.Letter.Lead.index', [
            'leads'  => $query->paginate(30)->appends($request->query()),
            'groups' => Group::where('user_id', $userId)->orWhere('company_id', $userId)->get(),
        ]);
    }

    public function store(Request $request) {

        $lead = new Lead();
        $lead->uuid         = Str::uuid();
        $lead->user_id      = Auth::id();
        $lead->company_id   = Auth::user()->company_id ?? Auth::user()->id;
        $lead->name         = $request->name;
        $lead->email        = $request->email;
        $lead->phone        = $request->phone;
        $lead->type         = $request->type;
        $lead->group_id     = $request->group_id;
        if ($lead->save()) {
            return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao cadastrar, verifique os dados e tente novamente!');
    }

    public function update(Request $request, $uuid) {

        $lead = Lead::where('uuid', $uuid)->first();
        if (!$lead) {
            return redirect()->back()->with('error', 'Lead não encontrado, verifique os dados e tente novamente!');
        }

        if ($request->filled('name')) {
            $lead->name = $request->name;
        }
        if ($request->filled('email')) {
            $lead->email = $request->email;
        }
        if ($request->filled('phone')) {
            $lead->phone = $request->phone;
        }
        if ($request->filled('type')) {
            $lead->type = $request->type;
        }
        if ($request->filled('group_id')) {
            $lead->group_id = $request->group_id;
        }
        if ($lead->save()) {
            return redirect()->back()->with('success', 'Atualização realizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao atualizar, verifique os dados e tente novamente!');

    }

    public function destroy($uuid) {

        $lead = Lead::where('uuid', $uuid)->first();
        if ($lead && $lead->delete()) {
            return redirect()->back()->with('success', 'Cadastro deletado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao deletar o cadastro, tente novamente!');
    }
}
