<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /* 139. Relacionando los Modelos con su Transformación */
    public $transformer = CategoryTransformer::class;

    protected $dates = ['delete_at']; /*decimos que debera tratado como una fecha*/

    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function products()
    {
        /* pertenece a muchos */
        return $this->belongsToMany(Product::class);
    }
}
