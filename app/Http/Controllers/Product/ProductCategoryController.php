<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->except(['index']);

        $this->middleware('scope:manage-products')->except(['index']);

        $this->middleware('can:add-category,product')->only(['update']);
        $this->middleware('can:delete-category,product')->only(['destroy']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        /*Obtener las categorias del producto*/
        $categories = $product->categories;

        return $this->showAll($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        /* Agregaremos la categoria al producto */

        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        /*Buscamos si existe dentro de las categorias
        asociadas al producto */
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('La categoria especificada no es una categoria de este producto', 404);
        }

        $product->categories()->detach([$category->id]);

        return $this->showAll($product->categories);
        
    }
}
