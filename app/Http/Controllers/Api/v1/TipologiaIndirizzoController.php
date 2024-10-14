<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\TipologiaIndirizzoStoreRequest;
use App\Http\Requests\v1\TipologiaIndirizzoUpdateRequest;
use App\Http\Resources\v1\TipologiaIndirizzoCollection;
use App\Http\Resources\v1\TipologiaIndirizzoCompletoCollection;
use App\Http\Resources\v1\TipologiaIndirizzoCompletoResource;
use App\Http\Resources\v1\TipologiaIndirizzoResource;
use App\Models\TipologiaIndirizzo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TipologiaIndirizzoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResource
     */
    // public function index()
    // {
    //     $tipologiaIndirizzo = TipologiaIndirizzo::all();
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new TipologiaIndirizzoCompletoCollection($tipologiaIndirizzo);
    //     } else {
    //         $risorsa = new TipologiaIndirizzoCollection($tipologiaIndirizzo);
    //     }
    //     return $risorsa;
    // }

    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $tipologiaIndirizzo = TipologiaIndirizzo::all();
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new TipologiaIndirizzoCompletoCollection($tipologiaIndirizzo);
                } else {
                    $risorsa = new TipologiaIndirizzoCollection($tipologiaIndirizzo);
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
    // public function store(TipologiaIndirizzoStoreRequest $request)
    // {
    //     $dati = $request->validated();
    //     $tipologiaIndirizzo = TipologiaIndirizzo::create($dati);
    //     return new TipologiaIndirizzoResource($tipologiaIndirizzo);
    // }

    public function store(TipologiaIndirizzoStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $tipologiaIndirizzo = TipologiaIndirizzo::create($dati);
                return new TipologiaIndirizzoResource($tipologiaIndirizzo);
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
    // public function show(TipologiaIndirizzo $tipologiaIndirizzo)
    // {
    //     // return new TipologiaIndirizzoResource($tipologiaIndirizzo);


    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new TipologiaIndirizzoCompletoResource($tipologiaIndirizzo);
    //     } else {
    //         $risorsa =  new TipologiaIndirizzoResource($tipologiaIndirizzo);
    //     }
    //     return $risorsa;
    // }


    public function show(TipologiaIndirizzo $tipologiaIndirizzo)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new TipologiaIndirizzoCompletoResource($tipologiaIndirizzo);
                } else {
                    $risorsa = new TipologiaIndirizzoResource($tipologiaIndirizzo);
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
     * @param \App\Models\TipologiaIndirizzo $tipologiaIndirizzo
     * @param \Illuminate\Http\Requests\v1|TipologiaIndirizzoUpdateRequest $request
     * * @return JsonResource
     */
    // public function update(TipologiaIndirizzoUpdateRequest $request, TipologiaIndirizzo $tipologiaIndirizzo)
    // {
    //     // return "ciao";

    //     //prelevare i dati ->sono nella $request
    //     //verificare i dati
    //     $dati = $request->validated();
    //     //preparare il model
    //     $tipologiaIndirizzo->fill($dati);
    //     //salvare
    //     $tipologiaIndirizzo->save();
    //     //ritornare la risorsa modificata
    //     return new TipologiaIndirizzoResource($tipologiaIndirizzo);
    // }

    public function update(TipologiaIndirizzoUpdateRequest $request, TipologiaIndirizzo $tipologiaIndirizzo)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $tipologiaIndirizzo->fill($dati);
                $tipologiaIndirizzo->save();
                return new TipologiaIndirizzoResource($tipologiaIndirizzo);
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, "PE_0002");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\TipologiaIndirizzo $tipologiaIndirizzo
     */
    // public function destroy(TipologiaIndirizzo $tipologiaIndirizzo)
    // {
    //     $tipologiaIndirizzo->deleteOrFail();
    //     return response()->noContent();
    // }

    public function destroy(TipologiaIndirizzo $tipologiaIndirizzo)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $tipologiaIndirizzo->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
