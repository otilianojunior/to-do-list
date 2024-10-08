<template>
    <div class="modal-overlay" v-if="isModalOpen">
        <div class="modal">
            <h2 class="modal-title">Deseja realmente excluir esta tarefa?</h2>
            <div class="button-container">
                <button @click="confirmarExclusao" class="edit-button">Sim</button>
                <button @click="cancelarExclusao" class="cancel-button delete-button">Não</button>
            </div>
            <div v-if="erro" class="error">{{ erro }}</div>
        </div>
    </div>
</template>

<script>
import { deleteTask } from '@/services/apiService';
import { ref, watch } from 'vue';

// Componente para confirmação de exclusão de tarefa
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

        // Reseta o erro ao fechar o modal
        watch(() => props.isModalOpen, (newVal) => {
            if (!newVal) {
                erro.value = null;
            }
        });

        // Função para confirmar a exclusão da tarefa
        const confirmarExclusao = async () => {
            try {
                await deleteTask(props.tarefa.id);
                props.closeModal();
                window.location.reload();
            } catch (error) {
                erro.value = 'Erro ao excluir a tarefa: ' + error.message;
            }
        };

        // Função para cancelar a exclusão da tarefa
        const cancelarExclusao = () => {
            props.closeModal(); // Fecha o modal sem excluir
        };

        return {
            erro,
            confirmarExclusao,
            cancelarExclusao
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

.modal-title {
    color: black;
}

.button-container {
    display: flex;
    margin-top: auto;
    margin-bottom: auto;
    margin-left: auto;
    margin-right: auto;
    justify-content: space-evenly;
}

button {
    margin-left: auto;
    margin-right: auto;
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
    background-color: #78a8db;
    opacity: 0.8;
}

.delete-button:hover {
    background-color: darkred;
}

.error {
    color: red;
    margin-top: 10px;
}
</style>
