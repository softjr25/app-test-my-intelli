<?php

namespace AppMyIntelli\Http\Controllers\API;

use AppMyIntelli\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class BookController extends BaseController
{
    public function index()
    {
        $books = Book::with('author')->get();

        // Nuestra estructura estandarizada
        return response()->json([
            'OK' => true,
            'code' => 200,
            'message' => 'Listado de libros obtenido correctamente',
            'rows' => $books->count(), // Conteo real de la colección
            'data' => $books
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author_id' => 'required|integer|exists:authors,id', // Verifica que el autor exista
            'year' => 'required|integer',
            'isbn' => 'required|string|unique:books,isbn', // ISBN único para no repetir libros
        ]);

        // 2. Si falla la validación, devolvemos la armadura de error
        if ($validator->fails()) {
            return response()->json([
                'OK' => false,
                'code' => 400,
                'message' => 'Error de validación en los datos del libro',
                'rows' => 0,
                'data' => $validator->errors()
            ], 400);
        }

        // 3. Crear el libro
        $book = Book::create($request->all());

        // 4. Respuesta de éxito estandarizada
        return response()->json([
            'OK' => true,
            'code' => 201,
            'message' => 'Libro creado y vinculado al autor correctamente',
            'rows' => 1,
            'data' => $book
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // 1. Buscar el libro
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'OK' => false,
                'code' => 404,
                'message' => 'No se puede actualizar: Libro no encontrado',
                'rows' => 0,
                'data' => null
            ], 404);
        }

        // 2. Validar los datos (usamos 'sometimes' para permitir actualizaciones parciales)
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'author_id' => 'sometimes|required|integer|exists:authors,id',
            'year' => 'sometimes|required|integer',
            'isbn' => 'sometimes|required|string|unique:books,isbn,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'OK' => false,
                'code' => 400,
                'message' => 'Error de validación en la actualización',
                'rows' => 0,
                'data' => $validator->errors()
            ], 400);
        }

        // 3. Aplicar cambios
        $book->update($request->all());

        // 4. Devolver el libro actualizado con su autor cargado
        return response()->json([
            'OK' => true,
            'code' => 200,
            'message' => 'Libro actualizado correctamente',
            'rows' => 1,
            'data' => $book->load('author') // Cargamos la relación para una respuesta completa
        ], 200);
    }

    public function destroy($id)
    {
        // 1. Buscar el libro por su ID
        $book = Book::find($id);

        // 2. Si el libro no existe, devolvemos un 404 estandarizado
        if (!$book) {
            return response()->json([
                'OK' => false,
                'code' => 404,
                'message' => 'No se puede eliminar: El libro con ID ' . $id . ' no existe',
                'rows' => 0,
                'data' => null
            ], 404);
        }

        // 3. Proceder a la eliminación
        $book->delete();

        // 4. Respuesta de éxito
        return response()->json([
            'OK' => true,
            'code' => 200,
            'message' => 'Libro eliminado con éxito de la biblioteca',
            'rows' => 1,
            'data' => null
        ], 200);
    }
}