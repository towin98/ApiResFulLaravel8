<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
/*Se implementa un interfaz llamada scope video 74*/

class SellerScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        /*cada vez que vaya a ejecutar el modelo buyer una consulta ejecutara este scope*/
        $builder->has('products');
    }
}
