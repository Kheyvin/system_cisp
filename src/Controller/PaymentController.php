<?php

namespace App\Controller;

use App\Service\MercadoPagoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/payments', name: 'api_payments_')]
class PaymentController extends AbstractController
{
    public function __construct(
        private MercadoPagoService $mercadoPagoService
    ) {
    }

    #[Route('/create-preference', name: 'create_preference', methods: ['POST'])]
    public function crearPreferencia(Request $solicitud): JsonResponse
    {
        try {
            $datos = json_decode($solicitud->getContent(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'success' => false,
                    'message' => 'JSON invalido: ' . json_last_error_msg(),
                ], Response::HTTP_BAD_REQUEST);
            }

            if (!isset($datos['items']) || !isset($datos['payer'])) {
                return $this->json([
                    'success' => false,
                    'message' => 'Items y payer son requeridos',
                ], Response::HTTP_BAD_REQUEST);
            }

            $items = $datos['items'];
            $pagador = $datos['payer'];
            $urlsRetorno = $datos['back_urls'] ?? [];
            $referenciaExterna = $datos['external_reference'] ?? null;

            foreach ($items as $item) {
                if (!isset($item['title']) || !isset($item['quantity']) || !isset($item['unit_price'])) {
                    return $this->json([
                        'success' => false,
                        'message' => 'Cada item debe tener title, quantity y unit_price',
                    ], Response::HTTP_BAD_REQUEST);
                }
            }

            try {
                $preferencia = $this->mercadoPagoService->crearPreferencia(
                    $items,
                    $pagador,
                    $urlsRetorno,
                    $referenciaExterna
                );

                if (!$preferencia) {
                    return $this->json([
                        'success' => false,
                        'message' => 'Error al crear la preferencia de pago. Verifica las credenciales de Mercado Pago.',
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } catch (\RuntimeException $e) {
                return $this->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->json([
                'success' => true,
                'preference_id' => $preferencia->id,
                'init_point' => $preferencia->init_point ?? null,
                'sandbox_init_point' => $preferencia->sandbox_init_point ?? null,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/create-order', name: 'create_order', methods: ['POST'])]
    public function crearOrden(Request $solicitud): JsonResponse
    {
        $datos = json_decode($solicitud->getContent(), true);

        if (!isset($datos['amount']) || !isset($datos['payer_email']) || !isset($datos['card_token'])) {
            return $this->json([
                'success' => false,
                'message' => 'amount, payer_email y card_token son requeridos',
            ], Response::HTTP_BAD_REQUEST);
        }

        $monto = (float) $datos['amount'];
        $emailPagador = $datos['payer_email'];
        $tokenTarjeta = $datos['card_token'];
        $referenciaExterna = $datos['external_reference'] ?? null;
        $cuotas = $datos['installments'] ?? 1;

        if ($monto <= 0) {
            return $this->json([
                'success' => false,
                'message' => 'El monto debe ser mayor a 0',
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $orden = $this->mercadoPagoService->crearOrden(
                $monto,
                $emailPagador,
                $tokenTarjeta,
                $referenciaExterna,
                $cuotas
            );

            if (!$orden) {
                return $this->json([
                    'success' => false,
                    'message' => 'Error al crear la orden de pago',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->json([
                'success' => true,
                'order_id' => $orden->id,
                'status' => $orden->status ?? null,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            error_log('Error en crearOrden: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            
            $mensajeError = $e->getMessage();
            
            if (strpos($mensajeError, 'invalid_credentials') !== false || strpos($mensajeError, 'Test credentials') !== false) {
                $mensajeError = 'Las credenciales de prueba no permiten crear órdenes de pago directo. ' .
                    'Para usar pagos directos necesitas credenciales de producción. ' .
                    'Alternativamente, puedes usar Checkout Pro que funciona con credenciales de prueba.';
            }
            
            return $this->json([
                'success' => false,
                'message' => $mensajeError,
                'use_checkout_pro' => strpos($e->getMessage(), 'invalid_credentials') !== false || strpos($e->getMessage(), 'Test credentials') !== false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/webhook', name: 'webhook', methods: ['POST'])]
    public function webhook(Request $solicitud): JsonResponse
    {
        $datos = json_decode($solicitud->getContent(), true);

        error_log('Webhook de Mercado Pago recibido: ' . json_encode($datos));

        if (isset($datos['type']) && isset($datos['data'])) {
            $tipo = $datos['type'];
            $idRecurso = $datos['data']['id'] ?? null;

            return $this->json([
                'success' => true,
                'message' => 'Webhook procesado',
                'type' => $tipo,
                'resource_id' => $idRecurso,
            ]);
        }

        return $this->json([
            'success' => false,
            'message' => 'Formato de webhook invalido',
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/public-key', name: 'public_key', methods: ['GET'])]
    public function obtenerClavePublica(): JsonResponse
    {
        $clavePublica = $_ENV['MERCADOPAGO_PUBLIC_KEY'] ?? getenv('MERCADOPAGO_PUBLIC_KEY') ?: null;

        if (!$clavePublica) {
            return $this->json([
                'success' => false,
                'message' => 'Public key no configurada',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'success' => true,
            'public_key' => $clavePublica,
        ]);
    }

    #[Route('/create-card-token', name: 'create_card_token', methods: ['POST'])]
    public function crearTokenTarjeta(Request $solicitud): JsonResponse
    {
        try {
            $datos = json_decode($solicitud->getContent(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'success' => false,
                    'message' => 'JSON invalido: ' . json_last_error_msg(),
                ], Response::HTTP_BAD_REQUEST);
            }

            $camposRequeridos = ['card_number', 'expiration_month', 'expiration_year', 'security_code', 'cardholder_name', 'identification_type', 'identification_number'];
            foreach ($camposRequeridos as $campo) {
                if (!isset($datos[$campo])) {
                    return $this->json([
                        'success' => false,
                        'message' => "El campo {$campo} es requerido",
                    ], Response::HTTP_BAD_REQUEST);
                }
            }

            if (!is_numeric($datos['expiration_month']) || $datos['expiration_month'] < 1 || $datos['expiration_month'] > 12) {
                return $this->json([
                    'success' => false,
                    'message' => 'El mes de expiración debe ser un número entre 1 y 12',
                ], Response::HTTP_BAD_REQUEST);
            }

            if (!is_numeric($datos['expiration_year']) || $datos['expiration_year'] < 2020) {
                return $this->json([
                    'success' => false,
                    'message' => 'El año de expiración debe ser válido',
                ], Response::HTTP_BAD_REQUEST);
            }

            $token = $this->mercadoPagoService->crearTokenTarjeta(
                (string) $datos['card_number'],
                (int) $datos['expiration_month'],
                (int) $datos['expiration_year'],
                (string) $datos['security_code'],
                (string) $datos['cardholder_name'],
                (string) $datos['identification_type'],
                (string) $datos['identification_number']
            );

            if (!$token) {
                return $this->json([
                    'success' => false,
                    'message' => 'Error al crear el token de la tarjeta. Verifica las credenciales y los datos de la tarjeta.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->json([
                'success' => true,
                'token' => $token,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            error_log('Error en crearTokenTarjeta: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            return $this->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
