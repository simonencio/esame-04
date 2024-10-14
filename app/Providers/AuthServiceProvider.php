<?php

namespace App\Providers;

use App\Models\Contatto;
use App\Models\ContattoAbilita;
use App\Models\ContattoRuolo;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (app()->environment() !== 'testing') {
            // Gate basato su un ruoli
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
    }
}
