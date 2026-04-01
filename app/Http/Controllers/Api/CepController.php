<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    public function show($cep)
    {
        // Remove caracteres não numéricos
        $cep = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cep) !== 8) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        try {
            // Em alguns ambientes Windows/XAMPP o SSL do PHP pode falhar por CA bundle.
            // Tentamos HTTPS primeiro e, se falhar, fazemos fallback para HTTP.
            try {
                $response = Http::timeout(10)->acceptJson()->get("https://viacep.com.br/ws/{$cep}/json/");
            } catch (\Throwable $e) {
                $response = Http::timeout(10)->acceptJson()->get("http://viacep.com.br/ws/{$cep}/json/");
            }

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['erro']) && $data['erro']) {
                    return response()->json(['error' => 'CEP não encontrado'], 404);
                }

                return response()->json([
                    'cep' => $data['cep'],
                    'street' => $data['logradouro'],
                    'city' => $data['localidade'],
                    'state' => $data['uf'],
                    'neighborhood' => $data['bairro'],
                ]);
            }

            return response()->json(['error' => 'Erro ao consultar CEP'], 500);
        } catch (\Throwable $e) {
            $message = 'Erro de conexão';
            if (config('app.debug')) {
                $message .= ': '.$e->getMessage();
            }

            return response()->json(['error' => $message], 500);
        }
    }
}
