<?php

namespace App\Http\Controllers\Letter;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller {
    
    public function index(Request $request) {

        $userId = Auth::id();
        $query  = Group::query()
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                ->orWhere('company_id', $userId);
            })
            ->when($request->filled('title'), fn($q) =>
                $q->where('title', 'like', '%' . $request->title . '%')
            )
            ->when($request->filled('type'), fn($q) =>
                $q->where('type', $request->type)
            );

        return view('app.Letter.Group.index', [
            'groups'  => $query->paginate(30)->appends($request->query()),
        ]);
    }

    public function store(Request $request) {

        $group = new Group();
        $group->uuid         = Str::uuid();
        $group->user_id      = Auth::id();
        $group->company_id   = Auth::user()->company_id ?? Auth::user()->id;
        $group->title        = $request->title;
        $group->description  = $request->description;
        $group->value        = $this->formatValue($request->value);
        $group->type         = $request->type;
        if ($group->save()) {
            return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao cadastrar, verifique os dados e tente novamente!');

    }

    public function update(Request $request, $uuid) {

        $group = Group::where('uuid', $uuid)->first();
        if (!$group) {
            return redirect()->back()->with('error', 'Grupo não encontrado, verifique os dados e tente novamente!');
        }

        if ($request->filled('title')) {
            $group->title = $request->title;
        }
        if ($request->filled('description')) {
            $group->description = $request->description;
        }
        if ($request->filled('type')) {
            $group->type = $request->type;
        }
        if ($request->filled('value')) {
            $group->value = $this->formatValue($request->value);
        }
        if ($group->save()) {
            return redirect()->back()->with('success', 'Atualização realizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao atualizar, verifique os dados e tente novamente!');

    }

    public function destroy($uuid) {

        $group = Group::where('uuid', $uuid)->first();
        if ($group && $group->delete()) {
            return redirect()->back()->with('success', 'Cadastro deletado com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao deletar o cadastro, tente novamente!');
    }

    private function formatValue($valor) {
        
        $valor = preg_replace('/[^0-9,]/', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valorFloat = floatval($valor);
    
        return number_format($valorFloat, 2, '.', '');
    }
}
