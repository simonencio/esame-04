<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class EpisodioCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        // return parent::toArray($request);
        $tmp = parent::toArray($request);
        $tmp = array_map(array($this, 'getCampi'), $tmp); // $this->getCampi non funziona
        return $tmp;
    }

    protected function getCampi($item)
    {
        $folderName = "ID" . $item["idEpisodio"];
        $versionFolder = "V1";
        $contenuti = Storage::files("episodi/$folderName/$versionFolder");
        return [
            'idEpisodio' => $item["idEpisodio"],
            'idSerieTv' => $item["idSerieTv"],
            'titolo' => $item["titolo"],
            'descrizione' => $item["descrizione"],
            'numeroStagione' => $item["numeroStagione"],
            'NumeroEpisodio' => $item["NumeroEpisodio"],
            'durata' => $item["durata"],
            'anno' => $item["anno"],
            'contenuti' => $contenuti,
        ];
    }
}
