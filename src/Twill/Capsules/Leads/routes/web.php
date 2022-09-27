<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register/leads', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\LeadController::class, 'store'])->name('store');
Route::post('updated/leads/{id}', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\LeadController::class, 'updated'])->name('updated');
Route::post('delete/leads/{id}', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\LeadController::class, 'delete'])->name('delete');


Route::get('contact-us', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\ContactController::class, 'index']);
Route::post('contact-us/store', [Leads\Twill\Capsules\Leads\Http\Controllers\Web\ContactController::class, 'store'])->name('contact.us.store');