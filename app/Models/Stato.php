<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stato extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "stati";
    protected $primaryKey = "idStato";
    protected $fillable = [
        "nome"
    ];
}
