<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * URIs que continuarão acessíveis durante o modo de manutenção.
     *
     * Use isso para permitir acessos a rotas de monitoramento,
     * webhooks de terceiros ou endpoints específicos.
     *
     * @var array<string>
     */
    protected array $except = [
        // Exemplo: 'status', 'api/health', 'webhook/external-service'
    ];
}
