<?php

namespace App\Models;

use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    use HasFactory;

    /* 139. Relacionando los Modelos con su Transformación */
    public $transformer = SellerTransformer::class;

    protected static function boot()
    {
        /*llamamos el boot padre*/
        parent::boot();
        /*al global scope le pasamos el buyerscope que ejecutara*/
        static::addGlobalScope(new SellerScope);
    }

    public function products()
    {
        /*un vendedor tiene muchos productos */
        return $this->hasMany(Product::class);
    }
}
