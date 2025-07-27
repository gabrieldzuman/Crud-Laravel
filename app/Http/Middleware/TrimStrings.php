<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * Atributos que **não** devem ter espaços removidos.
     * 
     * Ideal para campos sensíveis como senhas ou tokens, onde espaços podem ser válidos
     * ou podem causar falhas de autenticação inesperadas.
     *
     * @var array<string>
     */
    protected array $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
