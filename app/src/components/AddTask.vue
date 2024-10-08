<template>
    <div class="add-task">
        <button type="button" @click="abrirModal">Adicionar Tarefa</button>

        <div v-if="isModalOpen" class="modal-overlay">
            <div class="modal">
                <h2 class="modal-title">Olá! Vamos começar anotar suas tarefas!</h2>
                <form @submit.prevent="confirmarAdd">
                    <div class="form-row">
                        <label for="titulo">Título:</label>
                        <input type="text" v-model="novaTarefa.titulo" placeholder="Título da tarefa" required />
                        <label for="descricao">Descrição:</label>
                        <textarea v-model="novaTarefa.descricao" placeholder="Descrição da tarefa" required></textarea>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" v-model="novaTarefa.status" required>
                                <option value="em_andamento">Em Andamento</option>
                                <option value="concluido">Concluído</option>
                                <option value="nao_iniciado">Não Iniciado</option>
                            </select>
                        </div>
                    </div>
                    <div class="button-container">
                        <button type="submit" class="edit-button">Criar</button>
                        <button @click="cancelarAdd" class="cancel-button delete-button">Cancelar</button>
                    </div>
                </form>

                <div v-if="erro" class="error">{{ erro }}</div>
            </div>
        </div>

        <div v-if="erro" class="error">{{ erro }}</div>
    </div>
</template>

<script setup>
// Importando as dependências
import { ref } from 'vue';
import { createTask } from '@/services/apiService';

// Estado da nova tarefa e do modal
const novaTarefa = ref({ titulo: '', descricao: '', status: 'nao_iniciado' });
const isModalOpen = ref(false);
const erro = ref(null);

// Abre o modal para adicionar tarefa
const abrirModal = () => {
    isModalOpen.value = true;
};

// Cancela a adição de tarefa, fecha o modal e reseta os campos
const cancelarAdd = () => {
    isModalOpen.value = false;
    novaTarefa.value = { titulo: '', descricao: '', status: 'nao_iniciado' };
    erro.value = null;
};

// Função para adicionar a tarefa chamando a API
const adicionarTarefa = async () => {
    try {
        await createTask(novaTarefa.value);
        novaTarefa.value = { titulo: '', descricao: '', status: 'nao_iniciado' }; // Reseta a tarefa
        erro.value = null;
        isModalOpen.value = false;
    } catch (error) {
        erro.value = 'Erro ao adicionar a tarefa: ' + error.message;
    }
};

// Confirma a adição da tarefa e recarrega a página
const confirmarAdd = async () => {
    await adicionarTarefa();
    window.location.reload();
};
</script>

<style scoped>
.add-task {
    margin: 20px 0;
}

input,
textarea,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    padding: 10px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

.error {
    color: red;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    width: 600px;
    background: #f9f9f9;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 2px 5px 10px rgba(247, 245, 245, 0.3);
}

.form-group {
    margin-bottom: 15px;
}

.modal-title {
    color: black;
}

label {
    display: block;
    margin-bottom: 5px;
    color: black;
    text-align: left;
}

input,
textarea,
select {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid black;
    border-radius: 4px;
    background-color: white;
    color: black;
    font-size: 16px;
}

textarea {
    height: 50px;
    font-size: 16px;
}

select {
    font-size: 16px;
}

.button-container {
    display: flex;
    margin-top: auto;
    margin-left: auto;
    margin-right: auto;
}

button {
    margin-right: 8px;
    padding: 8px 12px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
}

.edit-button {
    background-color: #000000;
    color: white;
}

.cancel-button {
    background: red;
    color: white;
}

button:hover {
    opacity: 0.8;
    background-color: #78a8db;
}

.delete-button:hover {
    background-color: darkred;
}

.error {
    color: red;
    margin-top: 10px;
}
</style>
