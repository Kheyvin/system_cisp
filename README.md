# System CISP - Analisis de Pasarelas de Pago

## Decision: Mercado Pago (Recomendada)

**Volumen estimado:** 3,000 - 10,000 transacciones  
**Region:** Paises Latinoamericanos

> **Recomendacion:** Mercado Pago permite registro directo sin contacto previo, amplia cobertura en Latinoamerica y multiples metodos de pago incluyendo efectivo.

### Por que Mercado Pago?

1. **Registro directo**: No requiere contacto previo con la empresa
2. **Amplia cobertura**: 8 paises latinoamericanos
3. **Múltiples metodos**: Tarjetas, efectivo (Rapipago, PagoFacil), transferencias
4. **Muy conocida**: Confianza del usuario en la region
5. **SDK PHP oficial**: Integracion sencilla con Symfony
6. **Soporte marketplace**: Ideal para múltiples vendedores

**Alternativa recomendada:** PayU (registro directo, mas metodos de pago, comisiones 3.5-4.5%)

---

## Ventajas de Mercado Pago

- **Registro directo**: No requiere contacto previo, puedes empezar inmediatamente
- Integracion rapida con Symfony (SDK PHP oficial)
- Amplia cobertura: Argentina, Brasil, Chile, Colombia, Mexico, Peru, Uruguay, Venezuela
- Múltiples metodos de pago: tarjetas, efectivo (Rapipago, PagoFacil), transferencias
- Acepta pagos en efectivo (ideal para mercado latino)
- Muy conocida y confiable en la region
- Soporte para marketplaces y múltiples vendedores
- Buen soporte tecnico en español
- API RESTful moderna y bien documentada
- Sin costos mensuales ni de configuracion
- Webhooks confiables para notificaciones

**Costos:** 3.99% + comision variable por transaccion (varia por pais)

---

## Promociones y Descuentos (Mercado Pago)

- **Descuentos por volumen**: Negociables desde $50,000 USD/mes en transacciones
- **Programa de socios**: Descuentos especiales para integradores y partners
- **Promocion de lanzamiento**: Comisiones reducidas los primeros 3 meses (sujeto a aprobacion)
- **Descuentos para e-commerce**: Tarifas especiales para tiendas online verificadas
- **Programa de referidos**: Comisiones compartidas al referir nuevos comercios
- **Programa Marketplace**: Comisiones negociables para plataformas con múltiples vendedores

---

## Otras Pasarelas Evaluadas

### PayU
- **Costos:** 3.5% - 4.5% + comision variable (varia por pais)
- **Cobertura:** Mexico, Argentina, Brasil, Colombia, Peru, Chile
- **Ventajas:** **Registro directo sin contacto previo**, mas de 14 metodos de pago, sin costo de creacion de cuenta, SDK PHP disponible
- **Promociones:** Descuentos por volumen, programa de socios
- **Mejor para:** E-commerce con multiples metodos de pago en varios paises

### Conekta
- **Costos:** 2.9% - 3.6% + comision variable
- **Cobertura:** Mexico (principalmente), expansion en otros paises
- **Ventajas:** **Registro directo**, pasarela mexicana, acepta pagos en efectivo (tiendas de conveniencia), SDK PHP
- **Promociones:** Descuentos para startups, programa de socios
- **Mejor para:** Proyectos enfocados en Mexico

### Todo Pago
- **Costos:** 3.5% - 4.5% + comision variable
- **Cobertura:** Argentina (principalmente)
- **Ventajas:** Pasarela argentina, pagos en cuotas, SDK PHP disponible
- **Promociones:** Descuentos por volumen, promociones especiales
- **Mejor para:** Proyectos enfocados en Argentina

### Kushki
- **Costos:** 2.95% - 3.95% + comision variable
- **Cobertura:** Chile, Colombia, Ecuador, Mexico, Peru
- **Ventajas:** Comisiones competitivas, API moderna, SDK PHP disponible
- **Desventajas:** **Requiere contacto previo con la empresa** (limitante)
- **Mejor para:** Proyectos que pueden esperar proceso de aprobacion

### PayPal
- **Costos:** 3.49% + $0.49 USD
- **Promociones:** Descuentos por volumen (contactar ventas)
- **Mejor para:** Proyectos que requieren reconocimiento de marca internacional

### Stripe
- **Costos:** 2.9% + $0.30 USD
- **Descartado:** Limitado soporte en paises latinoamericanos, requiere cuenta bancaria en paises especificos

### Square
- **Costos:** 2.9% + $0.30 USD
- **Descartado:** Soporte principalmente en Estados Unidos

---

## Referencias

### Mercado Pago (Recomendada)
- [Documentacion Oficial](https://www.mercadopago.com.mx/developers/es/docs)
- [SDK PHP](https://github.com/mercadopago/sdk-php)
- [API de Pagos](https://www.mercadopago.com.mx/developers/es/reference/payments/_payments/post)
- [Webhooks](https://www.mercadopago.com.mx/developers/es/docs/your-integrations/notifications/webhooks)
- [Registro de Cuenta](https://www.mercadopago.com.mx/developers/es/guides/your-integration/credentials)
- [Precios y Comisiones](https://www.mercadopago.com.mx/costs-section)

### PayU
- [Documentacion Oficial](https://developers.payulatam.com/es/docs/)
- [SDK PHP](https://github.com/payu-emea/payu-php-sdk)
- [API de Pagos](https://developers.payulatam.com/es/docs/api/)

### Conekta
- [Documentacion Oficial](https://developers.conekta.com/)
- [SDK PHP](https://github.com/conekta/conekta-php)
- [API de Pagos](https://developers.conekta.com/api)

### Todo Pago
- [Documentacion Oficial](https://developers.todopago.com.ar/)
- [SDK PHP](https://github.com/TodoPago/integration-php-sdk)
- [API de Pagos](https://developers.todopago.com.ar/documentacion)

### Kushki
- [Documentacion Oficial](https://docs.kushkipagos.com/)
- [SDK PHP](https://github.com/Kushki/kushki-php)
- [API de Pagos](https://docs.kushkipagos.com/api/)
- **Nota:** Requiere contacto previo con la empresa

---

## Instalacion Rapida

```bash
composer require mercadopago/dx-php
```

**Variables de entorno:**
```
MERCADOPAGO_ACCESS_TOKEN=APP_USR-...
MERCADOPAGO_PUBLIC_KEY=APP_USR-...
MERCADOPAGO_WEBHOOK_SECRET=...
```

**Nota:** Puedes obtener las credenciales directamente desde el dashboard de Mercado Pago sin necesidad de contacto previo.

---

**Version:** 2.0 | **Fecha:** 2024
