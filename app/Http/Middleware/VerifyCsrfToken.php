<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs que devem ser **excluídas** da verificação CSRF.
     *
     * Só adicione aqui endpoints que:
     * - São acessados por terceiros (ex: webhooks, APIs públicas);
     * - Não usam sessões/autenticação baseada em cookies;
     * 
     * Não adicione rotas internas ou protegidas por sessão!
     *
     * @var array<string>
     */
    protected array $except = [
        // Exemplo: '/webhook/stripe',
        // Exemplo: '/api/public/*',
    ];
}
