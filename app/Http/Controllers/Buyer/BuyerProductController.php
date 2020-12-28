<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {

        /*
        Buscamos los productos que ha comprado un usuario.

        - Buscamos por el id del usuario, luego vamos si existe en transacciones,
        - luego vemos los productos relacionados con la transaccion para mostrar. 

        */

        $products = $buyer->transactions()->with('product')
        ->get()
        ->pluck('product');

        return $this->showAll($products);
    }

   }
