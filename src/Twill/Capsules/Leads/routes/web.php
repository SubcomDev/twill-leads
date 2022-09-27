<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'leads',

], function () {

    Route::post('register', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\LeadController::class, 'store'])->name('store');
    Route::post('updated/{id}', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\LeadController::class, 'updated'])->name('updated');
    Route::post('delete/{id}', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\LeadController::class, 'delete'])->name('delete');


    Route::post('contact/store', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\ContactController::class, 'store'])->name('contact.us.store');

});