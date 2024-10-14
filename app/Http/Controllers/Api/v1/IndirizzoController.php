<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\IndirizzoCollection;
use App\Http\Resources\v1\IndirizzoResource;
use App\Http\Requests\v1\IndirizzoStoreRequest;
use App\Http\Requests\v1\IndirizzoUpdateRequest;
use App\Http\Resources\v1\IndirizzoCompletoCollection;
use App\Http\Resources\v1\IndirizzoCompletoResource;
use Illuminate\Http\Request;
use App\Models\Indirizzo;
use Exception;;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class IndirizzoController extends Controller
{




    /**
     * Display a listing of the resource.
     * @return JsonResource
     */
    // public function index()
    // {
    // $indirizzo = Indirizzo::all();
    // if (request("idContatto") != null) {
    //     $indirizzo = $indirizzo->where("idContatto", request("idContatto"));
    // }
    // if (request("idTipo") != null) {
    //     $indirizzo = $indirizzo->where("idTipologiaIndirizzo", request("idTipo"));
    // }

    // return new IndirizzoCollection($indirizzo);

    // $indirizzo = null;
    // if (Gate::allows('leggere')) {
    //     if (Gate::allows('Amministratore')) {
    //         $nazione = Indirizzo::all();
    //     }
    //     return new IndirizzoCollection($indirizzo);
    // } else {
    //     abort(403, 'PE_0001');
    // }


    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $indirizzo = Indirizzo::all();
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new IndirizzoCompletoCollection($indirizzo);
                } else {
                    $risorsa = new IndirizzoCollection($indirizzo);
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
    public function store(IndirizzoStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore')) {
                $dati = $request->validated();
                $indirizzo = Indirizzo::create($dati);
                return new IndirizzoResource($indirizzo);
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
    public function show(Indirizzo $indirizzo)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new IndirizzoCompletoResource($indirizzo);
                } else {
                    $risorsa = new IndirizzoResource($indirizzo);
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
    public function update(IndirizzoUpdateRequest $request, Indirizzo $indirizzo)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore')) {
                // user is an Amministratore, allow update without restrictions
                $dati = $request->validated();
                $indirizzo->fill($dati);
                $indirizzo->save();
                return new IndirizzoResource($indirizzo);
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
    public function destroy(Indirizzo $indirizzo)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $indirizzo->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}

























 // // query builder
    // public static function altro()
    // {
    //     DB::transaction(function () {
    //         // CODICI SQL
    //         DB::table("indirizzi")->where("idIndirizzo", 9)->increment("cap", 1);
    //     }, 5);
    // }
    // try {

    //     DB::beginTransaction();
    //     //codice SQL da eseguire
    //     DB::commit();
    // } catch (Exception $e) {
    //     DB::rollBack();
    // }
    // ->where("idIndirizzo", 13)
    // ->delete();  //truncate svuota tabella e setta id a 0
    // ->upsert(
    //     [
    //         "idIndirizzo" => 10,
    //         "idContatto" => 2,
    //         "idTipologiaIndirizzo" => 3,
    //         "idNazione" => 1,
    //         "cap" => 10044,
    //         "comune" => "Parma",
    //         "indirizzo" => "Corso Traiano",
    //         "civico" => "1",
    //         "localita" => null
    //     ],
    //     ["indirizzo", "idContatto", "idTipologiaIndirizzo", "cap"],
    //     ["indirizzo"]
    // );
    // ->whereColumn([   accetta array di array
    //     ["created_at", "<", "updated_at"],
    //     ["created_at", "<", "updated_at"]
    // ])
    // ->where(function ($query) {   // per creare query con più where
    //     $query
    //         ->where("continente", "EU")
    //         ->where("iso3", "LIKE", "E%");
    // })
    // ->orWhere(function ($query) {
    //     $query
    //         ->where("continente", "AS")
    //         ->where("iso3", "LIKE", "A%");
    // })

    // SELECT * FROM nazioni WHERE (continente='EU' AND iso3 LIKE 'E%') OR (continente='AS' AND iso3 LIKE "A%")

    // ->where([                  stessa cosa che sopra
    //     ["continente", "EU"],
    //     ["iso3", "LIKE", "I%"]
    // ])
