<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
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
         /* Obtiene las categorias de cada unos de los productos relacionados
         con las transacciones de ese comprador */

        $sellers = $buyer->transactions()->with('product.categories')
        ->get()
        ->pluck('product.categories') /* trae solo datos de categories */
        ->collapse() /* colapsa y une*/
        ->unique('id') 
        ->values();  /* en caso de que se elimine un id repetido no quede el espacio. */

        return $this->showAll($sellers);
    }
}
