<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Tarefa;
use Validator;
use App\Http\Resources\TarefaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TarefaController extends BaseController
{
    /**
     * Exibe a lista de tarefas do usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse Resposta em formato JSON com a lista de tarefas.
     */
    public function index(): JsonResponse
    {
        $tarefas = Tarefa::where('user_id', Auth::id())->get();
        return $this->sendResponse(TarefaResource::collection($tarefas), 'Tarefas recuperadas com sucesso.');
    }

    /**
     * Armazena uma nova tarefa.
     *
     * @param  \Illuminate\Http\Request  $request Dados da tarefa a serem armazenados.
     * @return \Illuminate\Http\JsonResponse Resposta em formato JSON indicando o sucesso ou falha da operação.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'titulo' => 'required',
            'descricao' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Erro de validação.', $validator->errors());
        }

        $input['user_id'] = Auth::id(); // Adiciona o ID do usuário autenticado
        $tarefa = Tarefa::create($input);

        return $this->sendResponse(new TarefaResource($tarefa), 'Tarefa criada com sucesso.');
    }

    /**
     * Exibe uma tarefa específica do usuário autenticado.
     *
     * @param  int  $id ID da tarefa a ser exibida.
     * @return \Illuminate\Http\JsonResponse Resposta em formato JSON com os detalhes da tarefa.
     */
    public function show($id): JsonResponse
    {
        $tarefa = Tarefa::where('id', $id)->where('user_id', Auth::id())->first();

        if (is_null($tarefa)) {
            return $this->sendError('Tarefa não encontrada ou não pertence ao usuário.');
        }

        return $this->sendResponse(new TarefaResource($tarefa), 'Tarefa recuperada com sucesso.');
    }

    /**
     * Atualiza uma tarefa existente.
     *
     * @param  \Illuminate\Http\Request  $request Dados para atualização da tarefa.
     * @param  int  $id ID da tarefa a ser atualizada.
     * @return \Illuminate\Http\JsonResponse Resposta em formato JSON indicando o sucesso ou falha da operação.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'titulo' => 'nullable|string',
            'descricao' => 'nullable|string',
            'status' => 'nullable|in:nao_iniciado,em_andamento,concluido',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Erro de validação.', $validator->errors());
        }

        $tarefa = Tarefa::where('id', $id)->where('user_id', Auth::id())->first();

        if (is_null($tarefa)) {
            return $this->sendError('Tarefa não encontrada ou não pertence ao usuário.');
        }

        if (empty($input['titulo']) && empty($input['descricao']) && empty($input['status'])) {
            return $this->sendError('Nenhum campo válido fornecido para atualização.');
        }

        // Atualiza os campos que foram fornecidos e não estão vazios
        if (array_key_exists('titulo', $input) && $input['titulo'] !== null) {
            $tarefa->titulo = $input['titulo'];
        }

        if (array_key_exists('descricao', $input) && $input['descricao'] !== null) {
            $tarefa->descricao = $input['descricao'];
        }

        if (array_key_exists('status', $input) && $input['status'] !== null) {
            $tarefa->status = $input['status'];
        }

        $tarefa->save();

        return $this->sendResponse(new TarefaResource($tarefa), 'Tarefa atualizada com sucesso.');
    }

    /**
     * Remove uma tarefa específica.
     *
     * @param  int  $id ID da tarefa a ser removida.
     * @return \Illuminate\Http\JsonResponse Resposta em formato JSON indicando o sucesso ou falha da operação.
     */
    public function destroy($id): JsonResponse
    {
        $tarefa = Tarefa::where('id', $id)->where('user_id', Auth::id())->first();

        if (is_null($tarefa)) {
            return $this->sendError('Tarefa não encontrada ou não pertence ao usuário.');
        }

        $tarefa->delete();

        return $this->sendResponse([], 'Tarefa excluída com sucesso.');
    }
}
