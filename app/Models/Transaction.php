<?php

namespace App\Models;

use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /* 139. Relacionando los Modelos con su Transformación */
    public $transformer = TransactionTransformer::class;

    protected $dates = ['delete_at']; /*decimos que debera tratado como una fecha*/

    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id'
    ] ;

    public function buyer()
    {
        /* una transaccion pertenece a un comprador */
        return $this->belongsTo(Buyer::class);
    }

    public function product()
    {
        /* una transaccion pertenece a un producto */
        return $this->belongsTo(Product::class);
    }
}
