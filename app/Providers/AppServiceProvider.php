<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* todas los campos tendran una longitud de 191 */
        Schema::defaultStringLength(191);

        Product::updated(function($product){
            if ($product->quantity == 0 && $product->estaDisponible()) {
                $product->status = Product::PRODUCTO_NO_DISPONIBLE;

                $product->save();
            }
        });


        /*
            retry( , ) recibe el numero de intentos, luego la funcion que ejecutara,
            por ultimo el tiempo en que se ejecutara cada intento. 
        */

        User::created(function($user){
            /*utilizamos el fasac de email para enviar correo al destinatario*/
            retry(5, function() use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            },100);
        });

        User::updated(function($user){
            /*verificamos si se ha modificado el atri correo*/
            if ($user->isDirty('email')) {
                retry(5, function() use ($user) {
                    Mail::to($user)->send(new UserMailChanged($user));
                },100);
            }
        });
    
    }
}
