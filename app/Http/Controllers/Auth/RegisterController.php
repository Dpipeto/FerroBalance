<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador maneja el registro de nuevos usuarios y su validación.
    |
    */

    use RegistersUsers;

    /**
     * Redirigir usuarios después del registro
     *
     * @var string
     */
    protected $redirectTo = '/inicio';

    /**
     * Crear un nuevo controlador
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validador para el registro
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Crear un nuevo usuario después de la validación
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Mostrar el formulario de registro
     */
    /**
     * Registrar un usuario manualmente (opcional si quieres control completo)
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Loguear automáticamente
        Auth::login($user);

        return redirect()->route('inicio');
    }
}
