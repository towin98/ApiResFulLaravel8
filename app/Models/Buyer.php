<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    use HasFactory;

    public function transactions()
    {
        /* un comprador puede tener muchas transaccioones */
        return $this->hasMany(Transaction::class);
    }
}
