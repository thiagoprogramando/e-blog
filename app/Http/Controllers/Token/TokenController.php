<?php

namespace App\Http\Controllers\Token;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TokenController extends Controller {
    
    public function index() {

        $tokens = Token::where('company_id', Auth::user()->company_id)->orWhere('company_id', Auth::user()->id)->get();
        return view('app.Token.index', [
            'tokens' => $tokens,
        ]);
    }

    public function store(Request $request) {

        $token                  = new Token();
        $token->token           = Str::uuid();
        $token->title           = $request->title;
        $token->description     = $request->description;
        $token->url             = $request->url;
        $token->ip              = $request->ip;
        $token->company_id      = Auth::user()->company_id ?? Auth::user()->id;
        if ($token->save()) {
            return redirect()->back()->with('success', 'Token criado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao gerar o token. Tente novamente!');
    }

    public function update(Request $request, $token) {

        $token = Token::where('token', $token)->first();
        if (!$token) {
            return redirect()->back()->with('infor', 'Token inválido. Verifique os dados e tente novamente.');
        }

        if ($request->has('title')) {
            $token->title = $request->title;
        }
        if ($request->has('description')) {
            $token->description = $request->description;
        }
        if ($request->has('url')) {
            $token->url = $request->url;
        }
        if ($request->has('ip')) {
            $token->ip = $request->ip;
        }
        if ($token->save()) {
            return redirect()->back()->with('success', 'Token atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao atualizar o token. Tente novamente!');
    }

    public function destroy($token) {

        $token = Token::where('token', $token)->first();
        if (!$token) {
            return redirect()->back()->with('infor', 'Token inválido, verifique os dados e tente novamente.');
        }

        if ($token->delete()) {
            return redirect()->back()->with('success', 'Token excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao excluir o token, tente novamente!');
    }
}
