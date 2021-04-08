<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;

   
    // get all categories
    Route::get('get_all_categories', [CategoryController::class,"get_all_categories"]);
    //

    // get sub categories via id
    Route::get('get_category', [CategoryController::class,"get_category"]);
    //
    
?>