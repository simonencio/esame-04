<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CittadinanzaCollection;
use App\Http\Resources\v1\CittadinanzaCompletoCollection;
use App\Http\Resources\v1\CittadinanzaCompletoResource;
use App\Http\Resources\v1\CittadinanzaResource;
use App\Models\Cittadinanza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CittadinanzaController extends Controller
{
    // // $nazioni = Nazione::all();
    // if (Gate::allows("leggere")) {
    //    
    // } else {
    //     abort(403);
    // }
    /**
     * Display a listing of the resource.
     * * @return JsonResource
     */
    // public function index()
    // {
    //     $cittadinanza = Cittadinanza::all();
    //     $risorsa = null;
    //     $nome = (request("nome") != null) ?  request("nome") : null; // controllo per sigle continente
    //     if ($nome != null) {
    //         $cittadinanza = Cittadinanza::all()->where('nome', $nome);
    //     } else {
    //         $cittadinanza = Cittadinanza::all();
    //     }
    //     return $this->creaCollection($cittadinanza);
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new CittadinanzaCompletoCollection($cittadinanza);
    //     } else {
    //         $risorsa = new CittadinanzaCollection($cittadinanza);
    //     }
    //     return $risorsa;
    // }


    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $cittadinanza = Cittadinanza::all();
                $risorsa = null;
                $nome = (request("nome") != null) ?  request("nome") : null;
                if ($nome != null) {
                    $cittadinanza = Cittadinanza::all()->where('nome', $nome);
                } else {
                    $cittadinanza = Cittadinanza::all();
                }
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new CittadinanzaCompletoCollection($cittadinanza);
                } else {
                    $risorsa = new CittadinanzaCollection($cittadinanza);
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
    // public function indexCittadinanza($nome)
    // {
    //     $cittadinanza = Cittadinanza::all()->where('nome', $nome);
    //     return $this->creaCollection($cittadinanza);
    // }

    public function indexCittadinanza($nome)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $cittadinanza = Cittadinanza::all()->where('nome', $nome);
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new CittadinanzaCompletoCollection($cittadinanza);
                } else {
                    $risorsa = new CittadinanzaCollection($cittadinanza);
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
    // public function show(Cittadinanza $cittadinanza)
    // {
    //     $risorsa = null;
    //     if (request("tipo") != null && request("tipo") == "completo") {
    //         $risorsa = new CittadinanzaCompletoResource($cittadinanza);
    //     } else {
    //         $risorsa =  new CittadinanzaResource($cittadinanza);
    //     }
    //     return $risorsa;
    // }
    public function show(Cittadinanza $cittadinanza)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new CittadinanzaCompletoResource($cittadinanza);
                } else {
                    $risorsa = new CittadinanzaResource($cittadinanza);
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
    public function update(Request $request, Cittadinanza $cittadinanza)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Cittadinanza $cittadinanza)
    // {
    //     $cittadinanza->deleteOrFail();
    //     return response()->noContent();
    // }

    public function destroy(Cittadinanza $cittadinanza)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore')) {
                $cittadinanza->deleteOrFail();
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

    protected function creaCollection($cittadinanza)
    {
        $risorsa = null;
        $tipo = request('tipo');
        if ($tipo == "completo") {
            $risorsa = new CittadinanzaCompletoCollection($cittadinanza);
        } else {
            $risorsa = new CittadinanzaCollection($cittadinanza);
        }
        return $risorsa;
    }
}
