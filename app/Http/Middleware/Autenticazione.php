<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\v1\AccediController;
use App\Models\Contatto;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Autenticazione
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = null;
        if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION'] !== null) {
            //non funziona su Apache ma su artisan serve si
            $token = $_SERVER['HTTP_AUTHORIZATION'];
            $token = trim(str_replace("Bearer", "", $token));
        } elseif (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] !== null) {
            // Il codice sopra necessita di modifiche al server Apache
            // usare col server Apache
            $token = $_SERVER['PHP_AUTH_PW'];
        }





        $payload = AccediController::verificaToken($token);
        if ($payload != null) {
            $contatto = Contatto::where("idContatto", $payload->data->idContatto)->firstOrFail();
            if ($contatto->idStato == 1) {
                Auth::login($contatto);
                $request["contattiRuoli"] = $contatto->ruoli->pluck('nome')->toArray();
                return $next($request);
            } else {
                abort(403, "TK_0002");
            }
        } else {
            abort(403, "TK_0001");
        }
    }
}
