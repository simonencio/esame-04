<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\SerieTvStoreRequest;
use App\Http\Requests\v1\SerieTvUpdateRequest;
use App\Http\Resources\v1\SerieTvCollection;
use App\Http\Resources\v1\SerieTvCompletoCollection;
use App\Http\Resources\v1\SerieTvCompletoResource;
use App\Http\Resources\v1\SerieTvResource;
use App\Models\SerieTv;
use App\Models\serieTv_Contatti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SerieTvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     if (Gate::allows('leggere')) {
    //         if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
    //             $serieTv = SerieTv::all();
    //             $risorsa = null;
    //             if (request("tipo") != null && request("tipo") == "completo") {
    //                 $risorsa = new SerieTvCompletoCollection($serieTv);
    //             } else {
    //                 $risorsa = new SerieTvCollection($serieTv);
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
                $serieTv = SerieTv::all();
                $risorsa = null;

                foreach ($serieTv as $serie) {
                    $folderName = "ID" . $serie->idSerieTv;
                    $versionFolder = "V1";
                    $contenuti = Storage::files("serieTv/$folderName/$versionFolder");
                    $serie->contenuti = $contenuti;
                }

                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new SerieTvCompletoCollection($serieTv);
                } else {
                    $risorsa = new SerieTvCollection($serieTv);
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
    public function store(SerieTvStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $serieTv = SerieTv::create($dati);
                return new SerieTvResource($serieTv);
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
    // public function show(SerieTv $serieTv)
    // {
    //     if (Gate::allows('leggere')) {
    //         if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
    //             $risorsa = null;
    //             if (request("tipo") != null && request("tipo") == "completo") {
    //                 $risorsa = new SerieTvCompletoResource($serieTv);
    //             } else {
    //                 $risorsa = new SerieTvResource($serieTv);
    //             }
    //             return $risorsa;
    //         } else {
    //             abort(403, 'PE_0001');
    //         }
    //     } else {
    //         abort(403, 'PE_0002');
    //     }
    // }
    public function show(SerieTv $serieTv)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                $folderName = "ID" . $serieTv->idSerieTv;
                $versionFolder = "V1";
                $contenuti = Storage::files("serieTv/$folderName/$versionFolder");
                $serieTv->contenuti = $contenuti;

                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new SerieTvCompletoResource($serieTv);
                } else {
                    $risorsa = new SerieTvResource($serieTv);
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
    public function update(SerieTvUpdateRequest $request, SerieTv $serieTv)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $serieTv->fill($dati);
                $serieTv->save();
                return new SerieTvResource($serieTv);
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
    public function destroy(SerieTv $serieTv)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $serieTv->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
