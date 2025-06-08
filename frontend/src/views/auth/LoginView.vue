<template>
<div class="login-view animate-fade-in fullscreen-auth">
    <h1 class="login-title">
      <RouterLink to="/login" class="login-title-link">EvenTeca</RouterLink>
    </h1>
    <form class="login-form" @submit.prevent="onSubmit">
      <p class="login-desc">Realizar Login</p>
      <div>
        <label for="email">E-mail</label>
        <input v-model="email" type="email" id="email" required autofocus />
      </div>
      <div>
        <label for="password">Senha</label>
        <input v-model="password" type="password" id="password" required />
      </div>
      <div class="login-options">
        <label>
          <input v-model="remember" type="checkbox" /> Lembrar-me
        </label>
        <RouterLink to="#" class="forgot-link">Esqueceu a senha?</RouterLink>
      </div>
      <button type="submit" class="login-btn">Entrar</button>
      <p class="login-register">
        Não tem uma conta?
        <RouterLink to="/register">Cadastre-se</RouterLink>
      </p>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
const email = ref('')
const password = ref('')
const remember = ref(false)
function onSubmit() {
  // Aqui você pode adicionar a lógica de autenticação
  alert(`Login: ${email.value}\nSenha: ${password.value}\nLembrar-me: ${remember.value}`)
}
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 1s ease;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}
.login-title {
  text-align: center;
  margin: 0rem 0 1.5rem 0;
}
.login-title-link {
  text-decoration: none;
  color: inherit;
}
.login-view {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  min-width: 100vw;
  position: fixed;
  top: 0;
  left: 0;
  background: var(--color-background, #181818);
  z-index: 10;
}
.login-form {
  width: 100%;
  max-width: 400px;
  background: var(--login-form-bg, #222c37);
  border-radius: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  padding: 2rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  border: 1.5px solid var(--login-form-border, #2563eb22);
  color: var(--color-text, #f1f1f1);
}
.login-form label {
  display: block;
  font-weight: 600;
  margin-bottom: 0.2rem;
}
.login-form input[type="email"],
.login-form input[type="password"] {
  width: 100%;
  padding: 0.7rem 1rem;
  border: 1px solid var(--color-border, #cbd5e1);
  border-radius: 0.6rem;
  background: var(--color-background, #181a1b);
  color: var(--color-text, #f1f1f1);
  margin-bottom: 0.3rem;
  transition: border 0.2s;
}
.login-form input[type="email"]:focus,
.login-form input[type="password"]:focus {
  border: 1.5px solid #2563eb;
  outline: none;
}
.login-options {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.95rem;
}
.forgot-link {
  color: #60a5fa;
  text-decoration: none;
}
.forgot-link:hover {
  text-decoration: underline;
}
.login-btn {
  width: 100%;
  background: linear-gradient(90deg, #2563eb 60%, #60a5fa 100%);
  color: #fff;
  border: none;
  border-radius: 0.6rem;
  padding: 0.7rem 1.2rem;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s, transform 0.1s;
  margin-top: 0.5rem;
}
.login-btn:hover {
  background: linear-gradient(90deg, #1d4ed8 60%, #3b82f6 100%);
  transform: scale(1.03);
}
.login-register {
  margin-top: 1.5rem;
  text-align: center;
  color: #b0b0b0;
  font-size: 0.97rem;
}
.login-register a {
  color: #60a5fa;
  font-weight: 600;
  text-decoration: none;
}
.login-register a:hover {
  text-decoration: underline;
}
</style>
