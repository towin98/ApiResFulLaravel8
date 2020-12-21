<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    protected $fillable = [
        'name',
        'descripcion',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    public function estaDisponible()
    {
        return $this->status == Product::PRODUCTO_DISPONIBLE;
    }

    public function seller()
    {
        /* un producto pertenece a un vendedor */
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        /* un producto posee muchas transactions  */
        return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
        /* pertenece a muchos */
        return $this->belongsToMany(Category::class);
    }
}
