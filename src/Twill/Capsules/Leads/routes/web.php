<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register/leads', [Leads\Twill\Capsules\Leads\Controllers\Api\LeadController::class, 'store'])->name('store');
Route::post('updated/leads/{id}', [Leads\Twill\Capsules\Leads\Controllers\Api\LeadController::class, 'updated'])->name('updated');