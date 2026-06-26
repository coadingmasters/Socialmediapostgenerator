<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'post-generator')->name('dashboard');
Route::livewire('/history', 'post-history')->name('history');
