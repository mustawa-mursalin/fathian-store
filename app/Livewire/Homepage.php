<?php
	
	namespace App\Livewire;
	
	use Livewire\Component;
	
	class Homepage extends Component
	{
		public function render()
		{
			return view('livewire.homepage',
				[
					'brands'     => \App\Models\Brand::has('products')->where('is_active', true)->get(),
					'categories' => \App\Models\Category::has('products')->where('is_active', true)->get(),
				]
			)->title('Homepage');
		}
	}
