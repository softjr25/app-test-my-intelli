<?php

namespace AppMyIntelli\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AppMyIntelli\Http\Controllers\Controller;
use AppMyIntelli\Book;
use GuzzleHttp\Client;
use AppMyIntelli\Services\ApiService;

class BookController extends Controller
{
    public function index()
    {
        // Obtenemos los libros con su autor para mostrar el nombre en la tabla
       $token = ApiService::getToken(); // Llamada estática para autenticar

        if (!$token) {
            return "Error: No se pudo autenticar con la API.";
        }

        // Hacemos la petición a tu API local
        $client = new Client();
        $response = $client->get('http://webserver/api/books', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ]
        ]);

        // Decodificamos el JSON que devuelve la API
        $data = json_decode($response->getBody()->getContents(), true);
        $books = isset($data['data']) ? $data['data'] : [];

        // Pasamos los datos a la vista
        return view('books.index', compact('books'));
    }
}
