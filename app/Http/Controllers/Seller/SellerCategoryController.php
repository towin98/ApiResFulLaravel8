<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
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
    public function index(Seller $seller)
    {
        /*lista de categorias en las que un vendedor ha realizado algun tipo de transaccion o venta*/
        $categories = $seller->products()
        ->with('categories')
        ->get()
        ->pluck('categories')
        ->collapse()
        ->unique('id')
        ->values();

        return $this->showAll($categories);
    }
}
