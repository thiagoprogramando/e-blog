<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller {
    
    public function index (Request $request) {
        
        $query = User::query();
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('cpfcnpj')) {
            $query->where('cpfcnpj', preg_replace('/\D/', '', $request->input('cpfcnpj')));
        }

        if ($request->has('email')) {
            $query->where('email', $request->input('email'));
        }

        return view('app.User.index', [
            'users' => $query->paginate(15),
        ]);
    }

    public function show ($uuid) {
        
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não encontrado!');
        }

        return view('app.User.show', [
            'user' => $user,
        ]);
    }
    
    public function store (Request $request) {

        $request->merge([
            'cpfcnpj'   => preg_replace('/\D/', '', $request->cpfcnpj),
            'phone'     => preg_replace('/\D/', '', $request->phone),
        ]);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
        ], [
            'name.required'         => 'O campo nome é obrigatório.',
            'email.required'        => 'O campo e-mail é obrigatório.',
            'email.email'           => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.unique'          => 'O e-mail informado já está em uso.',
        ]);
        
        $user               = new User();
        $user->uuid         = Str::uuid();
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->cpfcnpj      = preg_replace('/\D/', '', $request->cpfcnpj);
        $user->password     = bcrypt(preg_replace('/\D/', '', $request->password));
        if ($user->save()) {
            return redirect()->back()->with('success', 'Usuário cadastrado com sucesso!');
        } 

        return redirect()->back()->with('error', 'Erro ao cadastrar usuário, tente novamente!');
    }

    public function update (Request $request, $uuid) {

        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não encontrado!');
        }

        if (!empty($request->name)) {
            $user->name = $request->name;
        }
        if (!empty($request->email)) {
            $user->email = $request->email;
        }
        if (!empty($request->cpfcnpj)) {
            $user->cpfcnpj = preg_replace('/\D/', '', $request->cpfcnpj);
        }
        if (!empty($request->phone)) {
            $user->phone = preg_replace('/\D/', '', $request->phone);
        }
        if (!empty($request->role)) {
            $user->role = $request->role;
        }
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        if (!empty($request->avatar)) {

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $file     = $request->file('avatar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile-images', $filename, 'public');
            $user->avatar = 'profile-images/' . $filename;
        }

        if ($user->save()) {
            return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
        } 

        return redirect()->back()->with('error', 'Erro ao atualizar dados, tente novamente!');
    }

    public function destroy ($uuid) {

        $user = User::where('uuid', $uuid)->first();
        if ($user && $user->delete()) {
            return redirect()->back()->with('success', 'Conta excluída com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao excluir Conta, tente novamente!');
    }
}
