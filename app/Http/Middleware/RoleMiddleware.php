<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // 1. Primero, verificar si el usuario está logueado
        if (!Auth::check()) {
            return redirect('/');
        }

        // 2. Obtener TODOS los nombres de los roles del usuario
        //    (Esto usa la relación 'public function roles()' de tu modelo User)
        $userRoleNames = [Auth::user()->role->Name];


        // 3. Comprobar si *alguno* de los roles del usuario ($userRoleNames)
        //    existe en la lista de roles permitidos para la ruta ($roles)
        
        $isAuthorized = false;
        foreach ($userRoleNames as $roleName) {
            if (in_array($roleName, $roles)) {
                $isAuthorized = true;
                break; // Si encontramos una coincidencia, autorizamos y salimos del bucle
            }
        }

        // 4. Si después de revisar todos sus roles, ninguno coincide...
        if (!$isAuthorized) {
            return redirect('/'); // Redirigir a inicio
        }

        // 5. Si se encontró coincidencia, permitir el acceso
        return $next($request);
    }
}