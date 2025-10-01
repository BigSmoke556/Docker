<template>
  <div class="task-create">
    <h3>Criar Nova Tarefa</h3>
    <form @submit.prevent="createTask">
      <input v-model="task.title" placeholder="Título" required />
      <textarea v-model="task.description" placeholder="Descrição" required></textarea>
      <select v-model="task.priority" required>
        <option value="high">Alta</option>
        <option value="medium">Média</option>
        <option value="low">Baixa</option>
      </select>
      <input v-model="task.due_date" type="date" required />
      <button type="submit">Criar</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
const API_URL = process.env.VUE_APP_API_URL || 'http://localhost:8000';
export default {
  name: 'TaskCreate',
  data() {
    return {
      task: {
        title: '',
        description: '',
        priority: 'medium',
        due_date: '',
      },
    };
  },
  methods: {
    async createTask() {
      await axios.post(`${API_URL}/api/tasks`, this.task);
      this.$emit('taskCreated');
      this.task = { title: '', description: '', priority: 'medium', due_date: '' };
    },
  },
};
</script>

<style scoped>
.task-create { padding: 24px; background: #f9f9f9; border-radius: 8px; margin-bottom: 24px; }
form { display: flex; flex-direction: column; gap: 12px; }
input, textarea, select { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
button { padding: 8px 16px; background: #29bb89; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
</style>
