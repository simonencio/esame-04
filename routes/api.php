<?php

use App\Helpers\AppHelper;
use App\Http\Controllers\Api\v1\AccediController;
use App\Http\Controllers\Api\v1\CategoriaController;
use App\Http\Controllers\Api\v1\CittadinanzaController;
use App\Http\Controllers\Api\v1\ComuneController;
use App\Http\Controllers\Api\v1\ContattoController;
use App\Http\Controllers\Api\v1\CreditoController;
use App\Http\Controllers\Api\v1\EpisodioController;
use App\Http\Controllers\Api\v1\Film_ContattiController;
use App\Http\Controllers\Api\v1\FilmController;
use App\Http\Controllers\Api\v1\IndirizzoController;
use App\Http\Controllers\Api\v1\LinguaController;
use App\Http\Controllers\Api\v1\NazioneController;
use App\Http\Controllers\Api\v1\ProfiloController;
use App\Http\Controllers\Api\v1\RecapitoController;
use App\Http\Controllers\Api\v1\SerieTv_ContattiController;
use App\Http\Controllers\Api\v1\SerieTv_ContattoController;
use App\Http\Controllers\Api\v1\SerieTvController;
use App\Http\Controllers\Api\v1\TipologiaIndirizzoController;
use App\Http\Controllers\Api\v1\TipoRecapitoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if (!defined('_VERS')) {
    define('_VERS', 'v1');
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
Route::get(_VERS . '/testLogin', function () {
    // modificare i dati seguenti in base a quelli inseriti nel database, specialmente il SALE!
    $hashUser = "57cba3b26c4c4a1d7f7339f840cf6b6e35652e3206d3e28ee2bda07043bb268338de67044b38bb8f021c68f01297f2635edbcbcb5020ac95c5a0612aba725363";
    $psw = "288162ab5599d6a42fe2cf93fc68374c20c1b427a789b68ab6a2ec38caa727d0166f71e00d5c42be113ba58c75795c99899e157da4a9c14ceed6c7966e3b2e6b";
    $sale  = "a431349b6c179cea732c876bb75f7df9660dcf0dcd665032b8e68e6547cdd2aef02c25f25280f8cea8665f42d214366575c3eb14625862f802e013b06b0dbe2d";
    // rimuovere testLogin e  in controlloUtente il sale diventa random
    $hashSalePsw = AppHelper::nascondiPassword($psw, $sale);

    AccediController::testLogin($hashUser, $hashSalePsw);
});
Route::post(_VERS . '/cifra', [AccediController::class, 'cifraUser']);
Route::post(_VERS . '/cifraPsw', [AccediController::class, 'cifraPassword']);
Route::get(_VERS . '/accedi/{utente}/{hash?}', [AccediController::class, 'show']);
Route::get(_VERS . "/searchMail/{utente}", [AccediController::class, 'searchMail']);
Route::get(_VERS . "/registrazione/", [ContattoController::class, 'registra']);






//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/nazioni", [NazioneController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/nazioni/{nazione}", [NazioneController::class, 'show']);
        Route::get(_VERS . "/nazioni/continente/{continente}", [NazioneController::class, 'indexContinente']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::delete(_VERS . '/nazioni/{nazione}', [NazioneController::class, 'destroy']);
    }
);

//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/comuni", [ComuneController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/comuni/{comune}", [ComuneController::class, 'show']);
        Route::get(_VERS . "/comuni/regione/{regione}", [ComuneController::class, 'indexRegione']);
        Route::get(_VERS . "/comuni/provincia/{provincia}", [ComuneController::class, 'indexProvincia']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::delete(_VERS . '/comuni/{comune}', [ComuneController::class, 'destroy']);
    }
);

//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/cittadinanze", [CittadinanzaController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/cittadinanze/nome/{nome}", [CittadinanzaController::class, 'indexCittadinanza']);
        Route::get(_VERS . "/cittadinanze/{cittadinanza}", [CittadinanzaController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::delete(_VERS . '/cittadinanze/{cittadinanza}', [CittadinanzaController::class, 'destroy']);
    }
);

//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/tipologiaIndirizzi", [TipologiaIndirizzoController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/tipologiaIndirizzi/{tipologiaIndirizzo}", [TipologiaIndirizzoController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::put(_VERS . "/tipologiaIndirizzi/{tipologiaIndirizzo}", [TipologiaIndirizzoController::class, 'update']); // se utiliziamo apache e php non riconosce il put
        Route::post(_VERS . "/tipologiaIndirizzi", [TipologiaIndirizzoController::class, 'store']);
        Route::delete(_VERS . "/tipologiaIndirizzi/{tipologiaIndirizzo}", [TipologiaIndirizzoController::class, 'destroy']);
    }
);


//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------


Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/categorie", [CategoriaController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/categorie/{categoria}", [CategoriaController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::post(_VERS . "/categorie", [CategoriaController::class, 'store']);
        Route::put(_VERS . '/categorie/{categoria}', [CategoriaController::class, 'update']);
        Route::delete(_VERS . '/categorie/{categoria}', [CategoriaController::class, 'destroy']);
    }
);

