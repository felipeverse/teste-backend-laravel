<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Endereco;
use App\Http\Resources\EnderecoResource;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Endereco::latest()->get();
        return response()->json([EnderecoResource::collection($data), 'Endereços carregados.']);
    }

    /**
     * Store a newly created resource in storage
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'municipio_id' => 'required|integer',
            'logradouro' => 'required|string|max:200',
            'numero' => 'required|string|max:50',
            'bairro' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $endereco = Endereco::create([
            'municipio_id' => $request->municipio_id,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro
        ]);

        return response()->json(['Endereço criado com sucesso.', new EnderecoResource($endereco)]);
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $endereco = Endereco::find($id);
        if (is_null($endereco)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new EnderecoResource($endereco)]);
    }

    /**
     * Update the specified resource in storage
     * 
     * @param \Illuminate\Http\Request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Endereco $endereco)
    {
        $validator = Validator::make($request->all(), [
            'municipio_id' => 'required|integer',
            'logradouro' => 'required|string|max:200',
            'numero' => 'required|string|max:50',
            'bairro' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $endereco->municipio_id = $request->municipio_id;
        $endereco->logradouro = $request->logradouro;
        $endereco->numero = $request->numero;
        $endereco->bairro = $request->bairro;
        $endereco->save();

        return response()->json(['Endereco atualizado com sucesso.', new EnderecoResource($endereco)]);
    }

    /**
     * Remove the specified resource from storage
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Endereco $endereco)
    {
        $endereco->delete();

        return response()->json('Endereco deletado com sucesso.');
    }
}
