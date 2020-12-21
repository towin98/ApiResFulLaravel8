<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

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
