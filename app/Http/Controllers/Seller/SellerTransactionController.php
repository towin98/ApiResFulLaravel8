<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only(['index']);
        $this->middleware('can:view,seller')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        /* Transacciones de un vendedor especifico*/
        $transactions = $seller->products()
        ->whereHas('transactions')
        ->with('transactions')  /*obtenemos transacciones de los productos*/
        ->get()
        ->pluck('transactions')
        ->collapse(); /*unir lista*/

        return $this->showAll($transactions);
    }
}
