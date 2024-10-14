<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class FilmCollection extends ResourceCollection
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
        $folderName = "ID" . $item["idFilm"];
        $versionFolder = "V1";
        $contenuti = Storage::files("film/$folderName/$versionFolder");

        return [
            'idFilm' => $item["idFilm"],
            'idCategoria' => $item["idCategoria"],
            'titolo' => $item["titolo"],
            'descrizione' => $item["descrizione"],
            'durata' => $item["durata"],
            'regista' => $item["regista"],
            'attori' => $item["attori"],
            'anno' => $item["anno"],
            'contenuti' => $contenuti,
        ];
    }
}
