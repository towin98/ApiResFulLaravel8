<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    use HasFactory;

    public function products()
    {
        /*un vendedor tiene muchos productos */
        return $this->hasMany(Product::class);
    }
}
