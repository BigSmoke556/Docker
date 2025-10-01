<template>
  <div class="users-page">
    <header class="users-header">
      <h2>Gerenciamento de Usuários</h2>
      <button @click="showCreateUser = true">Novo Usuário</button>
    </header>
    <main class="users-main">
      <ul class="users-list">
        <li v-for="user in users" :key="user.id">
          <div class="user-info">
            <span>{{ user.name }} ({{ user.email }})</span>
            <button @click="editUser(user)">Editar</button>
            <button @click="deleteUser(user.id)">Excluir</button>
          </div>
        </li>
      </ul>
      <div v-if="!loading && users.length === 0" class="no-users">Nenhum usuário encontrado.</div>
    </main>
    <div v-if="showCreateUser" class="modal">
      <h3>Criar Usuário</h3>
      <form @submit.prevent="createUser">
        <input v-model="newUser.name" placeholder="Nome" required />
        <input v-model="newUser.email" placeholder="Email" required />
        <input v-model="newUser.password" type="password" placeholder="Senha" required />
        <button type="submit">Salvar</button>
        <button type="button" @click="showCreateUser = false">Cancelar</button>
      </form>
    </div>
    <div v-if="showEditUser" class="modal">
      <h3>Editar Usuário</h3>
      <form @submit.prevent="updateUser">
        <input v-model="editUserData.name" placeholder="Nome" required />
        <input v-model="editUserData.email" placeholder="Email" required />
        <button type="submit">Salvar</button>
        <button type="button" @click="showEditUser = false">Cancelar</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
const API_URL = process.env.VUE_APP_API_URL || 'http://localhost:8000';
export default {
  name: 'UserPanel',
  data() {
    return {
      users: [],
      loading: false,
      showCreateUser: false,
      showEditUser: false,
      newUser: { name: '', email: '', password: '' },
      editUserData: { id: '', name: '', email: '' },
    };
  },
  methods: {
    async fetchUsers() {
      this.loading = true;
      const response = await axios.get(`${API_URL}/api/users`);
      this.users = response.data;
      this.loading = false;
    },
    async createUser() {
      await axios.post(`${API_URL}/api/users`, this.newUser);
      this.showCreateUser = false;
      this.newUser = { name: '', email: '', password: '' };
      this.fetchUsers();
    },
    editUser(user) {
      this.editUserData = { ...user };
      this.showEditUser = true;
    },
    async updateUser() {
      await axios.put(`${API_URL}/api/users/${this.editUserData.id}`, this.editUserData);
      this.showEditUser = false;
      this.fetchUsers();
    },
    async deleteUser(id) {
      await axios.delete(`${API_URL}/api/users/${id}`);
      this.fetchUsers();
    },
  },
  mounted() {
    this.fetchUsers();
  },
};
</script>

<style scoped>
.users-page { padding: 32px; }
.users-header { display: flex; justify-content: space-between; align-items: center; }
.users-list { list-style: none; padding: 0; }
.user-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
.no-users { color: #bbb; margin: 28px 0; text-align: center; }
.modal { background: #fff; border: 1px solid #ccc; padding: 24px; position: fixed; top: 20%; left: 50%; transform: translate(-50%, 0); z-index: 10; }
</style>
