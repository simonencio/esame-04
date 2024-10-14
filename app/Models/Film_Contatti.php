<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film_Contatti extends Model
{
    use HasFactory;
    protected $table = "film_Contatti";
    protected $primaryKey = "idFilmContatto";
    protected $fillable = [
        "idFilm",
        "idContatto"
    ];
}
