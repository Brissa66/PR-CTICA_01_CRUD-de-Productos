<script setup>
import { ref } from 'vue'
import ProductoForm from './components/ProductoForm.vue'
import ProductosList from './components/ProductosList.vue'

const productoSeleccionado = ref(null)
const refreshKey = ref(0)

const manejarGuardado = () => {
  productoSeleccionado.value = null
  refreshKey.value += 1
}

const manejarEdicion = (producto) => {
  productoSeleccionado.value = { ...producto }
}

const cancelarEdicion = () => {
  productoSeleccionado.value = null
}

const manejarEliminado = (id) => {
  if (productoSeleccionado.value?.id === id) {
    productoSeleccionado.value = null
  }

  refreshKey.value += 1
}
</script>

<template>
  <div class="page-shell">
    <main class="app-shell">
      <section class="hero panel">
        <div>
          <p class="eyebrow">Práctica 1</p>
          <h1>CRUD de Productos con Laravel API REST + Vue.js y Axios</h1>
          <p class="hero-copy">
            Backend en Laravel con endpoints JSON y frontend Vue separado para crear, listar, editar y eliminar productos sin recargar la página.
          </p>
        </div>

        <div class="hero-badge">
          <span>API</span>
          <strong>http://localhost:8000/api/productos</strong>
        </div>
      </section>

      <div class="layout-grid">
        <ProductoForm
          :producto="productoSeleccionado"
          @guardado="manejarGuardado"
          @cancelar="cancelarEdicion"
        />

        <ProductosList
          :refresh-key="refreshKey"
          @editar="manejarEdicion"
          @eliminado="manejarEliminado"
        />
      </div>
    </main>
  </div>
</template>
