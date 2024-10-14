<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contatto_contattoRuolo extends Model
{
    use HasFactory;
    protected $table = "contatti_contattiRuoli";
    protected $fillable = ["id", "idContatto", "idContattoRuolo"];
}
