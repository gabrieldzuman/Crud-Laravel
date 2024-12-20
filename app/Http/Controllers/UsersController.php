<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController
{
    /**
     * Exibe o formulário para criar um novo usuário.
     *
     * @return \Illuminate\View\View View de criação de usuário.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Armazena um novo usuário no banco de dados e realiza login.
     *
     * @param UserFormRequest $request Requisição validada com dados do formulário.
     * @return \Illuminate\Http\RedirectResponse Redireciona para a página de séries após o login.
     */
    public function store(UserFormRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        Auth::login($user);

        return to_route('series.index')
            ->with('mensagem.sucesso', "Bem-vindo, {$user->name}! Sua conta foi criada com sucesso.");
    }
}
