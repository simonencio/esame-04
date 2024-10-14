<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\NazioneCollection;
use App\Http\Resources\v1\NazioneCompletoCollection;
use App\Http\Resources\v1\NazioneCompletoResource;
use App\Http\Resources\v1\NazioneResource;
use App\Models\Nazione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NazioneController extends Controller
{
    /**
     * Display a listing of the resource.
     * * @return JsonResource
     */
    // public function index()
    // {
    //     // // $nazioni = Nazione::all();
    //     // if (Gate::allows("leggere")) {
    //     //    
    //     // } else {
    //     //     abort(403);
    //     // }

    //     $nazioni = Nazione::all();
    //     $risorsa = null;
    //     $continente = (request("continente") != null) ?  request("continente") : null; // controllo per sigle continente
    //     if ($continente != null) {
    //         $nazioni = Nazione::all()->where('continente', $continente);
    //     } else {
    //         $nazioni = Nazione::all();
    //     }
    //     return $this->creaCollection($nazioni);
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new NazioneCompletoCollection($nazioni);
    //     } else {
    //         $risorsa = new NazioneCollection($nazioni);
    //     }
    //     return $risorsa;
    // }



    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $nazioni = Nazione::all();
                $continente = (request("continente") != null) ?  request("continente") : null; // controllo per sigle continente
                if ($continente != null) {
                    $nazioni = Nazione::all()->where('continente', $continente);
                } else {
                    $nazioni = Nazione::all();
                }
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new NazioneCompletoCollection($nazioni);
                } else {
                    $risorsa = new NazioneCollection($nazioni);
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
    public function indexContinente($continente)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $nazioni = Nazione::all()->where('continente', $continente);
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new NazioneCompletoCollection($nazioni);
                } else {
                    $risorsa = new NazioneCollection($nazioni);
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
    // public function show(Nazione $nazione)
    // {
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new NazioneCompletoResource($nazione);
    //     } else {
    //         $risorsa =  new NazioneResource($nazione);
    //     }
    //     return $risorsa;
    // }

    public function show(Nazione $nazione)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new NazioneCompletoResource($nazione);
                } else {
                    $risorsa = new NazioneResource($nazione);
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
    public function update(Request $request, Nazione $nazione)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Nazione $nazione)
    // {
    //     $nazione->deleteOrFail();
    //     return response()->noContent();
    // }
    public function destroy(Nazione $nazione)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $nazione->deleteOrFail();
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

    protected function creaCollection($nazioni)
    {
        $risorsa = null;
        $tipo = request('tipo');
        if ($tipo == "completo") {
            $risorsa = new NazioneCompletoCollection($nazioni);
        } else {
            $risorsa = new NazioneCollection($nazioni);
        }
        return $risorsa;
    }
}
