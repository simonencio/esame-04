<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profilo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "profili";
    protected $primaryKey = "idProfilo";
    protected $fillable = [
        "idContatto",
        "nome"
    ];
}
