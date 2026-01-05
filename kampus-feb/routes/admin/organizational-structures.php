<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrganizationalStructureController;

/*
|--------------------------------------------------------------------------
| Organizational Structure Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('organizational-structures', OrganizationalStructureController::class)
    ->middleware('throttle:60,1');

Route::post('organizational-structures/update-order', [OrganizationalStructureController::class, 'updateOrder'])
    ->name('organizational-structures.update-order')
    ->middleware('throttle:30,1');

Route::get('organizational-structures-tree', [OrganizationalStructureController::class, 'getTree'])
    ->name('organizational-structures.tree')
    ->middleware('throttle:60,1');