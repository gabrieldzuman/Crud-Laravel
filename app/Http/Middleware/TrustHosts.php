<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Define os padrões de hosts confiáveis para a aplicação.
     * 
     * Isso ajuda a proteger contra ataques de Host Header Injection,
     * permitindo apenas domínios autorizados.
     *
     * @return array<string|null>
     */
    public function hosts(): array
    {
        return [
            $this->allSubdomainsOfApplicationUrl()
        ];
    }
}
