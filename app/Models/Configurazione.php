<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configurazione extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "idConfigurazione";
    protected $table = "configurazioni";

    protected $fillable = [
        "idConfigurazione",
        "chiave",
        "valore"
    ];

    public static function leggiValore($chiave)
    {
        // Assuming you have a Configurazione model or class
        $config = Configurazione::where('chiave', $chiave)->first();
        if ($config) {
            return $config->valore;
        } else {
            // Return a default value or throw an exception if the key is not found
            return null; // or throw new Exception("Config key '$key' not found");
        }
    }
}
