<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    use HasFactory;

    /* 139. Relacionando los Modelos con su Transformación */
    public $transformer = BuyerTransformer::class;

    protected static function boot()
    {
        /*llamamos el boot padre*/
        parent::boot();
        /*al global scope le pasamos el buyerscope que ejecutara*/
        static::addGlobalScope(new BuyerScope);
    }

    public function transactions()
    {
        /* un comprador puede tener muchas transaccioones */
        return $this->hasMany(Transaction::class);
    }
}
