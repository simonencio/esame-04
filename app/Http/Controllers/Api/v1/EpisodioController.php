<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\EpisodioStoreRequest;
use App\Http\Requests\v1\EpisodioUpdateRequest;
use App\Http\Resources\v1\EpisodioCollection;
use App\Http\Resources\v1\EpisodioCompletoCollection;
use App\Http\Resources\v1\EpisodioCompletoResource;
use App\Http\Resources\v1\EpisodioResource;
use App\Models\Episodio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EpisodioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     if (Gate::allows('leggere')) {
    //         if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
    //             $episodio = Episodio::all();
    //             $risorsa = null;
    //             if (request("tipo") != null && request("tipo") == "completo") {
    //                 $risorsa = new EpisodioCompletoCollection($episodio);
    //             } else {
    //                 $risorsa = new EpisodioCollection($episodio);
    //             }
    //             return $risorsa;
    //         } else {
    //             abort(403, 'PE_0001');
    //         }
    //     } else {
    //         abort(403, 'PE_0002');
    //     }
    // }

    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $episodio = Episodio::all();
                $risorsa = null;

                foreach ($episodio as $ep) {
                    $folderName = "ID" . $ep->idEpisodio;
                    $versionFolder = "V1";
                    $contenuti = Storage::files("episodi/$folderName/$versionFolder");
                    $ep->contenuti = $contenuti;
                }

                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new EpisodioCompletoCollection($episodio);
                } else {
                    $risorsa = new EpisodioCollection($episodio);
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
    public function store(EpisodioStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $episodio = Episodio::create($dati);
                return new EpisodioResource($episodio);
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
    // public function show(Episodio $episodio)
    // {
    //     if (Gate::allows('leggere')) {
    //         if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
    //             $risorsa = null;
    //             if (request("tipo") != null && request("tipo") == "completo") {
    //                 $risorsa = new EpisodioCompletoResource($episodio);
    //             } else {
    //                 $risorsa = new EpisodioResource($episodio);
    //             }
    //             return $risorsa;
    //         } else {
    //             abort(403, 'PE_0001');
    //         }
    //     } else {
    //         abort(403, 'PE_0002');
    //     }
    // }

    public function show(Episodio $episodio)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                $folderName = "ID" . $episodio->idEpisodio;
                $versionFolder = "V1";
                $contenuti = Storage::files("episodi/$folderName/$versionFolder");
                $episodio->contenuti = $contenuti;

                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new EpisodioCompletoResource($episodio);
                } else {
                    $risorsa = new EpisodioResource($episodio);
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
    public function update(EpisodioUpdateRequest $request, Episodio $episodio)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $episodio->fill($dati);
                $episodio->save();
                return new EpisodioResource($episodio);
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
    public function destroy(Episodio $episodio)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $episodio->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
