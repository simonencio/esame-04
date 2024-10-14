<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EpisodioResource extends JsonResource
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
        $folderName = "ID" . $this->idEpisodio;
        $versionFolder = "V1";
        $contenuti = Storage::files("episodi/$folderName/$versionFolder");
        return [
            'idEpisodio' => $this->idEpisodio,
            'idSerieTv' => $this->idSerieTv,
            'titolo' => $this->titolo,
            'descrizione' => $this->descrizione,
            'numeroStagione' => $this->numeroStagione,
            'NumeroEpisodio' => $this->NumeroEpisodio,
            'durata' => $this->durata,
            'anno' => $this->anno,
            'contenuti' => $contenuti,
        ];
    }
}
