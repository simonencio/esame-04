<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ProfiloStoreRequest;
use App\Http\Requests\v1\ProfiloUpdateRequest;
use App\Http\Resources\v1\ProfiloCollection;
use App\Http\Resources\v1\ProfiloCompletoCollection;
use App\Http\Resources\v1\ProfiloCompletoResource;
use App\Http\Resources\v1\ProfiloResource;
use App\Models\Profilo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProfiloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    // public function index()
    // {
    //     $profilo = Profilo::all();
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new ProfiloCompletoCollection($profilo);
    //     } else {
    //         $risorsa = new ProfiloCollection($profilo);
    //     }
    //     return $risorsa;
    // }
    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $profilo = Profilo::all();
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new ProfiloCompletoCollection($profilo);
                } else {
                    $risorsa = new ProfiloCollection($profilo);
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
    // public function store(ProfiloStoreRequest $request)
    // {
    //     $dati = $request->validated();
    //     $profilo = Profilo::create($dati);
    //     return new ProfiloResource($profilo);
    // }
    public function store(ProfiloStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $profilo = Profilo::create($dati);
                return new ProfiloResource($profilo);
            } else {
                abort(403, "PE_0001");
            }
        } else {
            abort(403, "PE_0002");
        }
    }

    /**
     * Display the specified resource.
     * @param \App\Models\Categoria $profilo
     * @return JsonResource
     */
    // public function show(Profilo $profilo)
    // {
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new ProfiloCompletoResource($profilo);
    //     } else {
    //         $risorsa =  new ProfiloResource($profilo);
    //     }
    //     return $risorsa;
    // }
    public function show(Profilo $profilo)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new ProfiloCompletoResource($profilo);
                } else {
                    $risorsa = new ProfiloResource($profilo);
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
    // public function update(ProfiloUpdateRequest $request, Profilo $profilo)
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
    //     $profilo->fill($dati);
    //     //salvare
    //     $profilo->save();
    //     //ritornare la risorsa modificata
    //     return new ProfiloResource($profilo);
    // }
    public function update(ProfiloUpdateRequest $request, Profilo $profilo)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $profilo->fill($dati);
                $profilo->save();
                return new ProfiloResource($profilo);
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
    // public function destroy(Profilo $profilo)
    // {
    //     $profilo->deleteOrFail();
    //     return response()->noContent();
    // }
    public function destroy(Profilo $profilo)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $profilo->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
