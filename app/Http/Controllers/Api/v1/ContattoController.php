<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Cittadinanza;
use App\Models\Comune;
use App\Models\Contatto;
use App\Models\Contatto_contattoRuolo;
use App\Models\ContattoAuth;
use App\Models\ContattoPassword;
use App\Models\ContattoSessione;
use App\Models\Nazione;
use App\Models\Stato;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContattoController extends Controller
{
    public function registra(Request $request)
    {
        // Valido la request
        $validator = Validator::make($request->all(), [
            'user' => 'required|string|min:5',
            'psw' => 'required|string|min:6',
            'nome' => 'string|between:2,100',
            'cognome' => 'required|string|between:2,100',
            'sesso' => 'required|integer|between:0,1',
            'codiceFiscale' => 'required|string|between:2,100',
            'ruolo' => 'required|string',
            'partitaIva' => 'required|integer',
            'dataNascita' => 'required|date'
        ]);

        // se fallisce la validazione ritorno un'errore
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        // controllo se esiste già un'utente 
        $existingUser = ContattoAuth::where('user', $request->input('user'))->first();

        // hash the provided password
        $hashedPassword = AppHelper::nascondiPassword($request->input('psw'), Str::random(200));

        // controllo se esiste già una password con lo stesso hash
        $existingPsw = ContattoPassword::where('psw', $hashedPassword)->first();

        // se esiste ritorno un'errore
        if ($existingUser || $existingPsw) {
            return response()->json(['error' => 'User or password already exists'], 400);
        }



        // Get the default idStato from the stati table
        $idStato = Stato::where('idStato', true)->first()->idStato;

        // Get the default idCittadinanza from the cittadinanze table
        $idCittadinanza = Cittadinanza::where('idCittadinanza', true)->first()->idCittadinanza;

        // Get the default idNazione from the Nazioni table
        $idNazioneNascita = Nazione::where('idNazione', true)->first()->idNazione;

        $cittaNascita = Comune::where('idComune', true)->first()->comune;

        $provNascita = Comune::where('idComune', true)->first()->provincia;





        // Se tutto è corretto creo un oggetto con i dati validati
        $contatto = Contatto::create(array_merge(
            $validator->validated(),
            [
                'idStato' => $idStato,
                'idCittadinanza' => $idCittadinanza,
                'idNazioneNascita' => $idNazioneNascita,
                'CittaNascita' => $cittaNascita,
                'ProvNascita' => $provNascita,
            ],
        ));


        // creo un sale casuale
        $sale = AppHelper::nascondiPassword($request->password, Str::random(200));

        // creo un oggetto in contattiPassword con la password criptata ed il sale
        $contattoPassword = new ContattoPassword([
            'psw' => $request->psw,
            "sale" => $sale
        ]);

        // genero una sfida casuale 
        $sfida = hash("sha512", trim(Str::random(200)));
        $inizioSfida = time();
        $obbligoCampo = 1;

        // creo il payload per il token JWT
        $payload = [
            'user' => $request->user,
            'psw' => $sale,
        ];

        // creo il token JWT usando il payload e la secretKey
        $secretKey = 'sha512';
        $secretJWT = JWT::encode($payload, $secretKey, 'HS256');

        // creo un oggetto in contattoAuth con il token ed altri dati
        $contattoAuth = new ContattoAuth();
        $contattoAuth->user = $request->user;
        $contattoAuth->idContatto = $contatto->idContatto;
        $contattoAuth->sfida = $sfida;
        $contattoAuth->secretJWT = $secretJWT;
        $contattoAuth->inizioSfida = $inizioSfida;
        $contattoAuth->obbligoCampo = $obbligoCampo;

        // creo un oggetto in contattoSessione con il token ed altri dati
        $contattoSessione = new ContattoSessione();
        $contattoSessione->idContatto = $contatto->idContatto;



        // creo un payload per la sezione token di contattoSessione
        // $payload = [
        //     'user' => $request->user,
        //     'psw' => $sale,
        // ];

        // $secretKey = 'sha512';
        // $token = JWT::encode($payload, $secretKey, 'HS256');


        // inserisco il token in ContattoSessione
        $contattoSessione->token = $secretJWT;
        $contattoSessione->inizioSessione = time();

        // collego i suoli a numeri
        $roleMapping = [
            'Amministratore' => 1,
            'Utente' => 2,
            'Ospite' => 3,
        ];
        $ruolo = $request->input('ruolo');

        // controllo se il ruolo è valido e creo un oggetto in contatto_contattoRuolo

        if (isset($roleMapping[$ruolo])) {
            $contattoContattoRuolo = new Contatto_contattoRuolo();
            $contattoContattoRuolo->idContatto = $contatto->idContatto;
            $contattoContattoRuolo->idContattoRuolo = $roleMapping[$ruolo];
            $contattoContattoRuolo->save();
        } else { // se il  ruolo non esiste mando un errore
            abort(403, "Invalid_role");
        }



        // salvo tutti i dati nel database
        $contattoSessione->save();
        $contattoAuth->save();
        $contatto->contattoPassword()->save($contattoPassword);

        // ritorno una risposta positiva se tutto è creato correttamente
        return response()->json([
            'message' => 'User successfully registered',
            'contatto' => $contatto,
            'contatto_password' => $contattoPassword,
            'contattoAuth' => $contattoAuth,
            'ContattoSessione' => $contattoSessione
        ], 201);
    }
}
