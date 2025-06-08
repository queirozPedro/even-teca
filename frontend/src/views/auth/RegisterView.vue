<template>
<div class="register-view fullscreen-auth">
    <h1 class="register-title">
      <RouterLink to="/login" class="register-title-link">EvenTeca</RouterLink>
    </h1>
    <form class="register-form" @submit.prevent="onSubmit">
      <div>
        <label for="name">Nome:</label>
        <input v-model="name" type="text" id="name" required />
      </div>
      <div>
        <label for="email">E-mail:</label>
        <input v-model="email" type="email" id="email" required />
      </div>
      <div>
        <label for="password">Senha:</label>
        <input v-model="password" type="password" id="password" required />
      </div>
      <div>
        <label for="password_confirmation">Confirme a senha:</label>
        <input v-model="passwordConfirmation" type="password" id="password_confirmation" required />
      </div>
      <div>
        <label for="role">Tipo de usuário:</label>
        <select v-model="role" id="role" required>
          <option value="user">Usuário</option>
          <option value="organizer">Organizador</option>
        </select>
      </div>
      <button type="submit">Cadastrar</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const role = ref('user')
function onSubmit() {
  // Aqui você pode adicionar a lógica de cadastro
  alert(`Cadastro:\nNome: ${name.value}\nE-mail: ${email.value}\nTipo: ${role.value}`)
}
</script>

<style scoped>
.register-view {
  min-height: 100vh;
  min-width: 100vw;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  background: var(--color-background, #181818);
}
.register-title {
  text-align: center;
  margin: 0rem 0 1.5rem 0;
}
.register-title-link {
  text-decoration: none;
  color: inherit;
}
.register-form {
  max-width: 400px;
  width: 100%;
  background: var(--login-form-bg, #222c37);
  padding: 2rem;
  border-radius: 1.2rem;
  box-shadow: 0 4px 24px 0 #2563eb22;
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
  border: 1.5px solid var(--login-form-border, #2563eb22);
  color: var(--color-text, #f1f1f1);
}
.register-form label {
  font-weight: bold;
}
.register-form input,
.register-form select {
  width: 100%;
  padding: 0.7rem 1rem;
  border: 1px solid var(--color-border, #cbd5e1);
  border-radius: 0.6rem;
  background: var(--color-background, #181a1b);
  color: var(--color-text, #f1f1f1);
  margin-top: 0.2rem;
  margin-bottom: 0.3rem;
  transition: border 0.2s;
}
.register-form input:focus,
.register-form select:focus {
  border: 1.5px solid #2563eb;
  outline: none;
}
.register-form button {
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
.register-form button:hover {
  background: linear-gradient(90deg, #1d4ed8 60%, #3b82f6 100%);
  transform: scale(1.03);
}
</style>
