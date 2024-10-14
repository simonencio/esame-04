<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cittadinanza extends Model
{
    use HasFactory;
    protected $table = "cittadinanze";
    protected $primaryKey = "idCittadinanza";
    protected $fillable = [
        "idCittadinanza",
        "nome"

    ];
}
