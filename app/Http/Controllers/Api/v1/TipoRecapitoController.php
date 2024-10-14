<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\TipoRecapitoStoreRequest;
use App\Http\Requests\v1\TipoRecapitoUpdateRequest;
use App\Http\Resources\v1\TipoRecapitoCollection;
use App\Http\Resources\v1\TipoRecapitoCompletoCollection;
use App\Http\Resources\v1\TipoRecapitoCompletoResource;
use App\Http\Resources\v1\TipoRecapitoResource;
use App\Models\TipoRecapito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TipoRecapitoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResource
     */
    // public function index()
    // {
    //     $tipoRecapito = TipoRecapito::all();
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new TipoRecapitoCompletoCollection($tipoRecapito);
    //     } else {
    //         $risorsa = new TipoRecapitoCollection($tipoRecapito);
    //     }
    //     return $risorsa;
    // }

    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $tipoRecapito = TipoRecapito::all();
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new TipoRecapitoCompletoCollection($tipoRecapito);
                } else {
                    $risorsa = new TipoRecapitoCollection($tipoRecapito);
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
    // public function store(TipoRecapitoStoreRequest $request)
    // {
    //     $dati = $request->validated();
    //     $tipoRecapito = TipoRecapito::create($dati);
    //     return new TipoRecapitoResource($tipoRecapito);
    // }


    public function store(TipoRecapitoStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $tipoRecapito = TipoRecapito::create($dati);
                return new TipoRecapitoResource($tipoRecapito);
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
    // public function show(TipoRecapito $tipoRecapito)
    // {
    //     // return new TipologiaIndirizzoResource($tipoRecapito);


    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new TipoRecapitoCompletoResource($tipoRecapito);
    //     } else {
    //         $risorsa =  new TipoRecapitoResource($tipoRecapito);
    //     }
    //     return $risorsa;
    // }

    public function show(TipoRecapito $tipoRecapito)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new TipoRecapitoCompletoResource($tipoRecapito);
                } else {
                    $risorsa = new TipoRecapitoResource($tipoRecapito);
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
     * @param \App\Models\TipologiaIndirizzo $tipoRecapito
     * @param \Illuminate\Http\Requests\v1|TipologiaIndirizzoUpdateRequest $request
     * * @return JsonResource
     */
    // public function update(TipoRecapitoUpdateRequest $request, TipoRecapito $tipoRecapito)
    // {
    //     // return "ciao";

    //     //prelevare i dati ->sono nella $request
    //     //verificare i dati
    //     $dati = $request->validated();
    //     //preparare il model
    //     $tipoRecapito->fill($dati);
    //     //salvare
    //     $tipoRecapito->save();
    //     //ritornare la risorsa modificata
    //     return new TipoRecapitoResource($tipoRecapito);
    // }

    public function update(TipoRecapitoUpdateRequest $request, TipoRecapito $tipoRecapito)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $tipoRecapito->fill($dati);
                $tipoRecapito->save();
                return new TipoRecapitoResource($tipoRecapito);
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, "PE_0002");
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param \App\Models\TipologiaIndirizzo $tipoRecapito
     */
    // public function destroy(TipoRecapito $tipoRecapito)
    // {
    //     $tipoRecapito->deleteOrFail();
    //     return response()->noContent();
    // }
    public function destroy(TipoRecapito $tipoRecapito)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $tipoRecapito->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
