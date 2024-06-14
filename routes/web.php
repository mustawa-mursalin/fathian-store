<?php
	
	use Illuminate\Support\Facades\Route;
	use Livewire\Volt\Volt;
	
	Route::get('/', \App\Livewire\Homepage::class)->name('homepage');
	Route::get('dashboard', \App\Livewire\Dashboard::class)
		->middleware(['auth', 'verified'])
		->name('dashboard');
	
	Volt::route('categories', 'categories')
		->name('categories');
	
	Volt::route('products', 'products')
		->name('products');
	
	Volt::route('products/{slug}', 'product-details');
	
	Volt::route('cart', 'cart')
		->name('cart');
	
	Volt::route('checkout', 'checkout')
		->name('checkout');
	
	Volt::route('orders', 'orders')->name('orders');
	Volt::route('orders/{order}', 'order-details');
	Volt::route('orders/cancel/{order}', 'order-cancel');
	Volt::route('orders/success/{order}', 'order-success');
	
	
	Route::view('profile', 'profile')
		->middleware(['auth'])
		->name('profile');
	
	require __DIR__ . '/auth.php';
