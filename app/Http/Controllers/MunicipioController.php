<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Municipio;
use App\Http\Resources\MunicipioResource;

class MunicipioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Municipio::latest()->get();
        return response()->json([MunicipioResource::collection($data), 'Municipios carregados']);
    }

    /**
     * Importa para o banco de dados os munícipios da uf passada via parâmetro.
     *
     * @param  string $uf
     * @return string message
     */
    public static function ImportMunicipiosFromIBGEAPI($uf)
    {
        try {
            $response = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios");
        
            if($response->status() != 200)
                return "Error Processing Request";

            $municipios = json_decode($response->body());
            $items = 0;

            foreach($municipios as $municipio) {
                Municipio::firstOrCreate (
                    ['ibge_municipio_id' => $municipio->id], 
                    [
                        'ibge_municipio_nome' => $municipio->nome,
                        'ibge_uf_nome' => $municipio->microrregiao->mesorregiao->UF->nome,
                        'ibge_uf_id' => $municipio->microrregiao->mesorregiao->UF->id
                    ]
                );
                $items++;
            }

            return "{$items} items importados com sucesso.";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
