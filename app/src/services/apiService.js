// src/services/apiService.js
import axios from 'axios';

// Crie uma instância do axios com a configuração base
const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${import.meta.env.VITE_API_TOKEN}`,
    },
});

export const getData = async (endpoint) => {
    const response = await api.get(endpoint);
    return response.data;
};

// Função para obter todas as tarefas
export const getAllTasks = async () => {
    try {
        const response = await api.get('/tarefas/');
        return response.data;
    } catch (error) {
        console.error('Erro na requisição GET todas as tarefas:', error);
        throw error;
    }
};


// Função para criar uma nova tarefa
export const createTask = async (taskData) => {
    try {
        const response = await api.post('/tarefas/', taskData);
        return response.data;
    } catch (error) {
        console.error('Erro na requisição POST:', error);
        throw error;
    }
};

// Função para obter uma tarefa pelo ID
export const getTask = async (id) => {
    try {
        const response = await api.get(`/tarefas/${id}`);
        return response.data;
    } catch (error) {
        console.error('Erro na requisição GET tarefa:', error);
        throw error;
    }
};

// Função para atualizar uma tarefa pelo ID
export const updateTask = async (id, taskData) => {
    try {
        const response = await api.put(`/tarefas/${id}`, taskData);
        return response.data;
    } catch (error) {
        console.error('Erro na requisição PUT:', error);
        throw error;
    }
};

// Função para deletar uma tarefa pelo ID
export const deleteTask = async (id) => {
    try {
        const response = await api.delete(`/tarefas/${id}`);
        return response.data;
    } catch (error) {
        console.error('Erro na requisição DELETE:', error);
        throw error;
    }
};
