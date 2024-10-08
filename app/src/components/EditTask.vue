<template>
  <div>
    <!-- Modal para edição de tarefa -->
    <div v-if="isModalOpen" class="modal-overlay">
      <div class="modal">
        <h2 class="modal-title">Editar Tarefa</h2>
        <form @submit.prevent="updateTask">
          <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" v-model="tarefa.titulo" required />
          </div>
          <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" v-model="tarefa.descricao" required></textarea>
          </div>
          <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" v-model="tarefa.status">
              <option value="em_andamento">Em Andamento</option>
              <option value="concluido">Concluído</option>
              <option value="nao_iniciado">Não Iniciado</option>
            </select>
          </div>
          <div class="button-container">
            <button type="submit" class="edit-button">Salvar</button>
            <button type="button" @click="cancelEdit" class="cancel-button delete-button">Cancelar</button>
          </div>
        </form>
        <div v-if="erro" class="error">{{ erro }}</div>
      </div>
    </div>
  </div>
</template>

<script>
// Importando as dependências
import { updateTask } from '@/services/apiService';
import { ref } from 'vue';

// Componente para edição de tarefa
export default {
  props: {
    tarefa: {
      type: Object,
      required: true
    },
    isModalOpen: {
      type: Boolean,
      required: true
    },
    closeModal: {
      type: Function,
      required: true
    }
  },
  setup(props) {
    const erro = ref(null); // Estado para gerenciar erros
    const originalTask = ref({ ...props.tarefa }); // Armazena a tarefa original para cancelamento

    // Função para atualizar a tarefa
    const updateTaskHandler = async () => {
      try {
        await updateTask(props.tarefa.id, props.tarefa);
        props.closeModal(); 
      } catch (error) {
        erro.value = 'Erro ao atualizar a tarefa: ' + error.message;
      }
    };

    // Função para cancelar a edição e restaurar a tarefa original
    const cancelEdit = () => {
      Object.assign(props.tarefa, originalTask.value);
      props.closeModal(); // Fecha o modal
    };

    return {
      erro,
      updateTask: updateTaskHandler,
      cancelEdit,
    };
  },
};
</script>

<style scoped>
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
  justify-content: space-evenly;
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
