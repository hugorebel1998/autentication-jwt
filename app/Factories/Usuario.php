<?php

namespace App\Factories;

use App\Models\Usuario as ModelUsuaurio;


class Usuario
{
    public static function select(string|null $usuario_id)
    {
        if (empty($usuario_id))
            return ModelUsuaurio::all();

        return ModelUsuaurio::findOrFail($usuario_id);
    }

    public static function create(array $usuario)
    {
        return ModelUsuaurio::create($usuario);
    }

    public static function update(string $usuario_id, array $usuario)
    {
        $usuario_db = ModelUsuaurio::findOrFail($usuario_id);

        $usuario_db->fill($usuario);

        $usuario_db->save();

        return $usuario_db;
    }

    public static function delete(string $usuario_id)
    {
        $usuario_db = ModelUsuaurio::findOrFail($usuario_id);

        $usuario_db->delete();

        return $usuario_db;
    }

    public static function restore(string $usuario_id)
    {
        ModelUsuaurio::onlyTrashed()->findOrFail($usuario_id)->restore();

        return response()->json(['success' => true, 'message' => 'Usuario restablecido'], 200);
    }
}
