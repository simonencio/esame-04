<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comune extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "comuni";
    protected $primaryKey = "idComune";
    protected $fillable = [
        "idComune",
        "comune",
        "regione",
        "provincia",
        "siglaAutomobilistica",
        "Cod_Catastale",
        "CAP"
    ];
}
