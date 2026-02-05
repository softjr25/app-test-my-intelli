<?php

namespace AppMyIntelli\Services;

use GuzzleHttp\Client;

class ApiService
{
    protected static $token = null;
    protected static $baseUrl = 'http://webserver'; // Nombre de tu servicio Docker

    /**
     * Obtiene un token de forma estática usando credenciales directas
     */
    public static function getToken()
    {
        $client = new Client();
        try {
            $response = $client->post(self::$baseUrl . '/api/login', [
                'form_params' => [ // Cambiado de 'json' a 'form_params'
                    'email' => 'admin@biblioteca.com',
                    'password' => '12345678',
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $contents = $response->getBody()->getContents();
            $data = json_decode($contents);

            // Verificamos si la propiedad existe antes de asignarla
            self::$token = isset($data->token) ? $data->token : (isset($data->data->token) ? $data->data->token : null);

            return self::$token;
        } catch (\Exception $e) {
            return null;
        }
    }
}