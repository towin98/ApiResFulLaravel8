<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes --- RouteServiceProvider  -----
|--------------------------------------------------------------------------
*/

Route::Resource('/buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);

Route::Resource('/categories', 'Category\CategoryController', ['except' => ['index', 'edit']]);

Route::Resource('/products', 'Product\ProductController', ['only' => ['index', 'show']]);

Route::Resource('/transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

Route::Resource('/sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);

Route::Resource('/users', 'User\UserController', ['except' => ['create', 'edit']]);
