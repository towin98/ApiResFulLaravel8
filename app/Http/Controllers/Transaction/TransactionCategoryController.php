<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        /*
        - Buscamos por por el id de transaccion
        - Luego vamos a la columna product y vemos su id.
        - Por el id de product buscamos las categorias que pertenecen a ese producto. 
        */
        $categories = $transaction->product->categories;
        
        return $this->showAll($categories);
    }
}
