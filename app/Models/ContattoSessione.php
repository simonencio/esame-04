<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContattoSessione extends Model
{
    use HasFactory;
    protected $table = "contattiSessioni";
    protected $primaryKey = "idContattoSessione";

    protected $fillable = [
        'idContatto',
        'token',
        'inizioSessione'
    ];

    //-- public--------------------------------------------
    //-----------------------------------------------------
    /**
     * aggiorna la sessione per il contatto ed il token passato
     * 
     * @param integer $idContatto
     * @param string $token
     */

    public static function aggiornaSessione($idContatto, $tk)
    {
        $where = ["idContatto" => $idContatto, "token" => $tk];
        $arr = ["inizioSessione" => time()];
        DB::table("contattiSessioni")->updateOrInsert($where, $arr);
    }

    //----------------------------------------------------------
    //----------------------------------------------------------
    /**
     * elimina la sessione per il contatto passato
     * @param integer $idContatto
     */

    public static function eliminaSessione($idContatto)
    {
        DB::table("contattiSessioni")->where("idContatto", $idContatto)->delete();
    }
    //-------------------------------------------------------------
    /**
     * dati sessione
     * 
     * @param string $token
     * @return App\Models\ContattoSessione
     * 
     */

    public static function datiSessione($token)
    {
        if (ContattoSessione::esisteSessione($token)) {
            //return DB::table("contattiSessioni")->where("token", $token)->first();
            return ContattoSessione::where("token", $token)->get()->first();
        } else {
            return null;
        }
    }

    //---------------------------------------------------------------------
    /**
     * controlla se esiste la sessione col token passato
     * @param string $token
     * @return boolean
     */
    public static function esisteSessione($token)
    {
        return DB::table("contattiSessioni")->where("token", $token)->exists();
    }
}
