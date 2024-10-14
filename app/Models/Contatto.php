<?php

namespace App\Models;

use App\Events\ContattoCreatedEvent;
use App\Events\ContattoEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as ClassePerGate;

class Contatto extends ClassePerGate
{
    use HasFactory, SoftDeletes;
    protected $table = "contatti";
    protected $primaryKey = "idContatto";
    protected $fillable = [
        "idStato",
        "idCittadinanza",
        "idNazioneNascita",
        "CittaNascita",
        "ProvNascita",
        "nome",
        "cognome",
        "sesso",
        "codiceFiscale",
        "partitaIva",
        "dataNascita"
    ];


    public function contattoPassword()
    {
        return $this->hasOne(ContattoPassword::class, 'idContatto');
    }
    //------PUBLIC---------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------

    /**
     * aggiungi i ruoli per il contatto sulla tabella contatti_contattiRuoli
     * 
     * @param integer $idContatto
     * @param string|array $idRuoli
     * @return Collection
     */

    public static function aggiungiContattoRuoli($idContatto, $idRuoli)
    {
        $contatto = Contatto::where("idContatto", $idContatto)->firstOrFail();
        if (is_string($idRuoli)) {
            $tmp = explode(',', $idRuoli);
        } else {
            $tmp = $idRuoli;
        }
        $contatto->ruoli()->attach($tmp);
        return $contatto->ruoli;
    }

    //---------------------------------------------------------------------------------------------------------
    public function crediti()
    {
        return $this->hasOne(Credito::class, 'idContatto', 'idContatto');
    }


    //---------------------------------------------------------------------------------------------
    /**
     * elimina i ruoli per il contatto sulla tabella contatti_contattiRuoli
     * 
     * @param integer $idContatto
     * @param string|array $idRuoli
     * @return Collection
     */

    public static function eliminaContattoRuoli($idContatto, $idRuoli)
    {
        $contatto = Contatto::where("idContatto", $idContatto)->firstOrFail();
        if (is_string($idRuoli)) {
            $tmp = explode(',', $idRuoli);
        } else {
            $tmp = $idRuoli;
        }
        $contatto->ruoli()->detach($tmp);
        return $contatto->ruoli;
    }
    //------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------------------
    public function indirizzi()
    {
        return $this->hasMany(Indirizzo::class, 'idContatto', 'idContatto')->orderBy("preferito", "DESC");
    }
    //------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------------------
    public function recapiti()
    {
        return $this->hasMany(Recapito::class, 'idContatto', 'idContatto')->orderBy("preferito", "DESC");
    }
    //------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------------------
    public function ruoli()
    {
        return $this->belongsToMany(ContattoRuolo::class, 'contatti_contattiRuoli', 'idContatto', 'idContattoRuolo');
    }
    public function stato()
    {
        return $this->belongsTo(Stato::class, 'idStato');
    }

    public function cittadinanza()
    {
        return $this->belongsTo(cittadinanza::class, 'idCittadinanza');
    }

    public function nazioneNascita()
    {
        return $this->belongsTo(Comune::class, 'idNazioneNascita');
    }
    // ----------------------------------------------------------------------------------------------------------
    /**
     * Sincronizza i ruoli per il contatto sulla tabella contatti_contattiRuoli
     *
     * @param integer $idContatto
     * @param string|array $idRuoli
     * @return Collection
     */
    public static function sincronizzaContattoRuoli($idContatto, $idRuoli)
    {
        $contatto = Contatto::where("idContatto", $idContatto)->firstOrFail();
        if (is_string($idRuoli)) {
            $tmp = explode(',', $idRuoli);
        } else {
            $tmp = $idRuoli;
        }
        $contatto->ruoli()->sync($tmp);
        return $contatto->ruoli;
    }
}
