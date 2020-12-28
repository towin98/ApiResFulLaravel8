<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        /*Importamos la lista de rutas de passport*/
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(50));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        /*obtenemos inmediatamnete un acces token*/
        Passport::enableImplicitGrant();

        /*Registrar scup*/
        Passport::tokensCan([
            /* permitirle hacer compras en nombre del usuario */
            'purchase-product' => 'Crear transaccion para comprador productos determinados',
            'manege-products' => 'Crear, ver, Actualizar y eliminar',
            'manege-account' => 'Obtener la informacion  de la cuenta, nombre, email, estado(sin contraseña), modificar datos como email, nombre y contrasena. No puede eliminar la cuenta.',
            'read-general' => 'obtener la informacion general, categorias donde se compra y se vende, productos vendidos o comprados, transacciones, compras y ventas.'
        ]);
    }
}
