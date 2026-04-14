<script setup lang="ts">
import { onMounted, ref } from 'vue'

type ApiResponse = {
  ok: boolean
  service: string
  message: string
  timestamp: string
}

const loading = ref(true)
const error = ref('')
const data = ref<ApiResponse | null>(null)

onMounted(async () => {
  try {
    const response = await fetch('/api/test')

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`)
    }

    data.value = (await response.json()) as ApiResponse
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Erreur inconnue'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <main class="test-page">
    <h1>Test Backend/Frontend</h1>

    <p v-if="loading">Chargement de la reponse JSON...</p>
    <p v-else-if="error">Erreur: {{ error }}</p>

    <section v-else-if="data">
      <h2>Reponse backend</h2>
      <pre>{{ JSON.stringify(data, null, 2) }}</pre>
    </section>
  </main>
</template>

<style scoped>
.test-page {
  min-height: 100vh;
  display: grid;
  place-content: center;
  gap: 1rem;
  padding: 2rem;
}

h1,
h2 {
  margin: 0;
}

pre {
  background: #f5f5f5;
  border: 1px solid #d9d9d9;
  padding: 1rem;
  border-radius: 8px;
  text-align: left;
  max-width: 680px;
  overflow: auto;
}
</style>
