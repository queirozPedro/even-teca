<script setup>
import { RouterLink, RouterView, useRoute } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
import { ref, watchEffect, onMounted } from 'vue'
const route = useRoute()
const isDark = ref(true)

function toggleTheme() {
  isDark.value = !isDark.value
  updateTheme()
}

function updateTheme() {
  const root = document.documentElement
  if (isDark.value) {
    root.style.setProperty('--color-background', '#181818')
    root.style.setProperty('--color-background-soft', '#222c37')
    root.style.setProperty('--color-background-mute', '#282828')
    root.style.setProperty('--color-border', 'rgba(60, 60, 60, 0.12)')
    root.style.setProperty('--color-border-hover', 'rgba(60, 60, 60, 0.29)')
    root.style.setProperty('--color-heading', '#f1f1f1')
    root.style.setProperty('--color-text', '#f1f1f1')
    // login/register form (escuro)
    root.style.setProperty('--login-form-bg', '#222c37')
    root.style.setProperty('--login-form-border', '#2563eb22')
  } else {
    // Cores baseadas no login.blade.php (azul claro, borda azul, texto escuro)
    root.style.setProperty('--color-background', '#f8fafc')
    root.style.setProperty('--color-background-soft', '#fff')
    root.style.setProperty('--color-background-mute', '#f2f2f2')
    root.style.setProperty('--color-border', '#2563eb22')
    root.style.setProperty('--color-border-hover', '#2563eb')
    root.style.setProperty('--color-heading', '#181818')
    root.style.setProperty('--color-text', '#181818')
    // login/register form (azul claro)
    root.style.setProperty('--login-form-bg', 'rgba(59,130,246,0.10)')
    root.style.setProperty('--login-form-border', '#2563eb')
  }
}

onMounted(updateTheme)
watchEffect(updateTheme)
</script>

<template>
  <button
    class="theme-toggle"
    @click="toggleTheme"
    :aria-label="isDark ? 'Ativar modo claro' : 'Ativar modo escuro'"
  >
    <span v-if="isDark">🌙</span>
    <span v-else>☀️</span>
  </button>

  <header v-if="!['/login', '/register'].includes(route.path)">
  </header>

  <RouterView />
</template>

<style scoped>
.theme-toggle {
  position: fixed;
  top: 1.2rem;
  right: 1.2rem;
  z-index: 100;
  background: var(--color-background-soft, #222c37);
  color: var(--color-text, #f1f1f1);
  border: 1.5px solid var(--color-border, #2563eb22);
  border-radius: 50%;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: background 0.2s, color 0.2s, border 0.2s;
}
.theme-toggle:hover {
  background: var(--color-border-hover, #2563eb);
  color: #fff;
}
header {
  line-height: 1.5;
  max-height: 100vh;
}
.logo {
  display: block;
  margin: 0 auto 2rem;
}
nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}
nav a.router-link-exact-active {
  color: var(--color-text);
}
nav a.router-link-exact-active:hover {
  background-color: transparent;
}
nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}
nav a:first-of-type {
  border: 0;
}
@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }
  .logo {
    margin: 0 2rem 0 0;
  }
  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }
  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;
    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
