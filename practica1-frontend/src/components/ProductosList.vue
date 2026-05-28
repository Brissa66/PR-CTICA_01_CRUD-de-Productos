<script setup>
import { onMounted, ref, watch } from 'vue'
import { deleteProducto, getProductos } from '../services/productoService'

const props = defineProps({
  refreshKey: {
    type: Number,
    default: 0,
  },
})

const emit = defineEmits(['editar', 'eliminado'])

const productos = ref([])
const cargando = ref(false)
const error = ref('')
const mensaje = ref('')

const cargarProductos = async () => {
  cargando.value = true
  error.value = ''

  try {
    const response = await getProductos()
    productos.value = response.data
  } catch (exception) {
    error.value = exception.response?.data?.message || 'No fue posible cargar los productos.'
  } finally {
    cargando.value = false
  }
}

const editarProducto = (producto) => {
  emit('editar', producto)
}

const eliminarProducto = async (producto) => {
  const confirmado = window.confirm(`¿Eliminar "${producto.nombre}"?`)

  if (!confirmado) {
    return
  }

  try {
    await deleteProducto(producto.id)
    mensaje.value = 'Producto eliminado correctamente.'
    emit('eliminado', producto.id)
    await cargarProductos()
  } catch (exception) {
    error.value = exception.response?.data?.message || 'No fue posible eliminar el producto.'
  }
}

onMounted(cargarProductos)

watch(
  () => props.refreshKey,
  () => {
    cargarProductos()
  },
)
</script>

<template>
  <section class="panel">
    <div class="panel__header">
      <div>
        <p class="eyebrow">Inventario</p>
        <h2>Productos registrados</h2>
      </div>
      <button class="ghost-button" type="button" @click="cargarProductos">Actualizar</button>
    </div>

    <p v-if="mensaje" class="alert alert--success">{{ mensaje }}</p>
    <p v-if="error" class="alert alert--error">{{ error }}</p>
    <p v-if="cargando" class="state">Cargando productos...</p>

    <div v-if="!cargando && productos.length" class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="producto in productos" :key="producto.id">
            <td>{{ producto.nombre }}</td>
            <td>{{ producto.descripcion || 'Sin descripción' }}</td>
            <td>${{ Number(producto.precio).toFixed(2) }}</td>
            <td>{{ producto.stock }}</td>
            <td class="actions">
              <button class="secondary-button" type="button" @click="editarProducto(producto)">Editar</button>
              <button class="danger-button" type="button" @click="eliminarProducto(producto)">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <p v-else-if="!cargando" class="state">No hay productos registrados todavía.</p>
  </section>
</template>
