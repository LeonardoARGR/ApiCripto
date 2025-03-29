<?php

namespace App\Http\Controllers;

use App\Models\ApiCripto;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class ApiCriptoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buscando todas as criptomoedas
        $regBook = ApiCripto::All();

        // Contando o número de registros
        $contador = $regBook->count();

        // Verificar se há registros
        if($contador > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoedas encontradas com sucesso!',
                'data' => $regBook,
                'total' => $contador
            ], 200); // Retorna HTTP 200 (OK) com os dados e a contagem
          } else {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma criptomoeda encontrada'
            ], 404); // Retorna HTTP 404 (Not Found) se não houver registros
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'sigla' => 'required',
        'nome' => 'required',
        'valor'=> 'required'
      ]);

      if($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Registros inválidos',
            'errors' => $validator->errors()
        ], 400);
      }

      $registros = ApiCripto::create($request->all());

      if($registros) {
        return response()->json([
            'success' => true,
            'message' => 'Criptomoeda cadastrada com sucesso!',
            'data' => $registros
        ], 201);
      } else {
        return response()->json([
            'success' => false,
            'message' => 'Error ao cadastrar a criptomoeda'
        ], 500);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $registros = ApiCripto::find($id);

        if($registros){
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda localizada com sucesso!',
                'data' => $registros
            ], 200);   
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma criptomoeda encontrada'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $validator = Validator::make($request->all(), [
            'sigla' => 'required',
            'nome' => 'required',
            'valor' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        $regBookBanco = ApiCripto::find($id);

        if (!$regBookBanco) {
            return response()->json([
                'success' => false,
                'message' => 'Criptomoeda não encontrado'
            ], 404);
        }

        $regBookBanco->sigla = $request->sigla;
        $regBookBanco->nome = $request->nome;
        $regBookBanco->valor = $request->valor;

        if ($regBookBanco->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda atualizado com sucesso!',
                'data' => $regBookBanco
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar a criptomoeda'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $regBook = ApiCripto::find($id);

        if(!$regBook) {
            return response()->json([
                'success' => false,
                'message' => 'criptomoeda não encontradp'
            ], 404);
        }

        if ($regBook->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Criptomoeda deletado com sucesso'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao deletar a criptomoeda'
        ], 500);
    }
}
