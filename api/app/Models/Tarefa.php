<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',    // Título da tarefa
        'descricao', // Descrição da tarefa
        'status',    // Status da tarefa
        'user_id',   // ID do usuário que criou a tarefa
    ];

    /**
     * Definir o relacionamento com o modelo User.
     * Uma tarefa pertence a um usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Retorna o usuário associado à tarefa
    }
}
