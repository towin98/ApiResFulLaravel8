<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Traits\AdminAccions;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization, AdminAccions;

   
    /**
     * Determina si el usuario autenticado pertence al producto, para poder agregar una categoria al producto.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function addCategory(User $user, Product $product)
    {
        return $user->id === $product->seller->id;
    }

    /**
     * Determina si el usuario autenticado es el que pertenece al vendedor para poder eliminar.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function deleteCategory(User $user, Product $product)
    {
        return $user->id === $product->seller->id;
    }
}
