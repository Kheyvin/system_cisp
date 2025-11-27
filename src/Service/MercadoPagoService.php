<?php

namespace App\Service;

use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Order\OrderClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use Psr\Log\LoggerInterface;

class MercadoPagoService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private function autenticar(): void
    {
        $tokenAcceso = $_ENV['MERCADOPAGO_ACCESS_TOKEN'] ?? getenv('MERCADOPAGO_ACCESS_TOKEN') ?: null;

        if (!$tokenAcceso) {
            throw new \RuntimeException('MERCADOPAGO_ACCESS_TOKEN no esta configurado en .env');
        }

        MercadoPagoConfig::setAccessToken($tokenAcceso);

        $entornoApp = $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?: 'dev';
        $entornoEjecucion = $entornoApp === 'dev' 
            ? MercadoPagoConfig::LOCAL 
            : MercadoPagoConfig::SERVER;
        
        MercadoPagoConfig::setRuntimeEnviroment($entornoEjecucion);
    }

    public function crearPreferencia(
        array $items,
        array $pagador,
        array $urlsRetorno = [],
        ?string $referenciaExterna = null
    ): ?object {
        $this->autenticar();
        
        $cliente = new PreferenceClient();

        $itemsFormateados = [];
        foreach ($items as $item) {
            $itemsFormateados[] = [
                'title' => $item['title'],
                'quantity' => (int) $item['quantity'],
                'unit_price' => (float) $item['unit_price'],
                'currency_id' => $item['currency_id'] ?? 'MXN',
            ];
        }

        $urlApp = $_ENV['APP_URL'] ?? getenv('APP_URL') ?: 'http://localhost:8000';
        $urlsRetornoFinales = !empty($urlsRetorno) ? $urlsRetorno : [
            'success' => $urlApp . '/dashboard/pagos',
            'failure' => $urlApp . '/dashboard/pagos',
            'pending' => $urlApp . '/dashboard/pagos',
        ];

        $solicitud = [
            'items' => $itemsFormateados,
            'payer' => $pagador,
            'payment_methods' => [
                'excluded_payment_methods' => [],
                'installments' => 12,
                'default_installments' => 1,
            ],
            'back_urls' => $urlsRetornoFinales,
            'statement_descriptor' => $_ENV['MERCADOPAGO_STATEMENT_DESCRIPTOR'] ?? getenv('MERCADOPAGO_STATEMENT_DESCRIPTOR') ?: 'CISP',
            'external_reference' => $referenciaExterna ?? uniqid('ref_', true),
            'expires' => false,
        ];

        $this->logger->debug('Creando preferencia de Mercado Pago', [
            'back_urls' => $urlsRetornoFinales,
            'items_count' => count($itemsFormateados),
        ]);

        try {
            $preferencia = $cliente->create($solicitud);
            $this->logger->info('Preferencia de Mercado Pago creada', [
                'preference_id' => $preferencia->id,
                'external_reference' => $referenciaExterna,
            ]);

            return $preferencia;
        } catch (MPApiException $e) {
            $contenidoError = $e->getApiResponse()->getContent();
            $mensajeError = is_array($contenidoError) && isset($contenidoError['message']) 
                ? $contenidoError['message'] 
                : json_encode($contenidoError);
            
            $this->logger->error('Error al crear preferencia de Mercado Pago', [
                'status_code' => $e->getApiResponse()->getStatusCode(),
                'content' => $contenidoError,
                'message' => $mensajeError,
            ]);

            throw new \RuntimeException('Error de Mercado Pago: ' . $mensajeError, 0, $e);
        } catch (\Exception $e) {
            $this->logger->error('Error inesperado al crear preferencia', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    public function crearOrden(
        float $monto,
        string $emailPagador,
        string $tokenTarjeta,
        ?string $referenciaExterna = null,
        int $cuotas = 1
    ): ?object {
        $this->autenticar();
        
        $cliente = new OrderClient();

        $solicitud = [
            'type' => 'online',
            'processing_mode' => 'automatic',
            'total_amount' => number_format($monto, 2, '.', ''),
            'external_reference' => $referenciaExterna ?? uniqid('order_', true),
            'capture_mode' => 'automatic_async',
            'payer' => [
                'email' => $emailPagador,
            ],
            'transactions' => [
                'payments' => [
                    [
                        'amount' => number_format($monto, 2, '.', ''),
                        'payment_method' => [
                            'type' => 'credit_card',
                            'token' => $tokenTarjeta,
                            'installments' => $cuotas,
                            'statement_descriptor' => $_ENV['MERCADOPAGO_STATEMENT_DESCRIPTOR'] ?? getenv('MERCADOPAGO_STATEMENT_DESCRIPTOR') ?: 'CISP',
                        ],
                    ],
                ],
            ],
        ];

        $opcionesSolicitud = new RequestOptions();
        $opcionesSolicitud->setCustomHeaders([
            'X-Idempotency-Key: ' . uniqid('idemp_', true),
        ]);

        try {
            $orden = $cliente->create($solicitud, $opcionesSolicitud);
            $this->logger->info('Orden de Mercado Pago creada', [
                'order_id' => $orden->id,
                'external_reference' => $referenciaExterna,
            ]);

            return $orden;
        } catch (MPApiException $e) {
            $contenidoError = $e->getApiResponse()->getContent();
            $mensajeError = is_array($contenidoError) && isset($contenidoError['message']) 
                ? $contenidoError['message'] 
                : json_encode($contenidoError);
            
            $this->logger->error('Error al crear orden de Mercado Pago', [
                'status_code' => $e->getApiResponse()->getStatusCode(),
                'content' => $contenidoError,
                'message' => $mensajeError,
                'request' => $solicitud,
            ]);

            throw new \RuntimeException('Error de Mercado Pago: ' . $mensajeError, 0, $e);
        } catch (\Exception $e) {
            $this->logger->error('Error inesperado al crear orden', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    public function obtenerPreferencia(string $idPreferencia): ?object
    {
        $cliente = new PreferenceClient();

        try {
            return $cliente->get($idPreferencia);
        } catch (MPApiException $e) {
            $this->logger->error('Error al obtener preferencia', [
                'preference_id' => $idPreferencia,
                'status_code' => $e->getApiResponse()->getStatusCode(),
            ]);

            return null;
        }
    }

    public function crearTokenTarjeta(
        string $numeroTarjeta,
        int $mesExpiracion,
        int $añoExpiracion,
        string $codigoSeguridad,
        string $nombreTitular,
        string $tipoIdentificacion,
        string $numeroIdentificacion
    ): ?array {
        $clavePublica = $_ENV['MERCADOPAGO_PUBLIC_KEY'] ?? getenv('MERCADOPAGO_PUBLIC_KEY') ?: null;

        if (!$clavePublica) {
            throw new \RuntimeException('MERCADOPAGO_PUBLIC_KEY no está configurado en .env');
        }

        $url = 'https://api.mercadopago.com/v1/card_tokens?public_key=' . urlencode($clavePublica);
        
        $datos = [
            'card_number' => $numeroTarjeta,
            'expiration_month' => $mesExpiracion,
            'expiration_year' => $añoExpiracion,
            'security_code' => $codigoSeguridad,
            'cardholder' => [
                'name' => $nombreTitular,
                'identification' => [
                    'type' => $tipoIdentificacion,
                    'number' => $numeroIdentificacion,
                ],
            ],
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        
        $entornoApp = $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?: 'dev';
        if ($entornoApp === 'dev') {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        } else {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        }

        $respuesta = curl_exec($curl);
        $codigoHttp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $errorCurl = curl_error($curl);
        curl_close($curl);

        if ($errorCurl) {
            $this->logger->error('Error de cURL al crear token de tarjeta', [
                'error' => $errorCurl,
            ]);
            throw new \RuntimeException('Error de conexión: ' . $errorCurl);
        }

        if ($codigoHttp !== 201) {
            $datosError = json_decode($respuesta, true);
            $mensajeError = is_array($datosError) && isset($datosError['message']) 
                ? $datosError['message'] 
                : ($respuesta ?: 'Error desconocido');
            
            $this->logger->error('Error al crear token de tarjeta', [
                'http_code' => $codigoHttp,
                'response' => $datosError ?: $respuesta,
                'message' => $mensajeError,
                'card_number_length' => strlen($numeroTarjeta),
                'expiration_month' => $mesExpiracion,
                'expiration_year' => $añoExpiracion,
            ]);
            throw new \RuntimeException('Error de Mercado Pago: ' . $mensajeError);
        }

        $datosToken = json_decode($respuesta, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logger->error('Error al decodificar respuesta de token', [
                'json_error' => json_last_error_msg(),
                'response' => $respuesta,
            ]);
            throw new \RuntimeException('Error al procesar la respuesta de Mercado Pago');
        }

        $this->logger->info('Token de tarjeta creado exitosamente', [
            'token_id' => $datosToken['id'] ?? null,
        ]);

        return $datosToken;
    }
}
