<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryTransactionController extends ApiController
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
    public function index(Category $category)
    {
        $this->allowedAdminAction();
        
        /* 
        -lista de productos que por lo menos tengan una transaccion, 
        -traemos las transacciones
        */
        $transactions = $category->products()
            ->whereHas('transactions') /* obtenemos los productos que por lo menos tengan una transaccion*/
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();
        
        return $this->showAll($transactions);            
    }

}
