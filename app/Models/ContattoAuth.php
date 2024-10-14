<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ContattoAuth extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "contattiAuth";
    protected $primaryKey = "idContattoAuth";
    protected $fillable = [
        'idContatto',
        'user',
        'sfida',
        'secretJWT',
        'inizioSfida',
        'obbligoCampo'
    ];

    //---PUBLIC-----------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------
    /**
     * controlla se esiste l'utente passato
     * 
     * @param string
     * @return boolean
     */
    public static function esisteUtenteValidoPerLogin($user)
    {
        $tmp = DB::table('contatti')
            ->join('contattiAuth', 'contatti.idContatto', '=', 'contattiAuth.idContatto')
            ->where('contatti.idStato', '=', 1)
            ->where('contattiAuth.user', '=', $user)
            ->select('contattiAuth.idContatto')
            ->get()
            ->count();
        return ($tmp > 0) ? true : false;
    }
    //---------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------
    /**
     * controllo se esiste l'utente passato
     * 
     * @param string
     * @return boolean
     */

    public static function esisteUtente($idContatto)
    {
        $tmp = DB::table('contattiAuth')->where('contattiAuth.idContatto', '=', $idContatto)->select('contattiAuth.idContatto')->get()->count();
        return ($tmp > 0) ? true : false;
    }
}
