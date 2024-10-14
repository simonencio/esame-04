<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class SerieTvCollection extends ResourceCollection
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
        $folderName = "ID" . $item["idSerieTv"];
        $versionFolder = "V1";
        $contenuti = Storage::files("serieTv/$folderName/$versionFolder");
        return [
            'idSerieTv' => $item["idSerieTv"],
            'idCategoria' => $item["idCategoria"],
            'nome' => $item["nome"],
            'descrizione' => $item["descrizione"],
            'totaleStagioni' => $item["totaleStagioni"],
            'NumeroEpisodio' => $item["NumeroEpisodio"],
            'regista' => $item["regista"],
            'attori' => $item["attori"],
            'annoInizio' => $item["annoInizio"],
            'annoFine' => $item["annoFine"],
            'contenuti' => $contenuti,
        ];
    }
}
