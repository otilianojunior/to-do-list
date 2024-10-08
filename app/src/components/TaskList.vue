<template>
  <div v-if="tarefas.length > 0" class="conteiner" :style="{ backgroundColor: '#f9f9f9' }">
    <div class="TaskList">
      <div class="card-container" v-if="tarefas.length > 0">
        <div class="card" v-for="tarefa in tarefas" :key="tarefa.id"
          :style="{ backgroundColor: getCardColor(tarefa.status), width: '300px' }">
          <h2><strong>Título: </strong>{{ tarefa.titulo }}</h2>
          <p><strong>Descrição: </strong>{{ tarefa.descricao }}</p>
          <p><strong>Status:</strong> {{ getStatusText(tarefa.status) }}</p>
          <div class="button-container">
            <button class="edit-button" @click="editarTarefa(tarefa)">Editar</button>
            <button class="delete-button" @click="openDeleteModal(tarefa)" type="button">Excluir</button>
          </div>
        </div>
      </div>
      <div v-else>{{ mensagemApi }}</div>
      <div v-if="erro">{{ erro }}</div>

      <EditTask v-if="editarModo" :tarefa="tarefaParaEditar" :isModalOpen="editarModo"
        :closeModal="() => { editarModo = false; }" @atualizar-tarefa="buscarTarefas" />

      <DeleteTask v-if="isDeleteModalOpen" :tarefa="tarefaParaExcluir" :isModalOpen="isDeleteModalOpen"
        :closeModal="() => { isDeleteModalOpen = false; }" @task-deleted="buscarTarefas" />
    </div>
  </div>
</template>

<script setup>
// Importando os módulos necessários do Vue e os serviços/api
import { ref, onMounted } from 'vue';
import { getAllTasks } from '@/services/apiService';
import EditTask from '@/components/EditTask.vue';
import DeleteTask from '@/components/DeleteTask.vue';

// Definindo variáveis reativas usando `ref`
const tarefas = ref([]);
const mensagemApi = ref('');
const erro = ref(null);
const tarefaParaEditar = ref(null);
const editarModo = ref(false);
const isDeleteModalOpen = ref(false);
const tarefaParaExcluir = ref(null);

// Método assíncrono para buscar tarefas da API
const buscarTarefas = async () => {
  try {
    const resposta = await getAllTasks();
    console.log(resposta);

    if (resposta.success) {
      tarefas.value = resposta.data;
      mensagemApi.value = resposta.message;
    } else {
      mensagemApi.value = 'Erro ao recuperar tarefas';
    }
  } catch (error) {
    erro.value = 'Erro ao buscar as tarefas: ' + error.message;
  }
};

// Método para habilitar o modo de edição para a tarefa selecionada
const editarTarefa = (tarefa) => {
  tarefaParaEditar.value = tarefa;
  editarModo.value = true;
};

// Método para abrir o modal de exclusão para a tarefa selecionada
const openDeleteModal = (tarefa) => {
  tarefaParaExcluir.value = tarefa;
  isDeleteModalOpen.value = true;
};

// Método para retornar o texto correspondente ao status da tarefa
const getStatusText = (status) => {
  switch (status) {
    case 'em_andamento':
      return 'Em Andamento';
    case 'concluido':
      return 'Concluído';
    case 'nao_iniciado':
      return 'Não Iniciado';
    default:
      return status;
  }
};

// Método para retornar a cor do cartão com base no status da tarefa
const getCardColor = (status) => {
  switch (status) {
    case 'em_andamento':
      return '#FFA500';
    case 'concluido':
      return '#28A745';
    case 'nao_iniciado':
      return '#007BFF';
    default:
      return '#FFFFFF';
  }
};

// Hook do ciclo de vida do Vue para buscar tarefas quando o componente é montado
onMounted(() => {
  buscarTarefas();
});
</script>

<style scoped>
.card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  justify-content: center;
}

.card {
  border: 1px solid #ddd4d4;
  border-radius: 8px;
  padding: 16px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
  background-color: #fff;
  flex: 1 1 300px;
  max-width: 300px;
  min-width: 250px;
  margin: 10px;
}

.button-container {
  display: flex;
  justify-content: space-evenly;
  margin-top: 10px;
}

.edit-button {
  background-color: #000000 !important;
  color: white !important;
  border: none !important;
  border-radius: 4px;
  padding: 8px;
  cursor: pointer;
}

.delete-button {
  background-color: red !important;
  color: white !important;
  border: none !important;
  border-radius: 4px;
  padding: 8px;
  cursor: pointer;
}

.edit-button:hover {
  background-color: #78a8db !important;
}

.delete-button:hover {
  background-color: darkred !important;
}

.conteiner {
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin: 20px;
  width: 99% !important;
  margin-left: auto !important;
  margin-right: auto !important;
}
</style>
