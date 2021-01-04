<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionSellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only(['index']);
        $this->middleware('can:view,transaction')->only(['show']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        /* 
        - Buscamos por id de la transaccion, luego vamos al id del producto a la tabla product,  
        luego en la tabla buscamos quien lo vendio
         */
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }
}
