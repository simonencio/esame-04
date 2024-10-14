<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serieTv_Contatti extends Model
{
    use HasFactory;
    protected $table = "serietv__contatti";
    protected $primaryKey = "idSerieContatto";
    protected $fillable = [
        "idSerieTv",
        "idContatto"
    ];
}
