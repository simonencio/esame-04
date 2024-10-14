<?php

namespace App\Helpers;

use \Firebase\JWT\JWT;
use App\Models\Contatto;
use Exception;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\DB;



class AppHelper
{
    //-- PUBLIC ---------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------
    /**
     * toglie il required alle rules di aggiornamento
     * 
     * @param array $rules
     * @return array
     */
    public static function aggiornaRegoleHelper($rules)
    {
        $newRules = array();
        foreach ($rules as $key => $value) {
            $newRules[$key] = str_replace("required|", "", $value);
        }
        return $newRules;
    }

    // ------------------------------------------------------------------------------------------------------
    /**
     * unisci password e sale e fai HASH
     * 
     * @param string $testo da cifrare
     * @param string $chiave usata per cifrare
     * @return string
     */
    public static function cifra($testo, $chiave)
    {
        $testoCifrato = AesCtr::encrypt($testo, $chiave, 256);
        return base64_encode($testoCifrato);
    }

    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    /**
     * estrae i nomi dei campi della tabella sul DB
     * 
     * @param array $tabella
     * @return array
     */
    public static function colonneTabellaDB($tabella)
    {
        $SQL = "SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema='" . DB::connection()->getDatabaseName() . "' AND table_name='" . $tabella . "';";
        $tmp = DB::select($SQL);
        return $tmp;
    }
    /**
     * estrae i nomi dei campi della tabella sul DB
     * 
     * @param string $password
     * @param string $sale
     * @param string $sfida
     * @return array
     */
    public static function creaPasswordCifrata($password, $sale, $sfida)
    {
        $hashPasswordESale = AppHelper::nascondiPassword($password, $sale);
        $hashFinale = AppHelper::cifra($hashPasswordESale, $sfida);
        return $hashFinale;
    }
    //-------------------------------------------------------------------------------------------------------
    /**
     * toglie il required alle rules di aggiornamento
     * 
     * @param string $secretJWT come chiave di cifratura
     * @param integer $idContatto
     * @param string $secretJWT
     * @param integer $usaDa unixtime abilitazione uso token
     * @param integer $scade unixtime scadenza uso token
     * @return string
     */
    public static function creaTokenSessione($idContatto, $secretJWT, $usaDa = null, $scade = null)
    {
        $maxTime = 15 * 24 * 60 * 60; // il token scade sempre dopo 15gg max
        $recordContatto = Contatto::where("idContatto", $idContatto)->first();
        $t = time();
        $nbf = ($usaDa == null) ? $t : $usaDa;
        $exp = ($scade == null) ? $nbf + $maxTime : $scade;
        $ruoli = $recordContatto->ruoli;
        if ($ruoli->isNotEmpty()) {
            $ruolo = $ruoli->first();
            $idRuolo = $ruolo->idContattoRuolo;
        } else {
            // Handle the case where there are no roles assigned
            throw new Exception('Contatto instance has no roles assigned');
        }
        // $idRuolo = $ruolo->idContattoRuolo;
        // $abilita = $ruolo->abilita->toArray();
        // $abilita = array_map(function ($arr) {
        //     return $arr["idContattoAbilita"];
        // }, $abilita);

        $arr = array(
            "iss" => 'https://www.codex.it',
            "aud" => null,
            "iat" => $t,
            "nbf" => $nbf,
            "exp" => $exp,
            "data" => array(
                "idContatto" => $idContatto,
                "idStato" => $recordContatto->idStato,
                "idContattoRuolo" => $idRuolo,
                // "abilita" => $abilita,
                "nome" => trim($recordContatto->nome . " " . $recordContatto->cognome)
            )
        );
        $token = JWT::encode($arr, $secretJWT, "HS256");
        return $token;
    }
    /**
     * unisci password e sale e fai HASH
     * 
     * @param string $testo da decifrare
     * @param string $chiave usata per decifrare
     * @return string
     */
    public static function decifra($testoCifrato, $chiave)
    {
        $testoCifrato = base64_decode($testoCifrato);
        return AesCtr::decrypt($testoCifrato, $chiave, 256);
    }
    //---------------------------------------------------------------------------------------------------------
    /** controlla se è amministratore
     * 
     * @param string $idGruppo
     * @return boolean
     */
    public static function isAdmin($idGruppo)
    {
        return ($idGruppo == 1) ? true : false;
    }
    //------------------------------------------------------------------------------------------------------------
    /**
     * unisci password e sale e fai l'HASH
     * @param string $password
     * @param string $sale
     * @return string
     */
    public static function nascondiPassword($psw, $sale)
    {

        return hash("sha512", $sale . $psw);
    }
    //--------------------------------------------------------------------------------------------------------------
    /**
     * controlla se esiste l'utente passato
     * 
     * @param boolean $successo TRUE se la richiesta è andata a buon fine 
     * @param integer $codice STATUS CODE della richiesta
     * @param array $dati Dati richiesti
     * @param string $messaggio
     * @param array $errori
     * @return array
     */

    public static function rispostaCustom($dati, $msg = null, $err = null)
    {
        $response = array();
        $response["data"] = $dati;
        if ($msg != null) $response["message"] = $msg;
        if ($err != null) $response["error"] = $err;
        return $response;
    }
    //----------------------------------------------------------------------------------------------------------------
    /**
     * valida token
     * @param string $token
     * @param string $messaggio
     * @param array $errori
     * @return object 
     */
    public static function validaToken($token, $secretJWT, $sessione)
    {
        $rit = null;
        try {
            // JWT::$supported_algs = ['HS256'];
            // $payload = JWT::decode($token, $secretJWT);
            $payload = JWT::decode($token, new Key($secretJWT, 'HS256'));
            // print_r($payload);
            if ($payload->iat <= $sessione->inizioSessione) {
                if ($payload->data->idContatto == $sessione->idContatto) {
                    $rit = $payload;
                }
            }
        } catch (Exception $e) {
            // Handle token decoding errors
            echo 'Error decoding token: ' . $e->getMessage();
        }
        return $rit;
    }
}
