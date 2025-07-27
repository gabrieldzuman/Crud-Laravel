<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Lista de proxies confiáveis.
     * 
     * Pode ser:
     * - Um array com IPs específicos: ['192.168.1.1', '10.0.0.1']
     * - '*' para confiar em todos (com cuidado!)
     * - null para usar o comportamento padrão
     *
     * @var array<string>|string|null
     */
    protected array|string|null $proxies = '*'; // ou use env('TRUSTED_PROXIES', '*');

    /**
     * Cabeçalhos usados para detectar o endereço original do cliente atrás do proxy.
     *
     * HEADER_X_FORWARDED_AWS_ELB é útil para apps rodando atrás do Elastic Load Balancer (AWS).
     *
     * @var int
     */
    protected int $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
