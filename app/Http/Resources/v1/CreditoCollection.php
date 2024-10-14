<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CreditoCollection extends ResourceCollection
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
        return [
            'idCredito' => $item["idCredito"],
            'idContatto' => $item["idContatto"],
            'credito' => $item["credito"]
        ];
    }
}
