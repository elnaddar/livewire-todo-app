<?php

use App\Livewire\TodoList;
use Illuminate\Support\Facades\Route;

Route::get('/', TodoList::class)->name('home');
