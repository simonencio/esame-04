<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Film_ContattiStoreRequest;
use App\Http\Requests\v1\Film_ContattiUpdateRequest;
use App\Http\Resources\v1\Film_ContattiCollection;
use App\Http\Resources\v1\Film_ContattiCompletoCollection;
use App\Http\Resources\v1\Film_ContattiCompletoResource;
use App\Http\Resources\v1\Film_ContattiResource;
use App\Models\Film_Contatti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Film_ContattiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $filmContatto = Film_Contatti::all();
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new Film_ContattiCompletoCollection($filmContatto);
                } else {
                    $risorsa = new Film_ContattiCollection($filmContatto);
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
     *  * @param \Illuminate\Http\Requests\v1\IndirizzoStoreRequest $request
     * @return JsonResponse
     */
    public function store(Film_ContattiStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $filmContatto = Film_Contatti::create($dati);
                return new Film_ContattiResource($filmContatto);
            } else {
                abort(403, "PE_0001");
            }
        } else {
            abort(403, "PE_0002");
        }
    }

    /**
     * Display the specified resource.
     * @param \App\Models\Indirizzo
     * @return JsonResource
     */
    public function show(Film_Contatti $filmContatto)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new Film_ContattiCompletoResource($filmContatto);
                } else {
                    $risorsa = new Film_ContattiResource($filmContatto);
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
     * * @param \Illuminate\Http\Requests\v1\IndirizzoUpdateRequest $request
     * @param Indirizzo $indirizzo
     *  @return JsonResource
     */
    public function update(Film_ContattiUpdateRequest $request, Film_Contatti $filmContatto)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $filmContatto->fill($dati);
                $filmContatto->save();
                return new Film_ContattiResource($filmContatto);
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, "PE_0002");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\Indirizzo $tipologiaIndirizzo
     */
    public function destroy(Film_Contatti $filmContatto)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $filmContatto->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
