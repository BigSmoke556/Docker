<template>
  <div class="task-edit">
    <h3>Editar Tarefa</h3>
    <form @submit.prevent="updateTask">
      <input v-model="task.title" placeholder="Título" required />
      <textarea v-model="task.description" placeholder="Descrição" required></textarea>
      <select v-model="task.priority" required>
        <option value="high">Alta</option>
        <option value="medium">Média</option>
        <option value="low">Baixa</option>
      </select>
      <input v-model="task.due_date" type="date" required />
      <button type="submit">Salvar</button>
      <button type="button" @click="$emit('cancelEdit')">Cancelar</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
const API_URL = process.env.VUE_APP_API_URL || 'http://localhost:8000';
export default {
  name: 'TaskEdit',
  props: {
    taskData: { type: Object, required: true },
  },
  data() {
    return {
      task: { ...this.taskData },
    };
  },
  methods: {
    async updateTask() {
      await axios.put(`${API_URL}/api/tasks/${this.task.id}`, this.task);
      this.$emit('taskUpdated');
    },
  },
  watch: {
    taskData(newVal) {
      this.task = { ...newVal };
    },
  },
};
</script>

<style scoped>
.task-edit { padding: 24px; background: #f9f9f9; border-radius: 8px; margin-bottom: 24px; }
form { display: flex; flex-direction: column; gap: 12px; }
input, textarea, select { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
button { padding: 8px 16px; background: #ffd000; color: #333; border: none; border-radius: 4px; cursor: pointer; }
</style>
