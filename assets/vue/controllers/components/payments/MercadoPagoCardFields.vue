<template>
  <div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Numero de Tarjeta
      </label>
      <input
        ref="entradaNumeroTarjeta"
        v-model="datosTarjeta.numeroTarjeta"
        type="text"
        placeholder="1234 5678 9012 3456"
        class="w-full px-3 py-2 border border-gray-300 rounded-md"
        maxlength="19"
        @input="formatearNumeroTarjeta"
        @blur="validarNumeroTarjeta"
      />
      <p v-if="errores.numeroTarjeta" class="text-red-500 text-xs mt-1">{{ errores.numeroTarjeta }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Fecha de Vencimiento
        </label>
        <input
          ref="entradaFechaVencimiento"
          v-model="datosTarjeta.fechaVencimiento"
          type="text"
          placeholder="MM/YY"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          maxlength="5"
          @input="formatearFechaVencimiento"
          @blur="validarFechaVencimiento"
        />
        <p v-if="errores.fechaVencimiento" class="text-red-500 text-xs mt-1">{{ errores.fechaVencimiento }}</p>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Codigo de Seguridad
        </label>
        <input
          ref="entradaCodigoSeguridad"
          v-model="datosTarjeta.codigoSeguridad"
          type="text"
          placeholder="123"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          maxlength="4"
          @input="formatearCodigoSeguridad"
          @blur="validarCodigoSeguridad"
        />
        <p v-if="errores.codigoSeguridad" class="text-red-500 text-xs mt-1">{{ errores.codigoSeguridad }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import axios from '../../store/token'

const props = defineProps({
  publicKey: {
    type: String,
    required: true
  }
})

const emit = defineEmits(['ready', 'error'])

const entradaNumeroTarjeta = ref(null)
const entradaFechaVencimiento = ref(null)
const entradaCodigoSeguridad = ref(null)

const datosTarjeta = reactive({
  numeroTarjeta: '',
  fechaVencimiento: '',
  codigoSeguridad: ''
})

const errores = reactive({
  numeroTarjeta: '',
  fechaVencimiento: '',
  codigoSeguridad: ''
})

const formatearNumeroTarjeta = (evento) => {
  let valor = evento.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '')
  const valorFormateado = valor.match(/.{1,4}/g)?.join(' ') || valor
  datosTarjeta.numeroTarjeta = valorFormateado
  errores.numeroTarjeta = ''
}

const validarNumeroTarjeta = () => {
  const numeroTarjeta = datosTarjeta.numeroTarjeta.replace(/\s/g, '')
  if (numeroTarjeta.length < 13 || numeroTarjeta.length > 19) {
    errores.numeroTarjeta = 'El número de tarjeta debe tener entre 13 y 19 dígitos'
    return false
  }
  
  let suma = 0
  let esPar = false
  for (let i = numeroTarjeta.length - 1; i >= 0; i--) {
    let digito = parseInt(numeroTarjeta[i])
    if (esPar) {
      digito *= 2
      if (digito > 9) {
        digito -= 9
      }
    }
    suma += digito
    esPar = !esPar
  }
  
  if (suma % 10 !== 0) {
    errores.numeroTarjeta = 'Número de tarjeta inválido'
    return false
  }
  
  errores.numeroTarjeta = ''
  return true
}

const formatearFechaVencimiento = (evento) => {
  let valor = evento.target.value.replace(/\D/g, '')
  if (valor.length >= 2) {
    valor = valor.substring(0, 2) + '/' + valor.substring(2, 4)
  }
  datosTarjeta.fechaVencimiento = valor
  errores.fechaVencimiento = ''
}

const validarFechaVencimiento = () => {
  const fecha = datosTarjeta.fechaVencimiento.split('/')
  if (fecha.length !== 2) {
    errores.fechaVencimiento = 'Formato inválido. Use MM/YY'
    return false
  }
  
  const mes = parseInt(fecha[0])
  const año = parseInt('20' + fecha[1])
  
  if (mes < 1 || mes > 12) {
    errores.fechaVencimiento = 'Mes inválido'
    return false
  }
  
  const fechaActual = new Date()
  const añoActual = fechaActual.getFullYear()
  const mesActual = fechaActual.getMonth() + 1
  
  if (año < añoActual || (año === añoActual && mes < mesActual)) {
    errores.fechaVencimiento = 'La tarjeta ha expirado'
    return false
  }
  
  errores.fechaVencimiento = ''
  return true
}

const formatearCodigoSeguridad = (evento) => {
  datosTarjeta.codigoSeguridad = evento.target.value.replace(/\D/g, '')
  errores.codigoSeguridad = ''
}

const validarCodigoSeguridad = () => {
  if (datosTarjeta.codigoSeguridad.length < 3 || datosTarjeta.codigoSeguridad.length > 4) {
    errores.codigoSeguridad = 'El código de seguridad debe tener 3 o 4 dígitos'
    return false
  }
  errores.codigoSeguridad = ''
  return true
}

const crearTokenTarjeta = async (nombreTitular, tipoIdentificacion, numeroIdentificacion) => {
  try {
    if (!validarNumeroTarjeta() || !validarFechaVencimiento() || !validarCodigoSeguridad()) {
      throw new Error('Por favor corrige los errores en los campos de la tarjeta')
    }

    const numeroTarjeta = datosTarjeta.numeroTarjeta.replace(/\s/g, '')
    const [mes, año] = datosTarjeta.fechaVencimiento.split('/')
    
    const datosToken = {
      card_number: numeroTarjeta,
      expiration_month: parseInt(mes),
      expiration_year: parseInt('20' + año),
      security_code: datosTarjeta.codigoSeguridad,
      cardholder_name: nombreTitular,
      identification_type: tipoIdentificacion,
      identification_number: numeroIdentificacion
    }

    const datosTokenAlerta = {
      ...datosToken,
      card_number: numeroTarjeta.substring(0, 4) + '****' + numeroTarjeta.substring(numeroTarjeta.length - 4),
      security_code: '***'
    }
    alert('ENVIANDO A API (create-card-token):\n' + JSON.stringify(datosTokenAlerta, null, 2))
    
    const respuesta = await axios.post('/payments/create-card-token', datosToken)

    alert('RECIBIDO DE API (create-card-token):\n' + JSON.stringify(respuesta.data, null, 2))

    if (!respuesta.data.success || !respuesta.data.token) {
      throw new Error(respuesta.data.message || 'Error al crear el token de la tarjeta')
    }

    return respuesta.data.token
  } catch (error) {
    console.error('Error al crear token:', error)
    throw error
  }
}

const obtenerNumeroTarjeta = () => {
  return datosTarjeta.numeroTarjeta
}

const obtenerFechaVencimiento = () => {
  return datosTarjeta.fechaVencimiento
}

const obtenerCodigoSeguridad = () => {
  return datosTarjeta.codigoSeguridad
}

const validar = () => {
  return validarNumeroTarjeta() && validarFechaVencimiento() && validarCodigoSeguridad()
}

defineExpose({
  crearTokenTarjeta,
  obtenerNumeroTarjeta,
  obtenerFechaVencimiento,
  obtenerCodigoSeguridad,
  datosTarjeta,
  validar
})

watch(() => props.publicKey, (nuevaClave) => {
  if (nuevaClave) {
    emit('ready', {
      crearTokenTarjeta,
      obtenerNumeroTarjeta,
      obtenerFechaVencimiento,
      obtenerCodigoSeguridad,
      datosTarjeta,
      validar
    })
  }
}, { immediate: true })
</script>
