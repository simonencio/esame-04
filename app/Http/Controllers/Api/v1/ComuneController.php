<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ComuneCollection;
use App\Http\Resources\v1\ComuneCompletoCollection;
use App\Http\Resources\v1\ComuneCompletoResource;
use App\Http\Resources\v1\ComuneResource;
use App\Models\Comune;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ComuneController extends Controller
{
    // // $nazioni = Nazione::all();
    // if (Gate::allows("leggere")) {
    //    
    // } else {
    //     abort(403);
    // }
    // return $this->creaCollection($comune);
    // if (request("tipo") != null && request("tipo") == "completo") {
    //     $risorsa = new ComuneCompletoCollection($comune);
    // } else {
    //     $risorsa = new ComuneCollection($comune);
    // }
    // return $risorsa;
    // $provincia = (request("provincia") != null) ?  request("provincia") : null; // controllo per sigle continente
    // if ($provincia != null) {
    //     $comune = Comune::all()->where('provincia', $provincia);
    // } else {
    //     $comune = Comune::all();
    // }
    /**
     * Display a listing of the resource.
     * * @return JsonResource
     */
    // public function index()
    // {

    //     $comune = Comune::all();
    //     $risorsa = null;
    //     $regione = (request("regione") != null) ?  request("regione") : null;
    //     $provincia = (request("provincia") != null) ?  request("provincia") : null; // controllo per sigle continente
    //     if ($regione != null) {
    //         $comune = Comune::all()->where('regione', $regione);
    //     } else if ($provincia != null) {
    //         $comune = Comune::all()->where('provincia', $provincia);
    //     } else {
    //         $comune = Comune::all();
    //     }
    //     return $this->creaCollection($comune);
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new ComuneCompletoCollection($comune);
    //     } else {
    //         $risorsa = new ComuneCollection($comune);
    //     }
    //     return $risorsa;
    // }


    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $comune = Comune::all();
                $risorsa = null;
                $regione = (request("regione") != null) ?  request("regione") : null;
                $provincia = (request("provincia") != null) ?  request("provincia") : null; // controllo per sigle continente
                if ($regione != null) {
                    $comune = Comune::all()->where('regione', $regione);
                } else if ($provincia != null) {
                    $comune = Comune::all()->where('provincia', $provincia);
                } else {
                    $comune = Comune::all();
                }
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new ComuneCompletoCollection($comune);
                } else {
                    $risorsa = new ComuneCollection($comune);
                }
                return $risorsa;
            } else {
                abort(403, 'PE_0000');
            }
        } else {
            abort(403, 'PE_0001');
        }
    }
    /**
     * Display a listing of the resource from continente.
     * @param string $idContinente
     * @return JsonResource
     */
    // public function indexRegione($regione)
    // {
    //     $comune = Comune::all()->where('regione', $regione);
    //     return $this->creaCollection($comune);
    // }

    public function indexRegione($regione)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $comune = Comune::all()->where('regione', $regione);
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new ComuneCompletoCollection($comune);
                } else {
                    $risorsa = new ComuneCollection($comune);
                }
                return $risorsa;
            } else {
                abort(403, 'PE_0000');
            }
        } else {
            abort(403, 'PE_0001');
        }
    }

    /**
     * Display a listing of the resource from continente.
     * @param string $idContinente
     * @return JsonResource
     */
    // public function indexProvincia($provincia)
    // {
    //     $comune = Comune::all()->where('provincia', $provincia);
    //     return $this->creaCollection($comune);
    // }


    public function indexProvincia($provincia)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $comune = Comune::all()->where('provincia', $provincia);
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new ComuneCompletoCollection($comune);
                } else {
                    $risorsa = new ComuneCollection($comune);
                }
                return $risorsa;
            } else {
                abort(403, 'PE_0000');
            }
        } else {
            abort(403, 'PE_0001');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request) {}

    /**
     * Display the specified resource.
     * @return JsonResource
     */
    // public function show(Comune $comune)
    // {
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new ComuneCompletoResource($comune);
    //     } else {
    //         $risorsa =  new ComuneResource($comune);
    //     }
    //     return $risorsa;
    // }

    public function show(Comune $comune)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new ComuneCompletoResource($comune);
                } else {
                    $risorsa = new ComuneResource($comune);
                }
                return $risorsa;
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comune $nazione)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Comune $comune)
    // {
    //     $comune->deleteOrFail();
    //     return response()->noContent();
    // }

    public function destroy(Comune $comune)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $comune->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }

    //---------------------------------------------------------------
    // PROTECTED-----------------------------------------------------

    protected function creaCollection($comune)
    {
        $risorsa = null;
        $tipo = request('tipo');
        if ($tipo == "completo") {
            $risorsa = new ComuneCompletoCollection($comune);
        } else {
            $risorsa = new ComuneCollection($comune);
        }
        return $risorsa;
    }
}
