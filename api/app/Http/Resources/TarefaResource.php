<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TarefaResource extends JsonResource
{
    /**
     * Transformar o recurso em um array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,                           // ID da tarefa
            'titulo' => $this->titulo,                   // Título da tarefa
            'descricao' => $this->descricao,             // Descrição da tarefa
            'status' => $this->status,                   // Status da tarefa
            'user_id' => $this->user_id,                 // ID do usuário que criou a tarefa
            'created_at' => $this->created_at->format('d/m/Y'), // Data de criação formatada
            'updated_at' => $this->updated_at->format('d/m/Y'), // Data de atualização formatada
        ];
    }
}
