<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 *
 */
// Route::get('/leads',[Leads\Twill\Capsules\Leads\Http\Controllers\LeadController::class, 'index'])->name('leads');
Route::get('/leads/all',[Leads\Twill\Capsules\Leads\Http\Controllers\Admin\LeadController::class, 'list'])->name('leads.all');
Route::get('/leads/export',[Leads\Twill\Capsules\Leads\Http\Controllers\Admin\LeadController::class, 'export'])->name('leads.export');
Route::get('/leads/delete/bulk',[Leads\Twill\Capsules\Leads\Http\Controllers\Admin\LeadController::class, 'bulkDelete'])->name('leads.delete');
Route::get('/leads/delete/{id}',[Leads\Twill\Capsules\Leads\Http\Controllers\Admin\LeadController::class, 'destroy'])->name('lead.delete');

//leads
Route::module('leads');