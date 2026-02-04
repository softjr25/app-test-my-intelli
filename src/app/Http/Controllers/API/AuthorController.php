<?php

namespace AppMyIntelli\Http\Controllers\API;

use AppMyIntelli\Author;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthorController extends BaseController
{
    // Listar todos los autores
    public function index()
    {
        $authors = Author::all();

        return response()->json([
            'OK' => true,
            'code' => 200,
            'message' => 'Listado de autores obtenido correctamente',
            'rows' => $authors->count(), // Cuenta dinámica de filas
            'data' => $authors
        ], 200);
    }

    // Crear un nuevo autor
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nationality' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'OK' => false,
                'code' => 400,
                'message' => 'Error de validación',
                'rows' => 0,
                'data' => $validator->errors()
            ], 400);
        }

        $author = Author::create($request->all());

        return response()->json([
            'OK' => true,
            'code' => 201,
            'message' => 'Autor creado con éxito',
            'rows' => 1,
            'data' => $author
        ], 201);
    }

    // Mostrar un autor específico
    public function show($id)
    {
        // Buscamos al autor por su ID
        $author = Author::find($id);

        // Si el autor no existe, devolvemos un error 404 estandarizado
        if (!$author) {
            return response()->json([
                'OK' => false,
                'code' => 404,
                'message' => 'Autor con ID ' . $id . ' no encontrado',
                'rows' => 0,
                'data' => null
            ], 404);
        }

        // Si existe, devolvemos el éxito con la data del autor
        return response()->json([
            'OK' => true,
            'code' => 200,
            'message' => 'Autor encontrado correctamente',
            'rows' => 1,
            'data' => $author
        ], 200);
    }

    // Actualizar un autor
    public function update(Request $request, $id)
    {
        // 1. Buscar el registro
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'OK' => false,
                'code' => 404,
                'message' => 'No se puede actualizar: Autor no encontrado',
                'rows' => 0,
                'data' => null
            ], 404);
        }

        // 2. Validar los datos nuevos (pueden ser parciales)
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'nationality' => 'sometimes|nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'OK' => false,
                'code' => 400,
                'message' => 'Error en los datos enviados',
                'rows' => 0,
                'data' => $validator->errors()
            ], 400);
        }

        // 3. Actualizar y guardar
        $author->update($request->all());

        return response()->json([
            'OK' => true,
            'code' => 200,
            'message' => 'Autor actualizado correctamente',
            'rows' => 1,
            'data' => $author
        ], 200);
    }

    public function destroy($id)
    {
        // 1. Buscar el autor
        $author = Author::find($id);

        // 2. Si no existe, avisamos con un 404
        if (!$author) {
            return response()->json([
                'OK' => false,
                'code' => 404,
                'message' => 'No se puede eliminar: Autor con ID ' . $id . ' no existe',
                'rows' => 0,
                'data' => null
            ], 404);
        }

        // 3. Eliminar el registro
        $author->delete();

        // 4. Respuesta de éxito
        return response()->json([
            'OK' => true,
            'code' => 200,
            'message' => 'Autor eliminado permanentemente',
            'rows' => 1,
            'data' => null
        ], 200);
    }
}