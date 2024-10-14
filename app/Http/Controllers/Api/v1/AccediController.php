<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Helpers\AppHelper;
use App\Models\Configurazione;
use App\Models\ContattoAccesso;
use App\Models\ContattoAuth;
use App\Models\ContattoPassword;
use App\Models\ContattoSessione;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AccediController extends Controller
{
    //- PUBLIC --------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    /**
     * cerco l'hash dello user nel DB
     * @param string $utente
     * @param string $hash
     * @return AppHelper\ritornoCustom
     */
    public function searchMail($utente)
    {
        $tmp = (ContattoAuth::esisteUtente($utente)) ? true : false;
        return AppHelper::rispostaCustom($tmp);
    }
    //---------------------------------------------------------------------------------------
    /**
     * punto di ingresso del login
     * @param string $utente
     * @param string $hash
     * @return AppHelper\ritornoCustom
     */
    public function show($utente, $hash = null)
    {
        echo "CIAO";
        if ($hash == null) {
            return AccediController::controlloUtente($utente);
        } else {
            return AccediController::controlloPassword($utente, $hash);
        }
    }

    //---------------------------------------------------------------------------------------
    /**
     * creo il token per lo sviluppo
     * 
     * @return AppHelper\rispostaCustom
     */
    public static function testToken()
    {
        $utente = hash("sha512", trim("Admin@Utente"));
        $password = hash("sha512", trim("Password123!"));
        $sale = hash("sha512", trim("Sale"));
        $sfida = hash("sha512", trim("Sfida"));
        $secretJWT = hash("sha512", trim("Secret"));
        $auth = ContattoAuth::where('user', $utente)->firstOrFail();
        if ($auth != null) {
            $auth->inizioSfida = time();
            //$auth->sfida=$sfida;
            $auth->secretJWT = $secretJWT;
            $auth->save();

            $recordPassword = ContattoPassword::passwordAttuale($auth->idContatto);
            if ($recordPassword != null) {
                $recordPassword->sale = $sale;
                $recordPassword->psw = $password;
                $recordPassword->save();
                //$cipher= AppHelper::creaPasswordCifrata($password,$sale,$sfida);
                $cipher = AppHelper::nascondiPassword($password, $sale);
                $tk = AppHelper::creaTokenSessione($auth->idContatto, $secretJWT);
                $dati = array("token" => $tk, "Login" => $cipher);
                $sessione = ContattoSessione::where("idContatto", $auth->idContatto)->firstOrFail();
                $sessione->token = $tk;
                $sessione->inizioSessione = time();
                $sessione->save();
                return AppHelper::rispostaCustom($dati);
            }
        }
    }

    //---------------------------------------------------------------------------------------
    /**
     * crea il token per sviluppo
     * 
     * @param string $utente
     * @return AppHelper\rispostaCustom
     */

    public static function testLogin($hashUtente, $hashPassword)
    {
        // $hashPassword = "3ac4de2d49bed0926a6a8d2ee91f7b71d2f8613c45347a5abda46e1171d318978c5a1269981f740046ae6b03706c6ea4b7008538d2787c71c10608f5d4139002";
        // $hashUtente = "4dfb2a43052d61abf30b58a9e77ef439b42a01ae1f75db1d2f6a1bf4ea685d2ba82a7536a0734654c0a6587ca89a2b0f62a63a2fab0d1657ad3b900f3794fe";
        // return AccediController::controlloPassword($hashUtente, $hashPassword);
        print_r(AccediController::controlloPassword($hashUtente, $hashPassword));
    }

    //---------------------------------------------------------------------------------------
    /**
     * verifica il token ad ogni chiamata
     * @param string $token
     * @return object
     */
    public static function verificaToken($token)
    {
        $rit = null;
        $sessione = ContattoSessione::datiSessione($token);
        if ($sessione != null) {
            $inizioSessione = $sessione->inizioSessione;
            $durataSessione = Configurazione::leggiValore("durataSessione");
            $scadenzaSessione = $inizioSessione + $durataSessione;
            //echo ("PUNTO 1<br>");
            if (
                time() < $scadenzaSessione
            ) {
                // echo ("PUNTO 2<br>");
                $auth = ContattoAuth::where('idContatto', $sessione->idContatto)->first();
                if ($auth != null) {
                    // echo("PUNTO 3<br>");
                    $secretJWT = $auth->secretJWT;
                    $payload = AppHelper::validaToken($token, $secretJWT, $sessione);
                    if ($payload != null) {
                        // echo("PUNTO 4<br>");
                        $rit = $payload;
                    } else {
                        abort(403, 'TK_0006');
                    }
                } else {
                    abort(403, 'TK_0005');
                }
            } else {
                abort(403, 'TK_0004');
            }
        } else {
            abort(403, 'TK_0003');
        }
        return $rit;
    }

    // -PROTECTED------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------------
    /**
     * controllo validita utente
     * 
     *@param string $utente
     * @return AppHelper\rispostaCustom
     */

    protected static function controlloUtente($utente)
    {
        //$sfida = hash("sha512", trim(Str::random(200)));
        // $sale = hash("sha512", trim(Str::random(200)));
        $sale = hash("sha512", "ciao");
        if (ContattoAuth::esisteUtenteValidoPerLogin($utente)) {
            //esiste
            $auth = ContattoAuth::where('user', $utente)->first();
            // $auth->sfida=$sfida;
            $auth->secretJWT = hash("sha512", trim(Str::random(200)));
            $auth->inizioSfida = time();
            $auth->save();
            $recordPassword = ContattoPassword::passwordAttuale($auth->idContatto);
            $recordPassword->sale = $sale;
            $recordPassword->save();
        } else {
            //non esiste, quindi invento sfida e sale per confondere le idee
        }
        //$dati = array("sfida"=>$sfida, "sale"=>$sale);
        $dati = array("sale" => $sale);
        return AppHelper::rispostaCustom($dati);
    }

    //------------------------------------------------------------------------------------------------------
    /**
     * punto di ingresso del login
     * 
     * @param string $utente
     * @param string $hash
     * @return AppHelper\rispostaCustom
     */
    protected static function controlloPassword($utente, $hashClient)
    {
        if (ContattoAuth::esisteUtenteValidoPerLogin($utente)) {
            //esiste
            $auth = ContattoAuth::where('user', $utente)->first();
            //$sfida=$auth->sfida;
            $secretJWT = $auth->secretJWT;
            $inizioSfida = $auth->inizioSfida;
            $durataSfida = Configurazione::leggiValore("durataSfida");
            $maxTentativi = Configurazione::leggiValore("maxLoginErrati");
            $scadenzaSfida = $inizioSfida + $durataSfida;

            if (time() < $scadenzaSfida) {
                $tentativi = ContattoAccesso::contaTentativi($auth->idContatto);
                if ($tentativi < $maxTentativi - 1) {
                    //proseguo
                    $recordPassword = ContattoPassword::passwordAttuale($auth->idContatto);
                    $password = $recordPassword->psw;
                    $sale = $recordPassword->sale;

                    $passwordNascostaDB = AppHelper::nascondiPassword($password, $sale);


                    //hash("sha512", $sale . $password)
                    if ($passwordNascostaDB == $hashClient) {
                        //login corretto quindi creo token
                        $tk = AppHelper::creaTokenSessione($auth->idContatto, $secretJWT);
                        ContattoAccesso::eliminaTentativi($auth->idContatto);
                        $accesso = ContattoAccesso::aggiungiAccesso($auth->idContatto);

                        ContattoSessione::eliminaSessione($auth->idContatto);

                        ContattoSessione::aggiornaSessione($auth->idContatto, $tk);

                        $dati = array("tk" => $tk);
                        return AppHelper::rispostaCustom($dati);
                    } else {
                        ContattoAccesso::aggiungiTentativoFallito($auth->idContatto);
                        abort(403, "ERR L004");
                    }
                } else {
                    abort(403, "ERR L003");
                }
            } else {
                ContattoAccesso::aggiungiTentativoFallito($auth->idContatto);
                abort(403, "ERR L002");
            }
        } else {
            abort(403, "ERR L001");
        }
    }




    // public function registra(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'user' => 'required|string|min:5',
    //         'psw' => 'required|string|min:6',
    //         'nome' => 'string|between:2,100',
    //         'cognome' => 'required|string|between:2,100',
    //         'sesso' => 'required|integer|between:0,1',
    //         'codiceFiscale' => 'required|string|between:2,100',
    //         'ruolo' => 'required|string',
    //         'auth' => 'required|integer|between:0,1'
    //     ]);


    //     if ($validator->fails()) {
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }
    //     $existingUser = ContattoAuth::where('user', $request->input('user'))->first();
    //     $existingPsw = ContattoPassword::where('psw', bcrypt($request->input('psw')))->first();

    //     if ($existingUser || $existingPsw) {
    //         return response()->json(['error' => 'User or password already exists'], 400);
    //     }
    //     $contatto = Contatto::create(array_merge(
    //         $validator->validated(),
    //         // any additional fields for the Contatti table
    //     ));

    //     $sale = AppHelper::nascondiPassword($request->password, Str::random(200));
    //     $contattoPassword = new ContattoPassword([
    //         'psw' => bcrypt($request->password),
    //         "sale" => $sale
    //     ]);

    //     $sfida = hash("sha512", trim(Str::random(200)));
    //     $inizioSfida = time();
    //     $obbligoCampo = 1; //This column is not explicitly generated in the code, so I'm assuming it's null

    //     $payload = [
    //         'user' => $request->user,
    //         'psw' => $sale,
    //     ];

    //     $secretKey = 'sha512';
    //     $secretJWT = JWT::encode($payload, $secretKey, 'HS256');

    //     // Create a new ContattoAuth object
    //     $contattoAuth = new ContattoAuth();
    //     $contattoAuth->user = $request->user;
    //     $contattoAuth->idContatto = $contatto->idContatto; // Assuming $contatto is the related Contatto object
    //     $contattoAuth->sfida = $sfida;
    //     $contattoAuth->secretJWT = $secretJWT;
    //     $contattoAuth->inizioSfida = $inizioSfida;
    //     $contattoAuth->obbligoCampo = $obbligoCampo;

    //     $contattoSessione = new ContattoSessione();
    //     $contattoSessione->idContatto = $contatto->idContatto; // Set the foreign key

    //     $payload = [
    //         'user' => $request->user,
    //         'psw' => $sale,
    //     ];

    //     $secretKey = 'sha512';
    //     $token = JWT::encode($payload, $secretKey, 'HS256');

    //     $contattoSessione->token = $token;
    //     $contattoSessione->inizioSessione = time(); // Set the current timestamp

    //     $roleMapping = [
    //         'Amministratore' => 1,
    //         'Utente' => 2,
    //         'Ospite' => 3,
    //     ];

    //     $ruolo = $request->input('ruolo');

    //     if (isset($roleMapping[$ruolo])) {
    //         $contattoContattoRuolo = new Contatto_contattoRuolo();
    //         $contattoContattoRuolo->idContatto = $contatto->idContatto;
    //         $contattoContattoRuolo->idContattoRuolo = $roleMapping[$ruolo];
    //         $contattoContattoRuolo->save();
    //     } else {
    //         abort(403, "Invalid_role");
    //     }


    //     $contattoAccesso = new ContattoAccesso();

    //     $contattoAccesso->idContatto = $contatto->idContatto; // Get the idContatto from the contatti table
    //     $contattoAccesso->autenticato = $request->input('auth') == 1 ? 1 : 0; // Set autenticato based on the auth field in the request
    //     $contattoAccesso->ip = $request->ip(); // Get the IP address from the request

    //     $contattoAccesso->save();
    //     $contattoSessione->save();
    //     $contattoAuth->save();
    //     $contatto->contattoPassword()->save($contattoPassword);
    //     return response()->json([
    //         'message' => 'User successfully registered',
    //         'contatto' => $contatto,
    //         'contatto_password' => $contattoPassword,
    //         'contattoAuth' => $contattoAuth,
    //         'ContattoSessione' => $contattoSessione
    //     ], 201);
    // }

    public static function cifraUser(Request $request)
    {
        $nome = $request->input('nome');
        $cognome = $request->input('cognome');
        $user_data = $nome . $cognome; // concatenate the nome and cognome
        $hashed_user = hash("sha512", $user_data); // hash the user data
        return $hashed_user; // return the hashed user
    }
    public static function cifraPassword(Request $request)
    {
        $psw = $request->input('psw');
        $hashed_psw = hash("sha512", $psw); // hash the psw data
        return $hashed_psw; // return the hashed psw
    }
}
