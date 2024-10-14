<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerieTv extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "serieTv";
    protected $primaryKey = "idSerieTv";
    protected $fillable = [
        "idCategoria",
        "nome",
        "descrizione",
        "totaleStagioni",
        "NumeroEpisodio",
        "regista",
        "attori",
        "annoInizio",
        "annoFine",
        "idImmagine",
        "idFilmato"
    ];
}