//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/indirizzi", [IndirizzoController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/indirizzi/{indirizzo}", [IndirizzoController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::put(_VERS . "/indirizzi/{indirizzo}", [IndirizzoController::class, 'update']); // se utiliziamo apache e php non riconosce il put
        Route::post(_VERS . "/indirizzi", [IndirizzoController::class, 'store']);
        Route::delete(_VERS . "/indirizzi/{indirizzo}", [IndirizzoController::class, 'destroy']);
    }
);



//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/profili", [ProfiloController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/profili/{profilo}", [ProfiloController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::post(_VERS . "/profili", [ProfiloController::class, 'store']);
        Route::put(_VERS . '/profili/{profilo}', [ProfiloController::class, 'update']);
        Route::delete(_VERS . '/profili/{profilo}', [ProfiloController::class, 'destroy']);
    }
);

//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/crediti", [CreditoController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/crediti/{credito}", [CreditoController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::post(_VERS . "/crediti", [CreditoController::class, 'store']);
        Route::put(_VERS . '/crediti/{credito}', [CreditoController::class, 'update']);
        Route::delete(_VERS . '/crediti/{credito}', [CreditoController::class, 'destroy']);
    }
);

//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/recapiti", [RecapitoController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/recapiti/{recapito}", [RecapitoController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::post(_VERS . "/recapiti", [RecapitoController::class, 'store']);
        Route::put(_VERS . '/recapiti/{recapito}', [RecapitoController::class, 'update']);
        Route::delete(_VERS . '/recapiti/{recapito}', [RecapitoController::class, 'destroy']);
    }
);

//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/tipirecapiti", [TipoRecapitoController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/tipirecapiti/{tipoRecapito}", [TipoRecapitoController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::post(_VERS . "/tipirecapiti", [TipoRecapitoController::class, 'store']);
        Route::put(_VERS . '/tipirecapiti/{tipoRecapito}', [TipoRecapitoController::class, 'update']);
        Route::delete(_VERS . '/tipirecapiti/{tipoRecapito}', [TipoRecapitoController::class, 'destroy']);
    }
);
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/lingue", [LinguaController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/lingue/{lingua}", [LinguaController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::put(_VERS . "/lingue/{lingua}", [LinguaController::class, 'update']); // se utiliziamo apache e php non riconosce il put
        Route::post(_VERS . "/lingue", [LinguaController::class, 'store']);
        Route::delete(_VERS . "/lingue/{lingua}", [LinguaController::class, 'destroy']);
    }
);
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/serietv", [SerieTvController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/serietv/{serieTv}", [SerieTvController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::put(_VERS . "/serietv/{serieTv}", [SerieTvController::class, 'update']); // se utiliziamo apache e php non riconosce il put
        Route::post(_VERS . "/serietv", [SerieTvController::class, 'store']);
        Route::delete(_VERS . "/serietv/{serieTv}", [SerieTvController::class, 'destroy']);
    }
);
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/film", [FilmController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/film/{film}", [FilmController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::put(_VERS . "/film/{film}", [FilmController::class, 'update']); // se utiliziamo apache e php non riconosce il put
        Route::post(_VERS . "/film", [FilmController::class, 'store']);
        Route::delete(_VERS . "/film/{film}", [FilmController::class, 'destroy']);
    }
);
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/episodi", [EpisodioController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/episodi/{episodio}", [EpisodioController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::put(_VERS . "/episodi/{episodio}", [EpisodioController::class, 'update']); // se utiliziamo apache e php non riconosce il put
        Route::post(_VERS . "/episodi", [EpisodioController::class, 'store']);
        Route::delete(_VERS . "/episodi/{episodio}", [EpisodioController::class, 'destroy']);
    }
);
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/serietvContatti", [SerieTv_ContattiController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/serietvContatti/{serieTvContatto}", [SerieTv_ContattiController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::put(_VERS . "/serietvContatti/{serieTvContatto}", [SerieTv_ContattiController::class, 'update']); // se utiliziamo apache e php non riconosce il put
        Route::post(_VERS . "/serietvContatti", [SerieTv_ContattiController::class, 'store']);
        Route::delete(_VERS . "/serietvContatti/{serieTvContatto}", [SerieTv_ContattiController::class, 'destroy']);
    }
);

//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware(["Autenticazione", "ContattoRuolo:Amministratore,Utente,Ospite"])->group(
    function () {
        Route::get(_VERS . "/filmContatti", [Film_ContattiController::class, 'index']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore,Utente"])->group(
    function () {
        Route::get(_VERS . "/filmContatti/{filmContatto}", [Film_ContattiController::class, 'show']);
    }
);
Route::middleware(['Autenticazione', "ContattoRuolo:Amministratore"])->group(
    function () {
        Route::put(_VERS . "/filmContatti/{filmContatto}", [Film_ContattiController::class, 'update']); // se utiliziamo apache e php non riconosce il put
        Route::post(_VERS . "/filmContatti", [Film_ContattiController::class, 'store']);
        Route::delete(_VERS . "/filmContatti/{filmContatto}", [Film_ContattiController::class, 'destroy']);
    }
);
