<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

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
            $response = Http::timeout(10)->get("https://viacep.com.br/ws/{$cep}/json/");
            
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
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro de conexão'], 500);
        }
    }
} 