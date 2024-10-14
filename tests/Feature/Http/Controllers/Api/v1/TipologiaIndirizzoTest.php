<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

use App\Helpers\AppHelper;
use App\Models\Configurazione;
use App\Models\Contatto;
use App\Models\ContattoAbilita;
use App\Models\ContattoAuth;
use App\Models\ContattoRuolo;
use App\Models\ContattoSessione;
use App\Models\SerieTv;
use App\Models\TipologiaIndirizzo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Tests\TestCase;

class TipologiaIndirizzoTest extends TestCase
{
    use RefreshDatabase;
    /** test */
    public function test_tutte_tipologie(): void
    {
        $this->impostaAmbiente();
        $contatto = $this->impostaContatto();
        $token = $this->impostaToken($contatto);
        $tipoContatto = TipologiaIndirizzo::factory()->count(rand(1, 4))->create();
        // test amministratore
        $ruoli = Contatto::sincronizzaContattoRuoli($contatto->idContatto, 1);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', $this->ritornaUrlSerie());
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->ritornaStrutturaJsonMultiplaTipologiaIndirizzo(1)]);
        $response->assertJson(['data' => $tipoContatto->toArray()]);


        //test Utente
        $ruoli = Contatto::sincronizzaContattoRuoli($contatto->idContatto, 2);

        $tmpModel = $tipoContatto->map(
            function ($model) {
                $arr = $this->ritornaStrutturaJsonSingolaTipologiaIndirizzo(0);
                $dati = $model->only($arr);
                $tmp = array();
                foreach ($arr as $item) {
                    if ($item == "nome") {
                        $tmp[$item] = array();
                    } else {
                        $tmp[$item] = $dati[$item];
                    }
                }
                return $tmp;
            }
        );
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->json('GET', $this->ritornaUrlSerie());
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => $this->ritornaStrutturaJsonMultiplaTipologiaIndirizzo(0)]);
        $response->assertJson(['data' => $tmpModel->toArray()]);
        // test Ospite
        $ruoli = Contatto::sincronizzaContattoRuoli($contatto->idContatto, 3);

        $response = $this->json('GET', $this->ritornaUrlSerie());
        $response->assertStatus(403);
    }

    //--- PROTECTED -------------------------------------------------------------------
    protected function impostaAmbiente()
    {
        $this->impostaConfigurazioni();
        $n = Configurazione::all()->count();
        $this->assertEquals($n, 4);

        $this->impostaDBAbilita();
        $n = contattoAbilita::all()->count();
        $this->assertEquals($n, 4);

        $this->impostaDBRuolo();
        $n = ContattoRuolo::all()->count();
        $this->assertEquals($n, 3);

        $this->impostaDBRuoloAbilita();
        $this->impostaGate();
    }
    //--------------------------------------------------------------------------------
    protected function impostaConfigurazioni()
    {
        Configurazione::create(["idConfigurazione" => 1, "chiave" => "maxLoginErrati", "valore" => 5]);
        Configurazione::create(["idConfigurazione" => 2, "chiave" => "durataSfida", "valore" => 30]);
        Configurazione::create(["idConfigurazione" => 3, "chiave" => "durataSessione", "valore" => 300]);
        Configurazione::create(["idConfigurazione" => 4, "chiave" => "storicoPsw", "valore" => 3]);
    }
    //--------------------------------------------------------------------------------
    protected function impostaContatto()
    {
        $utente = hash("sha512", trim("Utente"));
        $sfida = hash("sha512", trim("Sfida"));
        $secret = trim(Str::random(20));

        $contatto = Contatto::factory()->create();
        $contatto->idStato = 1;
        $contatto->save();

        $auth = new ContattoAuth();
        $auth->idContatto = $contatto->idContatto;
        $auth->secretJWT = $secret;
        $auth->user = $utente;
        $auth->sfida = $sfida;
        $auth->inizioSfida = time();
        $auth->obbligoCampo = 1;
        $auth->save();
        return $contatto;
    }
    //----------------------------------------------------------------------------------
    protected function impostaDBAbilita()
    {
        $arr = ["Leggere", "Creare", "Aggiornare", "Eliminare"];
        foreach ($arr as $item) {
            ContattoAbilita::create([
                'nome' => $item,
                'sku' => strtolower($item)
            ]);
        }
    }
    //--------------------------------------------------------------------------------------
    protected function impostaDBRuolo()
    {
        $arr = ["Amministratore", "Utente", "Ospite"];
        foreach ($arr as $item) {
            ContattoRuolo::create([
                'nome' => $item,
                'deleted_at' => null
            ]);
        }
    }
    //--------------------------------------------------------------------------------------
    protected function impostaDBRuoloAbilita()
    {
        $idRuolo = 1;
        $arrAbilita = [1, 2, 3, 4];
        ContattoRuolo::sincronizzaRuoloAbilita($idRuolo, $arrAbilita);
        $idRuolo = 2;
        $arrAbilita = [1, 3];
        ContattoRuolo::sincronizzaRuoloAbilita($idRuolo, $arrAbilita);
    }
    //--------------------------------------------------------------------------------------
    protected function impostaGate()
    {
        ContattoRuolo::all()->each(
            function (ContattoRuolo $ruolo) {
                Gate::define($ruolo->nome, function (Contatto $contatto) use ($ruolo) {
                    return $contatto->ruoli->contains('nome', $ruolo->nome);
                });
            }
        );

        // Gate basati su ruoli multipli
        ContattoAbilita::all()->each(function (ContattoAbilita $abilita) {
            Gate::define($abilita->sku, function (Contatto $contatto) use ($abilita) {
                $check = false;
                foreach ($contatto->ruoli as $item) {
                    if ($item->abilita->contains('sku', $abilita->sku)) {
                        $check = true;
                        break;
                    }
                }
                return $check;
            });
        });
    }


    //--------------------------------------------------------------------------------------
    protected function impostaToken($contatto)
    {
        $sessione = ContattoSessione::factory()->create()->first();
        $sessione->idContatto = $contatto->idContatto;
        $auth = ContattoAuth::where("idContatto", $contatto->idContatto)->first();
        $token = AppHelper::creaTokenSessione($contatto->idContatto, $auth->secretJWT);
        $sessione->token = $token;
        // $sessione->inizioSessione;
        $sessione->save();
        $sessione = ContattoSessione::where("idContatto", $contatto->idContatto)->first();
        $this->assertEquals($token, $sessione->token);
        return $token;
    }

    //----------------------------------------------------------------------------------------- 
    protected function ritornaStrutturaJsonMultiplaTipologiaIndirizzo($admin = 0)
    {
        return ['*' => $this->ritornaStrutturaJsonSingolaTipologiaIndirizzo($admin)];
    }
    //----------------------------------------------------------------------------------------- 
    protected function ritornaStrutturaJsonSingolaTipologiaIndirizzo($admin = 0)
    {
        if ($admin == 1) {
            $arr = ['idTipologiaIndirizzo', 'nome', 'deleted_at', 'created_by', 'updated_by'];
        } else {
            $arr = ['idTipologiaIndirizzo', 'nome'];
        }
        return $arr;
    }
    // ----------------------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------------------
    protected function ritornaUrlSerie($id = null)
    {
        $url = '/api/v1/tipologiaIndirizzi';
        if ($id != null) {
            $url = $url . '/' . $id;
        }
        return $url;
    }
}
