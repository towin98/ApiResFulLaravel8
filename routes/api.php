<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes --- RouteServiceProvider  -----
|--------------------------------------------------------------------------
*/

/*Rutas para compradores*/
Route::Resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
Route::Resource('buyers.transactions', 'Buyer\BuyertransactionController', ['only' => ['index']]);
Route::Resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::Resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::Resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);

/*Rutas para categorias*/
Route::Resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::Resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);
Route::Resource('categories.sellers', 'Category\CategorySellerController', ['only' => ['index']]);
Route::Resource('categories.transactions', 'Category\CategoryTransactionController', ['only' => ['index']]);
Route::Resource('categories.buyers', 'Category\CategoryBuyerController', ['only' => ['index']]);


/*Rutas para productos*/
Route::Resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);
Route::Resource('products.transactions', 'Product\ProductTransactionController', ['only' => ['index']]);
Route::Resource('products.buyers', 'Product\ProductBuyerController', ['only' => ['index']]);
Route::Resource('products.categories', 'Product\ProductCategoryController', ['only' => ['index', 'update', 'destroy']]);
Route::Resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only' => ['store']]);


/*Rutas para Transacciones*/
Route::Resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::Resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
Route::Resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index']]);

/*Rutas para Vendedores*/
Route::Resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::Resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::Resource('sellers.categories', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::Resource('sellers.buyers', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::Resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create', 'show', 'edit']]);


/*Rutas para usuarios*/
Route::Resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');

/*La agregamos aca para que obtenga lo middleware de api   */
Route::post('oauth/token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

/**
 * Sin -- php artisan passport:client 
 * Para cliente - php artisan passport:client --password*/