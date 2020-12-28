<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        /* Desactivamos llaves foreign */
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        /* con truncate borramos o vaciamos table */
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();

        /* table pivot */
        DB::table('category_product')->truncate();

        $cantidadUsuarios = 50;
        $cantidadCategorias = 10;
        $cantidadProductos = 80;
        $cantidadTransacciones = 80;

        /*desactivamos los eventos al momento de crear instancias*/
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        User::factory($cantidadUsuarios)->create();
        Category::factory($cantidadCategorias)->create();

        Product::factory($cantidadProductos)->create()->each(
            function ($producto) {

                /* Se crea el producto */
                /* Luego de crearlo se consulta todas las categorias */
                /* random -> obtenemos aleatoriamente entre 1 a 5  categorias*/
        
                $categorias = Category::all()->random(mt_rand(1, 5))->pluck('id');
                
                /* attach lo que hace es adjuntar los dos id para la tabla pivot  */
                /* recordar que categories es una funcion que dice que product y category */
                /* tiene una relacion de muchos a muchos */
                $producto->categories()->attach($categorias);
            }
        );
        Transaction::factory($cantidadTransacciones)->create();
    }
}
