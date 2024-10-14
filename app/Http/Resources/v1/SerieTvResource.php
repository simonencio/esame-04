<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SerieTvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // return parent::toArray($request);
        return $this->getCampi();
    }


    //---PROTECTED--------------------------------------- 
    //---------------------------------------------------
    protected function getCampi()
    {
        $folderName = "ID" . $this->idSerieTv;
        $versionFolder = "V1";
        $contenuti = Storage::files("serieTv/$folderName/$versionFolder");
        return [
            'idSerieTv' => $this->idSerieTv,
            'idCategoria' => $this->idCategoria,
            'nome' => $this->nome,
            'descrizione' => $this->descrizione,
            'totaleStagioni' => $this->totaleStagioni,
            'NumeroEpisodio' => $this->NumeroEpisodio,
            'regista' => $this->regista,
            'attori' => $this->attori,
            'annoInizio' => $this->annoInizio,
            'annoFine' => $this->annoFine,
            'contenuti' => $contenuti,
        ];
    }
}
