<?php

namespace App\Models;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    /* 139. Relacionando los Modelos con su Transformación */
    public $transformer = ProductTransformer::class;

    protected $dates = ['delete_at']; /*decimos que debera tratado como una fecha*/

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    protected $hidden = [
        'pivot'
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
