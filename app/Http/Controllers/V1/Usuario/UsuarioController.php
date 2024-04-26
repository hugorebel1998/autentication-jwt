<?php

namespace App\Http\Controllers\V1\Usuario;

use App\Factories\Usuario;
use App\Http\Controllers\Controller;
use App\Models\Usuario as ModelsUsuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function listar($usuario_id = null)
    {
        return Usuario::select($usuario_id);
    }

    public function crear(Request $request)
    {
        $usuario = $this->validate($request, [
            'nombre'   => 'required|min:2|max:60',
            'paterno'  => 'required|min:2|max:60',
            'materno'  => 'required|min:2|max:60',
            'username' => 'required|min:5|max:30|unique:usuarios,username',
            'email'    => 'required|unique:usuarios,email',
            'password' => 'required|confirmed',
            'estatus'  => 'required|' . Rule::in(ModelsUsuario::ESTATUS_ACTIVO, ModelsUsuario::ESTATUS_INACTIVO),
        ]);

        return Usuario::create($usuario);
    }

    public function actualizar(Request $request, $usuario_id)
    {
        $usuario = $this->validate($request, [
            'nombre'   => 'sometimes|min:2|max:60',
            'paterno'  => 'sometimes|min:2|max:60',
            'materno'  => 'sometimes|min:2|max:60',
            'username' => 'sometimes|min:5|max:30|unique:usuarios,username',
            'email'    => 'sometimes|unique:usuarios,email',
            'estatus'  => 'sometimes|' . Rule::in(ModelsUsuario::ESTATUS_ACTIVO, ModelsUsuario::ESTATUS_INACTIVO),
        ]);

        return Usuario::update($usuario_id, $usuario);
    }

    public function eliminar($usuario_id)
    {
        return Usuario::delete($usuario_id);
    }

    public function restablecer($usuario_id)
    {
        return Usuario::restore($usuario_id);
    }
}
