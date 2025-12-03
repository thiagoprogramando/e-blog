<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller {
    
    public function index() {

        $plans = Plan::where('status', 1)->get();
        return view('register', [
            'plans' => $plans
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
        ], [
            'name.required'      => 'O nome é obrigatório!',
            'name.max'           => 'O nome não pode ter mais que 255 caracteres!',
            'email.required'     => 'O e-mail é obrigatório!',
            'email.email'        => 'Informe um e-mail válido!',
            'email.max'          => 'O e-mail não pode ter mais que 255 caracteres!',
            'email.unique'       => 'Este e-mail já está cadastrado!',
        ]);

        $user                = new User();
        $user->uuid          = Str::uuid();
        $user->company_token = Str::uuid();
        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->password      = bcrypt($request->password);
        if ($user->save()) {
            if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                return redirect()->route('app');
            } else {
                return redirect()->route('login')->with('success', 'Bem-vindo(a)! Faça Login para acessar o sistema!');
            }
        }

        return redirect()->back()->with('error', 'Erro ao cadastrar-se, verifique os dados e tente novamente!');
    }
}
