<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
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
        $this->allowedAdminAction();
        /* obtiene los vendedores que le vendieron a un comprador en especifico */

        /*Se obtiene basado en el id una coleccion basada en productos y vendedores*/
        $sellers = $buyer->transactions()->with('product.seller')
        ->get()
        ->pluck('product.seller') /* me trae solo los datos de vendedores */
        ->unique('id') /*que sean valores unicos por su id users*/
        ->values(); /* en caso de que se elimine un id repetido no quede el espacio. */

        return $this->showAll($sellers);
    }
}
