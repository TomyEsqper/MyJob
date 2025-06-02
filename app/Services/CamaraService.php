<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class CamaraService
{
    protected string $baseUri;
    protected string $token;

    public function __construct()
    {
        $this->baseUri = config('services.datos_gov_co.base_uri');
        $this->token   = config('services.datos_gov_co.token');
    }

    /**
     * Buscar una empresa por NIT.
     *
     * @param string $nit Numero de Identificación Tributaria.
     * @return array      Datos devevueltos por la API (o array vacio si no existe)
     */

    public function buscarPorNit(string $nit): array
    {
        $response = Http::withHeaders([
            'X-App-Token' => $this->token,
            'Accept'      => 'application/json',
        ])->get($this->baseUri, [
            '$limit' => 1,
            'nit'    => $nit,
        ]);

        return $response->successful()
            ? $response->json()
            : [];
    }

    /**
     * Obtener un listado de empresa en Tolima
     *
     * @param int $limit Maximo de registros (max. 1000)
     * @returns array    Listado de empresas
     */

    public function empresasTolima(int $limit = 1000): array
    {
        $response = Http::withHeaders([
            'X-App-Token' => $this->token,
            'Accept'      => 'application/json',
        ])->get($this->baseUri, [
            '$limit' => $limit,
            'departamento' => 'Tolima',
        ]);

        return $response->successful()
            ? $response->json()
            : [];
    }
}
