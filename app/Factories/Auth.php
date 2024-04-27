<?php

namespace App\Factories;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Usuario as ModelUsuaurio;
use Carbon\Carbon;
use Exception;

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
        $token_secret = env('TOKEN_SECRET');

        $payload = [
            'sub' => $usuario_db['id'], //Subject usuario_id
            'exp' => time() + 3600,  //Expiración de token 1h
            'iat' => $token_fecha_creacion, // Hora en la que se crea el token formato UNIX
            'data' => [
                'username' => $usuario_db['username'],
                'email' => $usuario_db['email']
            ]
        ];

        $token = JWT::encode($payload, $token_secret, 'HS256');

        if (!$token)
            throw new Exception('No es posible iniciar sesión, comunicate con tu administrador', 500);

        return [
            'exp' => time() + 3600,
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
}
