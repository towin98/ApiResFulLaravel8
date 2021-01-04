<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Transformers\TransactionTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    public function __construct()
    {
        /*llamamos al contructor del padre*/
        parent::__construct();

        $this->middleware('transform.input:'.TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-product')->only('store');
        $this->middleware('can:purchase,buyer')->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        /*Nueva transacction */

        $rules = [
            'quantity' => 'required|integer|min:1',
        ];

        $this->validate($request, $rules);

        /*comprado y vendedor tiene que ser diferentes*/
        if ($buyer->id == $product->seller->id) {
            return $this->errorResponse('El comprador debe ser diferente al vendedor',409);
        }

        if (!$buyer->esVerificado()) {
            return $this->errorResponse('El comprador debe ser verificado', 409);
        }

        if (!$product->seller->esVerificado()) {
            return $this->errorResponse('El vendedor debe ser verificado', 409);
        }
     
        if (!$product->estaDisponible()) {
            return $this->errorResponse('El producto para esta transaccion no esta disponible', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('El producto no tiene la cantidad suficiente para esta transaccion', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity; /*reducimos la cantidad*/
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return $this->showOne($transaction, 201);
        });

    }
}
