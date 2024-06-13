<?php
	
	use Illuminate\Support\Facades\Route;
	
	Route::get('/', \App\Livewire\Homepage::class)->name('homepage');
	Route::get('dashboard', \App\Livewire\Dashboard::class)
		->middleware(['auth', 'verified'])
		->name('dashboard');
	
	Route::view('profile', 'profile')
		->middleware(['auth'])
		->name('profile');
	
	require __DIR__ . '/auth.php';
