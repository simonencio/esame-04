<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contattiRuoli_contattiAbilita extends Model
{
    use HasFactory;
    protected $table = "contattiRuoli_contattiAbilita";
    protected $fillable = ["id", "idContattoRuolo", "idContattoAbilita"];
}
