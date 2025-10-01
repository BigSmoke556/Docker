<template>
  <div class="task-delete">
    <h3>Excluir Tarefa</h3>
    <p>Tem certeza que deseja excluir a tarefa <strong>{{ task.title }}</strong>?</p>
    <button @click="deleteTask">Excluir</button>
    <button @click="$emit('cancelDelete')">Cancelar</button>
  </div>
</template>

<script>
import axios from 'axios';
const API_URL = process.env.VUE_APP_API_URL || 'http://localhost:8000';
export default {
  name: 'TaskDelete',
  props: {
    task: { type: Object, required: true },
  },
  methods: {
    async deleteTask() {
      await axios.delete(`${API_URL}/api/tasks/${this.task.id}`);
      this.$emit('taskDeleted');
    },
  },
};
</script>

<style scoped>
.task-delete { padding: 24px; background: #fff2f5; border-radius: 8px; margin-bottom: 24px; }
button { padding: 8px 16px; margin-right: 8px; background: #ff0000; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
button:last-child { background: #bbb; color: #333; }
</style>
