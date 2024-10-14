<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipologiaIndirizzo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "tipologiaIndirizzi";
    protected $primaryKey = "idTipologiaIndirizzo";
    protected $fillable = [
        "nome"
    ];
    public function elencoIndirizzi()
    {
        return $this->hasMany(Indirizzo::class, 'idTipologiaIndirizzo', 'idTipologiaIndirizzo');
    }
}
