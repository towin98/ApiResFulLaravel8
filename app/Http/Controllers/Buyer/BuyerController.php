<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Mostramos todos los compradores pero que tengan transacciones*/
        /* Lo que hace es ir al metodo transactions y verificar si existe en la tabla transacciones y traerlo */
        $compradores = Buyer::has('transactions')->get();

        return response()->json(['data' => $compradores], 200);
        return $this->showAll($compradores);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*Buscamos por id un comprador*/
        $compradores = Buyer::has('transactions')->findOrFail($id);

        return $this->showOne($compradores);
    }
}
