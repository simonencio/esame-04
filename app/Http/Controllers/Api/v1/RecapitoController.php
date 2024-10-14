<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\RecapitoStoreRequest;
use App\Http\Requests\v1\RecapitoUpdateRequest;
use App\Http\Resources\v1\RecapitoCollection;
use App\Http\Resources\v1\RecapitoCompletoCollection;
use App\Http\Resources\v1\RecapitoCompletoResource;
use App\Http\Resources\v1\RecapitoResource;
use App\Models\Recapito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RecapitoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResource
     */
    // public function index()
    // {
    //     $recapito = Recapito::all();
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new RecapitoCompletoCollection($recapito);
    //     } else {
    //         $risorsa = new RecapitoCollection($recapito);
    //     }
    //     return $risorsa;
    // }

    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $recapito = Recapito::all();
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new RecapitoCompletoCollection($recapito);
                } else {
                    $risorsa = new RecapitoCollection($recapito);
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
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Requests\v1|TipologiaIndirizzoStoreRequest $request
     * @return JsonResource
     */
    // public function store(RecapitoStoreRequest $request)
    // {
    //     $dati = $request->validated();
    //     $recapito = Recapito::create($dati);
    //     return new RecapitoResource($recapito);
    // }

    public function store(RecapitoStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $recapito = Recapito::create($dati);
                return new RecapitoResource($recapito);
            } else {
                abort(403, "PE_0001");
            }
        } else {
            abort(403, "PE_0002");
        }
    }

    /**
     * Display the specified resource.
     * @param \App\Models\TipologiaIndirizzo $tipologiaIndirizzo
     * @return JsonResource
     */
    // public function show(Recapito $recapito)
    // {
    //     // return new TipologiaIndirizzoResource($recapito);


    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new RecapitoCompletoResource($recapito);
    //     } else {
    //         $risorsa =  new RecapitoResource($recapito);
    //     }
    //     return $risorsa;
    // }

    public function show(Recapito $recapito)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new RecapitoCompletoResource($recapito);
                } else {
                    $risorsa = new RecapitoResource($recapito);
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
     * @param \App\Models\TipologiaIndirizzo $recapito
     * @param \Illuminate\Http\Requests\v1|TipologiaIndirizzoUpdateRequest $request
     * * @return JsonResource
     */
    // public function update(RecapitoUpdateRequest $request, Recapito $recapito)
    // {
    //     // return "ciao";

    //     //prelevare i dati ->sono nella $request
    //     //verificare i dati
    //     $dati = $request->validated();
    //     //preparare il model
    //     $recapito->fill($dati);
    //     //salvare
    //     $recapito->save();
    //     //ritornare la risorsa modificata
    //     return new RecapitoResource($recapito);
    // }

    public function update(RecapitoUpdateRequest $request, Recapito $recapito)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $recapito->fill($dati);
                $recapito->save();
                return new RecapitoResource($recapito);
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, "PE_0002");
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param \App\Models\TipologiaIndirizzo $recapito
     */
    // public function destroy(Recapito $recapito)
    // {
    //     $recapito->deleteOrFail();
    //     return response()->noContent();
    // }
    public function destroy(Recapito $recapito)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $recapito->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
