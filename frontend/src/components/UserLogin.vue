<template>
  <div class="login-root">
    <div class="login-container">
      <h1 class="login-title">Login.</h1>
      <form @submit.prevent="onLogin">
        <InputText
          v-model="email"
          type="email"
          placeholder="E-mail"
          class="login-input"
          autocomplete="username"
          required
        />

        <!-- O Password recebe a mesma classe do e-mail -->
        <Password
          v-model="password"
          :feedback="false"
          placeholder="Password"
          class="login-input"
          toggleMask
          autocomplete="current-password"
          required
        />

        <Button
          type="submit"
          label="Sign In."
          class="login-button"
          :loading="loading"
        />
        <div v-if="error" class="login-error">{{ error }}</div>
      </form>
    </div>
  </div>
</template>

<script>
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import axios from 'axios';
import { API_URL } from '@/config';

export default {
  name: 'UserLogin',
  components: { InputText, Password, Button },
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      error: ''
    };
  },
  methods: {
    async onLogin() {
      this.loading = true;
      this.error = '';
      try {
        const response = await axios.post(`${API_URL}/api/auth/login`, {
          email: this.email,
          password: this.password
        });
        localStorage.setItem('access_token', response.data.access_token);
        localStorage.setItem('user_name', response.data.user.name);
        localStorage.setItem('company_name', response.data.user.company.name);
        this.$router.push('/tasks');
      } catch (err) {
        this.error = 'E-mail ou senha inválidos';
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
/* ===== Layout geral ===== */
.login-root {
  min-height: 100vh;
  background: #181920;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-container {
  background: #23232b;
  border-radius: 16px;
  box-shadow: 0 10px 36px 0 rgba(0,0,0,0.32);
  padding: 40px 32px;
  width: 100%;
  max-width: 430px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.login-title {
  font-family: "Poppins", sans-serif;
  font-weight: 500;
  color: #fff;
  font-size: 2.6rem;
  font-weight: bold;
  margin-bottom: 32px;
  letter-spacing: -1px;
}

/* ===== Inputs ===== */
.login-input {
  width: 100%;
  margin-bottom: 20px;
}


.p-inputtext {
  background: #181920 !important;
  color: #fff !important;
  border-radius: 12px !important;
  border: 2px solid #353542 !important;
  font-size: 1.1rem !important;
  padding: 14px 16px !important;
  transition: border-color 0.2s;
}

:deep(.p-password) {
  width: 100%;
  margin-bottom: 20px;
}

:deep(.p-password .p-inputtext) {
  box-sizing: content-box; 
  width: 330px !important; 
  height: 23px !important; 
  
  background: #181920 !important;
  color: #fff !important;
  border-radius: 12px !important;
  border: 2px solid #353542 !important;
  font-size: 1.1rem !important;
  
  padding: 14px 44px 14px 16px !important; 
  transition: border-color 0.2s;
}

:deep(.p-password .p-inputtext:focus) {
  border-color: #af40ff !important;
  outline: none !important;
}

:deep(.p-password) { position: relative; }
:deep(.p-password .p-password-toggle-mask) {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #aaa;
}
:deep(.p-password .p-password-toggle-mask:hover) { color: #ddd; }


/* ===== Botão ===== */
.login-button {
  width: 100%;
  margin-top: 16px;
  background: linear-gradient(90deg, #a445ff 0%, #fa4299 100%);
  color: #fff;
  font-weight: bold;
  border: none;
  border-radius: 12px;
  font-size: 1.25rem;
  padding: 14px 0;
  box-shadow: 0 4px 16px 0 rgba(174,68,255,0.14);
  transition: background 0.2s;
}
.login-button:hover {
  background: linear-gradient(90deg, #a445ff 30%, #fa4299 90%);
}

/* ===== Erro ===== */
.login-error {
  color: #ff2c5a;
  text-align: center;
  margin-top: 18px;
  font-weight: 500;
  letter-spacing: .01em;
}
</style>
