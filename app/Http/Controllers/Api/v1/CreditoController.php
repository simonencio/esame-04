<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreditoStoreRequest;
use App\Http\Requests\v1\CreditoUpdateRequest;
use App\Http\Resources\v1\CreditoCollection;
use App\Http\Resources\v1\CreditoCompletoCollection;
use App\Http\Resources\v1\CreditoCompletoResource;
use App\Http\Resources\v1\CreditoResource;
use App\Models\Categoria;
use App\Models\Credito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    // public function index()
    // {
    //     $credito = Credito::all();
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new CreditoCompletoCollection($credito);
    //     } else {
    //         $risorsa = new CreditoCollection($credito);
    //     }
    //     return $risorsa;
    // }

    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $credito = Credito::all();
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new CreditoCompletoCollection($credito);
                } else {
                    $risorsa = new CreditoCollection($credito);
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
     * @param \Illuminate\Http\Requests\v1\CategoriaStoreRequest $request
     * @return JsonResource
     */
    // public function store(CreditoStoreRequest $request)
    // {
    //     $dati = $request->validated();
    //     $credito = Credito::create($dati);
    //     return new CreditoResource($credito);
    // }

    public function store(CreditoStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $credito = Credito::create($dati);
                return new CreditoResource($credito);
            } else {
                abort(403, "PE_0001");
            }
        } else {
            abort(403, "PE_0002");
        }
    }

    /**
     * Display the specified resource.
     * @param \App\Models\Categoria $categoria
     * @return JsonResource
     */
    // public function show(Credito $credito)
    // {
    //     // return new TipologiaIndirizzoResource($tipologiaIndirizzo);


    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new CreditoCompletoResource($credito);
    //     } else {
    //         $risorsa =  new CreditoResource($credito);
    //     }
    //     return $risorsa;
    // }

    public function show(Credito $credito)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new CreditoCompletoResource($credito);
                } else {
                    $risorsa = new CreditoResource($credito);
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
    // public function update(CreditoUpdateRequest $request, Credito $credito)
    // {
    //     // $dati = $request->validated();
    //     // $indirizzo->fill($dati);
    //     // $indirizzo->save();
    //     // return new IndirizzoResource($indirizzo);



    //     // return "ciao";

    //     //prelevare i dati ->sono nella $request
    //     //verificare i dati
    //     $dati = $request->validated();
    //     //preparare il model
    //     $credito->fill($dati);
    //     //salvare
    //     $credito->save();
    //     //ritornare la risorsa modificata
    //     return new CreditoResource($credito);
    // }

    public function update(CreditoUpdateRequest $request, Credito $credito)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $credito->fill($dati);
                $credito->save();
                return new CreditoResource($credito);
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
    // public function destroy(Credito $credito)
    // {
    //     $credito->deleteOrFail();
    //     return response()->noContent();
    // }
    public function destroy(Credito $credito)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $credito->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
