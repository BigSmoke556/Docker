<template>
  <div class="tasks-page">
    <header class="tasks-header">
      <div>
        <span class="user-info">{{ userName }} | {{ companyName }}</span>
      </div>
      <Button 
        label="Logout"
        icon="pi pi-sign-out"
        class="logout-btn"
        @click="logout"
      />
    </header>

    <main class="tasks-main">
      <h2>My Tasks</h2>
      <div v-if="loading" class="loading">Carregando tarefas...</div>
      <div v-if="error" class="error">{{ error }}</div>
      <ul class="tasks-list">
        <li v-for="task in tasks" :key="task.id" :class="priorityClass(task.priority)">
          <div class="task-title">{{ task.title }}</div>
          <div class="task-desc">{{ task.description }}</div>
          <span class="task-priority">{{ task.priority }}</span>
        </li>
      </ul>
      <div v-if="!loading && tasks.length === 0" class="no-tasks">Nenhuma tarefa encontrada.</div>
    </main>
  </div>
</template>

<script>
import Button from 'primevue/button';
import axios from 'axios';
import { API_URL } from '@/config'; 

export default {
  name: 'TaskList',
  components: { Button },
  data() {
    return {
      tasks: [],
      loading: true,
      error: '',
      userName: localStorage.getItem('user_name') || 'Usuário',
      companyName: localStorage.getItem('company_name') || 'Empresa'
    }
  },
  methods: {
    async fetchTasks() {
      this.loading = true;
      this.error = '';
      try {
        const token = localStorage.getItem('access_token');
        const response = await axios.get(`${API_URL}/api/tasks`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.tasks = response.data.data || response.data; 
      } catch (err) {
        this.error = 'Erro ao buscar tarefas. Faça login novamente.';
        if (err.response && err.response.status === 401) {
          this.logout();
        }
      } finally {
        this.loading = false;
      }
    },
    priorityClass(priority) {
      switch ((priority || '').toLowerCase()) {
        case 'alta':
        case 'high':
          return 'task-high';
        case 'media':
        case 'média':
        case 'medium':
          return 'task-medium';
        case 'baixa':
        case 'low':
          return 'task-low';
        default:
          return '';
      }
    },
    logout() {
      localStorage.clear();
      this.$router.push('/');
    }
  },
  created() {
    if (!localStorage.getItem('access_token')) {
      this.$router.push('/');
    } else {
      this.fetchTasks();
    }
  }
}
</script>

<style scoped>
.tasks-page {
  background: #181920;
  min-height: 100vh;
  padding: 0;
}
.tasks-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #23232b;
  color: #fff;
  padding: 18px 32px;
  box-shadow: 0 2px 8px rgba(0,0,0,.07);
}
.user-info {
  font-family: "Poppins", sans-serif;
  font-size: 26px;
}
.logout-btn {
  background: linear-gradient(90deg, #a445ff 0%, #fa4299 100%);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  padding: 8px 18px;
  box-shadow: 0 4px 16px 0 rgba(174,68,255,0.14);
  font-weight: 500;
}
.logout-btn:hover {
  background: linear-gradient(90deg, #fa4299 0%, #a445ff 100%);
}
.tasks-main {
  max-width: 660px;
  margin: 32px auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 6px 18px 0 rgba(0,0,0,0.08);
  padding: 32px 40px;
}
.tasks-main h2 {
  font-family: "Poppins", sans-serif;
  color: #23232b;
  font-size: 2rem;
  margin-bottom: 30px;
}
.tasks-list {
  list-style: none;
  margin: 0;
  padding: 0;
}
.tasks-list li {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #fafaff;
  border-radius: 8px;
  box-shadow: 0 2px 6px 0 rgba(160,40,255,0.05);
  padding: 18px 20px;
  margin-bottom: 18px;
  transition: box-shadow .15s;
}
.tasks-list li:last-child {
  margin-bottom: 0;
}
.task-title {
  font-family: "Poppins", medium;
  font-weight: 600;
  font-size: 1.12rem;
  color: #181920;
  flex: 2;
}
.task-desc {
  font-family: Arial, Helvetica, sans-serif;
  color: #666;
  font-size: 18px;
  flex: 3;
  margin-left: 24px;
}
.task-priority {
  font-family: "Poppins";
  font-weight: bold;
  font-size: 1rem;
  margin-left: 18px;
  padding: 5px 14px;
  border-radius: 8px;
}
.task-high    { border-left: 5px solid #ff0000;  background: #fff2f5; }
.task-high .task-priority    { background: #ff0000; color: #fff; }
.task-medium  { border-left: 5px solid #ffd000;  background: #fffcea; }
.task-medium .task-priority  { background: #ffd000; color: #333; }
.task-low     { border-left: 5px solid #29bb89;  background: #f2fff6; }
.task-low .task-priority     { background: #29bb89; color: #fff; }
.loading { color: #888; }
.error { color: #ff0000; margin: 12px 0; }
.no-tasks { color: #bbb; margin: 28px 0; text-align: center; }
</style>
