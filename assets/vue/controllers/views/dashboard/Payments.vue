<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-6">Pagos</h2>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4">Pago Directo con Tarjeta</h3>

      <form @submit.prevent="procesarPago" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Items del Pago
          </label>
          <div v-for="(item, indice) in itemsPago" :key="indice" class="flex gap-2 mb-2">
            <input
              v-model="item.title"
              type="text"
              placeholder="Nombre del item"
              class="flex-1 px-3 py-2 border border-gray-300 rounded-md"
              required
            />
            <input
              v-model.number="item.quantity"
              type="number"
              placeholder="Cantidad"
              min="1"
              class="w-24 px-3 py-2 border border-gray-300 rounded-md"
              required
            />
            <input
              v-model.number="item.unit_price"
              type="number"
              step="0.01"
              placeholder="Precio"
              min="0.01"
              class="w-32 px-3 py-2 border border-gray-300 rounded-md"
              required
            />
            <button
              v-if="itemsPago.length > 1"
              @click="eliminarItem(indice)"
              type="button"
              class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
            >
              Eliminar
            </button>
          </div>
          <button
            @click="agregarItem"
            type="button"
            class="text-sm text-blue-600 hover:text-blue-800"
          >
            + Agregar Item
          </button>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Nombre
            </label>
            <input
              v-model="pagador.name"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Apellido
            </label>
            <input
              v-model="pagador.surname"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md"
              required
            />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Email
          </label>
          <input
            v-model="pagador.email"
            type="email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            required
          />
        </div>

        <div class="border-t pt-4 mt-4">
          <h4 class="text-md font-semibold mb-4">Informacion de la Tarjeta</h4>
          
          <div class="space-y-4">
            <div v-if="!clavePublica" class="text-gray-500 text-sm">
              Cargando configuracion de pago...
            </div>
            <div v-show="clavePublica">
              <MercadoPagoCardFields
                v-if="clavePublica"
                ref="referenciaCamposTarjeta"
                :key="'mp-fields-' + clavePublica"
                :public-key="clavePublica"
                @ready="manejarCamposListos"
                @error="manejarErrorCampos"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Nombre del Titular
              </label>
              <input
                v-model="nombreTitular"
                type="text"
                placeholder="Como aparece en la tarjeta"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Tipo de Documento
              </label>
              <select v-model="tipoIdentificacion" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="DNI">DNI</option>
                <option value="CI">CI</option>
                <option value="LC">LC</option>
                <option value="LE">LE</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Numero de Documento
              </label>
              <input
                v-model="numeroIdentificacion"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Cuotas
              </label>
              <select v-model.number="cuotas" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option v-for="i in 12" :key="i" :value="i">{{ i }} {{ i === 1 ? 'cuota' : 'cuotas' }}</option>
              </select>
            </div>
          </div>
        </div>

        <div class="flex gap-4">
          <button
            type="submit"
            :disabled="cargando || !mpCargado"
            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ cargando ? 'Procesando...' : 'Pagar Ahora' }}
          </button>
        </div>
      </form>
    </div>

    <div v-if="mensaje" :class="tipoMensaje === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'" 
         class="p-4 rounded-md mb-4">
      {{ mensaje }}
    </div>

    <div v-if="resultadoPago" class="bg-green-50 border border-green-200 rounded-lg p-4">
      <p class="text-sm font-medium text-green-900 mb-2">Pago procesado exitosamente!</p>
      <p class="text-xs text-green-700">ID de Orden: {{ resultadoPago.order_id }}</p>
      <p class="text-xs text-green-700">Estado: {{ resultadoPago.status }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4">Pago con Checkout Pro</h3>
      <p class="text-sm text-gray-600 mb-4">
        Serás redirigido a la página segura de Mercado Pago para completar el pago.
      </p>

      <form @submit.prevent="procesarCheckoutPro" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Items del Pago
          </label>
          <div v-for="(item, indice) in itemsCheckoutPro" :key="indice" class="flex gap-2 mb-2">
            <input
              v-model="item.title"
              type="text"
              placeholder="Nombre del item"
              class="flex-1 px-3 py-2 border border-gray-300 rounded-md"
              required
            />
            <input
              v-model.number="item.quantity"
              type="number"
              placeholder="Cantidad"
              min="1"
              class="w-24 px-3 py-2 border border-gray-300 rounded-md"
              required
            />
            <input
              v-model.number="item.unit_price"
              type="number"
              step="0.01"
              placeholder="Precio"
              min="0.01"
              class="w-32 px-3 py-2 border border-gray-300 rounded-md"
              required
            />
            <button
              v-if="itemsCheckoutPro.length > 1"
              @click="eliminarItemCheckoutPro(indice)"
              type="button"
              class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
            >
              Eliminar
            </button>
          </div>
          <button
            @click="agregarItemCheckoutPro"
            type="button"
            class="text-sm text-blue-600 hover:text-blue-800"
          >
            + Agregar Item
          </button>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Nombre
            </label>
            <input
              v-model="pagadorCheckoutPro.name"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Apellido
            </label>
            <input
              v-model="pagadorCheckoutPro.surname"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md"
              required
            />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Email
          </label>
          <input
            v-model="pagadorCheckoutPro.email"
            type="email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            required
          />
        </div>

        <div class="flex gap-4">
          <button
            type="submit"
            :disabled="cargandoCheckoutPro"
            class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ cargandoCheckoutPro ? 'Creando pago...' : 'Ir a Mercado Pago' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import axios from '../../store/token'
import MercadoPagoCardFields from '../../components/payments/MercadoPagoCardFields.vue'

const cargando = ref(false)
const mensaje = ref('')
const tipoMensaje = ref('')
const resultadoPago = ref(null)
const mpCargado = ref(false)
const componenteCamposTarjeta = ref(null)
const clavePublica = ref('')
const cargandoCheckoutPro = ref(false)

const itemsPago = reactive([
  {
    title: '',
    quantity: 1,
    unit_price: 0,
    currency_id: 'MXN',
  }
])

const pagador = reactive({
  name: '',
  surname: '',
  email: '',
})

const nombreTitular = ref('')
const tipoIdentificacion = ref('DNI')
const numeroIdentificacion = ref('')
const cuotas = ref(1)

const itemsCheckoutPro = reactive([
  {
    title: '',
    quantity: 1,
    unit_price: 0,
    currency_id: 'MXN',
  }
])

const pagadorCheckoutPro = reactive({
  name: '',
  surname: '',
  email: '',
})

const agregarItem = () => {
  itemsPago.push({
    title: '',
    quantity: 1,
    unit_price: 0,
    currency_id: 'MXN',
  })
}

const eliminarItem = (indice) => {
  itemsPago.splice(indice, 1)
}

const agregarItemCheckoutPro = () => {
  itemsCheckoutPro.push({
    title: '',
    quantity: 1,
    unit_price: 0,
    currency_id: 'MXN',
  })
}

const eliminarItemCheckoutPro = (indice) => {
  itemsCheckoutPro.splice(indice, 1)
}

const inicializarMercadoPago = async () => {
  try {
    const respuesta = await axios.get('/payments/public-key')
    if (respuesta.data.success) {
      clavePublica.value = respuesta.data.public_key
    } else {
      throw new Error('No se pudo obtener la public key')
    }
  } catch (error) {
    console.error('Error al inicializar Mercado Pago:', error)
    mensaje.value = 'Error al cargar el sistema de pagos: ' + error.message
    tipoMensaje.value = 'error'
  }
}

const manejarCamposListos = (campos) => {
  componenteCamposTarjeta.value = campos
  mpCargado.value = true
}

const manejarErrorCampos = (error) => {
  mensaje.value = 'Error al inicializar los campos de tarjeta: ' + error.message
  tipoMensaje.value = 'error'
  mpCargado.value = false
}

const procesarPago = async () => {
  cargando.value = true
  mensaje.value = ''
  tipoMensaje.value = ''
  resultadoPago.value = null

  try {
    if (!componenteCamposTarjeta.value || !componenteCamposTarjeta.value.crearTokenTarjeta) {
      throw new Error('Los campos de tarjeta no listos')
    }

    const itemsValidos = itemsPago.map(item => ({
      title: item.title,
      quantity: parseInt(item.quantity),
      unit_price: parseFloat(item.unit_price),
      currency_id: item.currency_id || 'MXN',
    }))

    if (itemsValidos.some(item => !item.title || item.quantity <= 0 || item.unit_price <= 0)) {
      throw new Error('Completa todos los campos de los items')
    }

    if (!componenteCamposTarjeta.value.validar()) {
      throw new Error('Por favor corrige los errores en los campos de la tarjeta')
    }

    if (!nombreTitular.value || !numeroIdentificacion.value) {
      throw new Error('Por favor completa todos los campos de la tarjeta')
    }

    const montoTotal = itemsValidos.reduce((suma, item) => suma + (item.quantity * item.unit_price), 0)

    const token = await componenteCamposTarjeta.value.crearTokenTarjeta(
      nombreTitular.value,
      tipoIdentificacion.value,
      numeroIdentificacion.value
    )

    if (!token || !token.id) {
      throw new Error('Error al generar el token de la tarjeta')
    }

    const datosOrden = {
      amount: montoTotal,
      payer_email: pagador.email,
      card_token: token.id,
      installments: cuotas.value,
      external_reference: `ref_${Date.now()}`,
    }

    alert('ENVIANDO A API (create-order):\n' + JSON.stringify(datosOrden, null, 2))

    const respuesta = await axios.post('/payments/create-order', datosOrden)

    alert('RECIBIDO DE API (create-order):\n' + JSON.stringify(respuesta.data, null, 2))

    if (respuesta.data.success) {
      resultadoPago.value = {
        order_id: respuesta.data.order_id,
        status: respuesta.data.status,
      }
      mensaje.value = 'Pago procesado exitosamente!'
      tipoMensaje.value = 'success'
      
      itemsPago.splice(1)
      itemsPago[0] = { title: '', quantity: 1, unit_price: 0, currency_id: 'MXN' }
      pagador.name = ''
      pagador.surname = ''
      pagador.email = ''
      nombreTitular.value = ''
      numeroIdentificacion.value = ''
      
      if (componenteCamposTarjeta.value && componenteCamposTarjeta.value.datosTarjeta) {
        componenteCamposTarjeta.value.datosTarjeta.numeroTarjeta = ''
        componenteCamposTarjeta.value.datosTarjeta.fechaVencimiento = ''
        componenteCamposTarjeta.value.datosTarjeta.codigoSeguridad = ''
      }
    } else {
      throw new Error(respuesta.data.message || 'Error al procesar el pago')
    }
  } catch (error) {
    const datosError = error.response?.data || {}
    mensaje.value = datosError.message || error.message || 'Error al procesar el pago'
    tipoMensaje.value = 'error'
    
    if (datosError.use_checkout_pro) {
      mensaje.value += ' Entendiste crje se uso checkout pro'
    }
    
    console.error('Error al procesar pago:', error)
  } finally {
    cargando.value = false
  }
}

const procesarCheckoutPro = async () => {
  cargandoCheckoutPro.value = true
  mensaje.value = ''
  tipoMensaje.value = ''
  resultadoPago.value = null

  try {
    const itemsValidos = itemsCheckoutPro.map(item => ({
      title: item.title,
      quantity: parseInt(item.quantity),
      unit_price: parseFloat(item.unit_price),
      currency_id: item.currency_id || 'MXN',
    }))

    if (itemsValidos.some(item => !item.title || item.quantity <= 0 || item.unit_price <= 0)) {
      throw new Error('Por favor completa todos los campos de los items')
    }

    if (!pagadorCheckoutPro.name || !pagadorCheckoutPro.surname || !pagadorCheckoutPro.email) {
      throw new Error('Por favor completa todos los datos del pagador')
    }

    const datosPreferencia = {
      items: itemsValidos,
      payer: {
        name: pagadorCheckoutPro.name,
        surname: pagadorCheckoutPro.surname,
        email: pagadorCheckoutPro.email,
      },
      external_reference: `ref_${Date.now()}`,
    }

    alert('ENVIANDO A API (create-preference):\n' + JSON.stringify(datosPreferencia, null, 2))

    const respuesta = await axios.post('/payments/create-preference', datosPreferencia)

    alert('RECIBIDO DE API (create-preference):\n' + JSON.stringify(respuesta.data, null, 2))

    if (respuesta.data.success) {
      const urlRedireccion = respuesta.data.sandbox_init_point || respuesta.data.init_point
      
      if (urlRedireccion) {
        alert('REDIRIGIENDO:\n' + 
              'Preference ID: ' + respuesta.data.preference_id + '\n' +
              'URL: ' + urlRedireccion + '\n' +
              'Tipo: ' + (respuesta.data.sandbox_init_point ? 'SANDBOX' : 'PRODUCCIÓN'))
        
        await new Promise(resolve => setTimeout(resolve, 500))
        
        window.location.href = urlRedireccion
      } else {
        throw new Error('No se pudo obtener la URL de pago')
      }
    } else {
      throw new Error(respuesta.data.message || 'Error al crear la preferencia de pago')
    }
  } catch (error) {
    const datosError = error.response?.data || {}
    mensaje.value = datosError.message || error.message || 'Error al procesar el pago'
    tipoMensaje.value = 'error'
    console.error('Error al procesar Checkout Pro:', error)
  } finally {
    cargandoCheckoutPro.value = false
  }
}

onMounted(async () => {
  await inicializarMercadoPago()
})
</script>
