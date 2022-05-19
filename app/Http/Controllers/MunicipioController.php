<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Municipio;

class MunicipioController extends Controller
{
    public static function ImportMunicipiosFromIBGEAPI($uf)
    {
        try {
            $response = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios");
        
            $municipios = json_decode($response->body());

            foreach($municipios as $municipio) {
                $new_municipio = new Municipio;
                $new_municipio->ibge_municipio_nome = $municipio->nome;
                $new_municipio->ibge_municipio_id = $municipio->id;
                $new_municipio->ibge_uf_nome = $municipio->microrregiao->mesorregiao->nome;
                $new_municipio->ibge_uf_id = $municipio->microrregiao->mesorregiao->id;
                $new_municipio->save();
            }
            return "successfully imported";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
