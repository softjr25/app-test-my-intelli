<?php

namespace AppMyIntelli\Http\Controllers\API;

use AppMyIntelli\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends BaseController
{
    // Registro de usuario
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            // Estructura para Error de Validación
            return response()->json([
                'OK' => false,
                'code' => 400,
                'message' => 'Error de validación',
                'rows' => 0,
                'data' => $validator->errors()->toJson()
            ], 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        // Estructura de Éxito solicitada
        return response()->json([
            'OK' => true,
            'code' => 201,
            'message' => 'Usuario registrado correctamente',
            'rows' => 1,
            'data' => compact('user', 'token')
        ], 201);
    }

    // Login y generación de Token
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                // Caso: Credenciales incorrectas
                return response()->json([
                    'OK' => false,
                    'code' => 401,
                    'message' => 'Credenciales no válidas',
                    'rows' => 0,
                    'data' => null
                ], 401);
            }
        } catch (JWTException $e) {
            // Caso: Error técnico del servidor con el Token
            return response()->json([
                'OK' => false,
                'code' => 500,
                'message' => 'No se pudo crear el token',
                'rows' => 0,
                'data' => null
            ], 500);
        }

        // Caso: Éxito
        return response()->json([
            'OK' => true,
            'code' => 200,
            'message' => 'Login exitoso',
            'rows' => 1,
            'data' => compact('token')
        ], 200);
    }

    // Ver el usuario autenticado
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}