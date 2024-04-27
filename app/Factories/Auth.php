<?php

namespace App\Factories;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Usuario as ModelUsuaurio;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class Auth
{
    public static function login(array $usuario)
    {

        $usuario_db = ModelUsuaurio::where('email', $usuario['email'])->where('estatus', ModelUsuaurio::ESTATUS_ACTIVO)->first();

        if (!$usuario_db)
            throw new Exception('Usuario o contraseña invalido', 401);


        if (!password_verify($usuario['password'], $usuario_db['password']))
            throw new Exception('La contraseña no coincide', 401);


        $token_fecha_creacion = Carbon::now()->timestamp;
        $toke_life = time() + intval(env('TOKEN_LIFE'));
        $token_secret = env('TOKEN_SECRET');
        $token_algoritmo = env('TOKEN_ALGORITMO');


        $payload = [
            'exp' => $toke_life,  //Expiración de token 1h
            'iat' => $token_fecha_creacion, // Hora en la que se crea el token formato UNIX
            'data' => [
                'usuario_id'  => $usuario_db['id'],
                'username'    => $usuario_db['username'],
                'nombre_completo' => $usuario_db['nombre_completo'],
                'email'       => $usuario_db['email'],
                'estatus'     => $usuario_db['estatus'],
            ]
        ];

        $token = JWT::encode($payload, $token_secret, $token_algoritmo);

        if (!$token)
            throw new Exception('No es posible iniciar sesión, comunicate con tu administrador', 500);

        return [
            'exp' => $toke_life,
            'iat' => $token_fecha_creacion,
            'data' => [
                'token' => $token
            ]
        ];
    }

    public static function createAccount(array $usuario)
    {
        return Usuario::create($usuario);
    }

    public static function validateBearerToken($token)
    {
        try {
            $token_secret = env('TOKEN_SECRET');
            $token_algoritmo = env('TOKEN_ALGORITMO');

            $data = JWT::decode($token, new Key($token_secret, $token_algoritmo));

            $payload = [
                'success' => true,
                'user' => [
                    'usuario_id' => data_get($data, 'data.usuario_id'),
                    'username'   => data_get($data, 'data.username'),
                    'nombre_completo' => data_get($data, 'data.nombre_completo'),
                    'email'      => data_get($data, 'data.email'),
                    'estatus'    => data_get($data, 'data.estatus'),
                ],
            ];
            Log::info(["Autenticación:" => $payload]);
            return $payload;
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e);
        }
    }
}
