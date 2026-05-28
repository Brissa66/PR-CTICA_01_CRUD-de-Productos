<script setup>
import { computed, reactive, ref, watch } from 'vue'
import { createProducto, updateProducto } from '../services/productoService'

const props = defineProps({
  producto: {
    type: Object,
    default: null,
  },
})

const emit = defineEmits(['guardado', 'cancelar'])

const mensaje = ref('')
const error = ref('')
const guardando = ref(false)

const formulario = reactive({
  nombre: '',
  descripcion: '',
  precio: '',
  stock: 0,
})

const enEdicion = computed(() => Boolean(props.producto?.id))

const limpiarFormulario = () => {
  formulario.nombre = ''
  formulario.descripcion = ''
  formulario.precio = ''
  formulario.stock = 0
}

watch(
  () => props.producto,
  (nuevoProducto) => {
    if (nuevoProducto) {
      formulario.nombre = nuevoProducto.nombre ?? ''
      formulario.descripcion = nuevoProducto.descripcion ?? ''
      formulario.precio = nuevoProducto.precio ?? ''
      formulario.stock = nuevoProducto.stock ?? 0
      mensaje.value = ''
      error.value = ''
      return
    }

    limpiarFormulario()
  },
  { immediate: true },
)

const guardarProducto = async () => {
  mensaje.value = ''
  error.value = ''
  guardando.value = true

  try {
    const payload = {
      nombre: formulario.nombre.trim(),
      descripcion: formulario.descripcion.trim() || null,
      precio: Number(formulario.precio),
      stock: Number(formulario.stock),
    }

    if (enEdicion.value) {
      await updateProducto(props.producto.id, payload)
      mensaje.value = 'Producto actualizado correctamente.'
    } else {
      await createProducto(payload)
      mensaje.value = 'Producto creado correctamente.'
    }

    limpiarFormulario()
    emit('guardado')
  } catch (exception) {
    error.value = exception.response?.data?.message || 'No fue posible guardar el producto.'
  } finally {
    guardando.value = false
  }
}

const cancelarEdicion = () => {
  limpiarFormulario()
  error.value = ''
  mensaje.value = ''
  emit('cancelar')
}
</script>

<template>
  <section class="panel panel--accent">
    <p class="eyebrow">Formulario</p>
    <h2>{{ enEdicion ? 'Editar producto' : 'Nuevo producto' }}</h2>
    <p class="subtitle">Completa los campos para registrar o actualizar un producto sin recargar la página.</p>

    <form class="form-grid" @submit.prevent="guardarProducto">
      <label>
        <span>Nombre</span>
        <input v-model="formulario.nombre" type="text" placeholder="Ej. Laptop Pro 14" required />
      </label>

      <label>
        <span>Descripción</span>
        <textarea v-model="formulario.descripcion" rows="4" placeholder="Breve descripción del producto"></textarea>
      </label>

      <div class="field-row">
        <label>
          <span>Precio</span>
          <input v-model="formulario.precio" type="number" step="0.01" min="0" placeholder="0.00" required />
        </label>

        <label>
          <span>Stock</span>
          <input v-model="formulario.stock" type="number" min="0" step="1" required />
        </label>
      </div>

      <p v-if="mensaje" class="alert alert--success">{{ mensaje }}</p>
      <p v-if="error" class="alert alert--error">{{ error }}</p>

      <div class="form-actions">
        <button class="primary-button" type="submit" :disabled="guardando">
          {{ guardando ? 'Guardando...' : enEdicion ? 'Actualizar producto' : 'Crear producto' }}
        </button>

        <button v-if="enEdicion" class="ghost-button" type="button" @click="cancelarEdicion">
          Cancelar edición
        </button>
      </div>
    </form>
  </section>
</template>
