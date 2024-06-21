<?php
	
	
	use Illuminate\View\View;
	use Livewire\Attributes\Title;
	use Livewire\Attributes\Url;
	use Livewire\Volt\Component;
	
	new #[Title('Products')] class extends Component {
		use \Livewire\WithPagination;
		use \Jantinnerezo\LivewireAlert\LivewireAlert;
		
		//		public function rendering(View $view) : void
		//		{
		//			$view->title('Products');
		//		}
		
		#[Url]
		public array $selected_categories = [];
		
		#[Url]
		public array $selected_brands = [];
		
		//		#[Url]
		public bool $featured;
		//		#[Url]
		public bool $on_sale;
		
		public int    $min_price;
		public int    $max_price;
		public int    $price_range;
		public string $sort = 'latest';
		
		
		public function addToCart($product_id) : void
		{
			$total_count = \App\Helpers\CartManagement::addItemToCart($product_id);
			$this->dispatch('update-cart-count', total_count : $total_count);
			
			$this->alert('success', 'Product added to cart successfully.', [
				'position'         => 'top-end',
				'timer'            => 3000,
				'toast'            => true,
				'timerProgressBar' => false,
			]);
		}
		
		
		public function with() : array
		{
			$this->min_price = \App\Models\Product::min('price');
			$this->max_price = \App\Models\Product::max('price');
			$products        = \App\Models\Product::where('is_active', 1);
			
			if (!empty($this->selected_categories)) {
				$products->whereIn('category_id', $this->selected_categories);
			}
			if (!empty($this->selected_brands)) {
				$products->whereIn('brand_id', $this->selected_brands);
			}
			if (!empty($this->featured)) {
				$products->where('is_featured', $this->featured);
			}
			if (!empty($this->on_sale)) {
				$products->where('on_sale', $this->on_sale);
			}
			if (!empty($this->price_range)) {
				$products->whereBetween('price', [$this->min_price, $this->price_range]);
			}
			if ($this->sort == 'latest') {
				$products->latest();
			}
			if ($this->sort == 'min_price') {
				$products->orderBy('price');
			}
			if ($this->sort == 'max_price') {
				$products->orderBy('price', 'desc');
			}
			
			return [
				'products'   => $products->paginate(9),
				'brands'     => \App\Models\Brand::has('products')->get(),
				'categories' => \App\Models\Category::has('products')->get(),
			];
		}
	};
?>

<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
	<section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
		<div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
			<div class="flex flex-wrap mb-24 -mx-3">
				<div class="w-full pr-2 lg:w-1/4 lg:block">
					<div class="p-4 mb-5 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
						<h2 class="text-2xl font-bold dark:text-gray-400"> Categories</h2>
						<div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
						<ul>
							@foreach($categories as $category)
								<li wire:key="{{$category->id}}" class="mb-4">
									<label for="{{$category->slug}}" class="flex items-center dark:text-gray-400 ">
										<input wire:model.live="selected_categories" type="checkbox" id="{{$category->slug}}"
										       value="{{$category->id}}" class="w-4 h-4 mr-2">
										<span class="text-lg">{{$category->name}}</span>
									</label>
								</li>
							@endforeach
						</ul>
					
					</div>
					<div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
						<h2 class="text-2xl font-bold dark:text-gray-400">Brand</h2>
						<div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
						<ul>
							@foreach($brands as $brand)
								<li wire:key="{{$brand->id}}" class="mb-4">
									<label for="{{$brand->slug}}" class="flex items-center dark:text-gray-300">
										<input wire:model.live="selected_brands" type="checkbox" id="{{$brand->slug}}"
										       value="{{$brand->id}}" class="w-4 h-4 mr-2">
										<span class="text-lg dark:text-gray-400">{{$brand->name}}</span>
									</label>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
						<h2 class="text-2xl font-bold dark:text-gray-400">Product Status</h2>
						<div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
						<ul>
							<li class="mb-4">
								<label for="featured" class="flex items-center dark:text-gray-300">
									<input wire:model.live="featured" type="checkbox" id="featured" value="1" class="w-4 h-4 mr-2">
									<span class="text-lg dark:text-gray-400">Featured Products</span>
								</label>
							</li>
							<li class="mb-4">
								<label for="on_sale" class="flex items-center dark:text-gray-300">
									<input wire:model.live="on_sale" type="checkbox" id="on_sale" value="1" class="w-4 h-4 mr-2">
									<span class="text-lg dark:text-gray-400">On Sale</span>
								</label>
							</li>
						</ul>
					</div>
					
					<div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
						<h2 class="text-2xl font-bold dark:text-gray-400">Price</h2>
						<div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
						<div>
							<div class="font-semibold">Rp. {{number_format($price_range,0,'','.')}}</div>
							<input type="range" class="w-full h-1 mb-4 bg-blue-100 rounded appearance-none cursor-pointer"
							       max="{{ceil($max_price/1000)*1000}}" min="{{ceil($min_price/1000)*1000}}" value="{{$max_price/2}}"
							       wire:model.live="price_range"
							       step="1000">
							<div class="flex justify-between ">
								<span class="inline-block text-lg font-bold text-blue-400 ">Rp. {{number_format($min_price,0,'','.')}}</span>
								<span class="inline-block text-lg font-bold text-blue-400 ">Rp. {{number_format($max_price,0,'','.')}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="w-full px-3 lg:w-3/4">
					<div class="px-3 mb-4">
						<div class="items-center justify-between hidden px-3 py-2 bg-gray-100 md:flex dark:bg-gray-900 ">
							<div class="flex items-center justify-between">
								<label for="sort" class="mr-2">Filter Berdasarkan :</label>
								<select wire:model.live="sort" id="sort"
								        class="block w-50 text-base bg-gray-100 cursor-pointer dark:text-gray-400 dark:bg-gray-900">
									<option value="latest">Produk Terbaru</option>
									<option value="min_price">Harga Termurah</option>
									<option value="max_price">Harga Termahal</option>
								</select>
							</div>
						</div>
					</div>
					<div class="flex flex-wrap items-center ">
						@foreach($products as $product)
							<div wire:key="{{$product->id}}" class="w-full px-3 mb-6 sm:w-1/2 md:w-1/3">
								<div class="border border-gray-300 dark:border-gray-700">
									<div class="relative bg-gray-200">
										<a href="{{url('products', $product->slug)}}" class="">
											@if($product->images == null)
												<img src="{{url('storage/default.jpg')}}" alt="{{$product->name}}"
												     class="object-cover w-40 h-60 mx-auto ">
											@else
												<img src="{{url('storage/'.$product->images[0])}}" alt="{{$product->name}}"
												     class="object-cover w-40 h-60 mx-auto ">
											
											@endif
										</a>
									</div>
									<div class="p-3 ">
										<div class="flex items-center justify-between gap-2 mb-2">
											<h3 class="text-xl font-medium dark:text-gray-400">
												{{str()->limit($product->name, 30)}}
											</h3>
										</div>
										<p class="text-lg ">
											<span class="text-green-600 dark:text-green-600">Rp. {{number_format($product->price, 0,'','.')}}</span>
										</p>
									</div>
									<div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
										
										{{--										@dd($product['id'],$carts)--}}
										
										
										<button wire:click.prevent="addToCart({{$product->id}})"
										        class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
											     class="w-4 h-4 bi bi-cart3 " viewBox="0 0 16 16">
												<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
											</svg>
											<span wire:loading.remove
											      wire:target="addToCart({{$product->id}})">Add to Cart</span><span wire:loading
											                                                                        wire:target="addToCart({{$product->id}})">Adding...</span>
										</button>
									
									</div>
								</div>
							</div>
						@endforeach
					
					
					</div>
					<!-- pagination start -->
					<div class="flex justify-end mt-6">
						{{$products->links()}}
						{{--						<nav aria-label="page-navigation">--}}
						{{--							<ul class="flex list-style-none">--}}
						{{--								<li class="page-item disabled ">--}}
						{{--									<a href="#"--}}
						{{--									   class="relative block pointer-events-none px-3 py-1.5 mr-3 text-base text-gray-700 transition-all duration-300  rounded-md dark:text-gray-400 hover:text-gray-100 hover:bg-blue-600">Previous--}}
						{{--									</a>--}}
						{{--								</li>--}}
						{{--								<li class="page-item ">--}}
						{{--									<a href="#"--}}
						{{--									   class="relative block px-3 py-1.5 mr-3 text-base hover:text-blue-700 transition-all duration-300 hover:bg-blue-200 dark:hover:text-gray-400 dark:hover:bg-gray-700 rounded-md text-gray-100 bg-blue-400">1--}}
						{{--									</a>--}}
						{{--								</li>--}}
						{{--								<li class="page-item ">--}}
						{{--									<a href="#"--}}
						{{--									   class="relative block px-3 py-1.5 text-base text-gray-700 transition-all duration-300 dark:text-gray-400 dark:hover:bg-gray-700 hover:bg-blue-100 rounded-md mr-3  ">2--}}
						{{--									</a>--}}
						{{--								</li>--}}
						{{--								<li class="page-item ">--}}
						{{--									<a href="#"--}}
						{{--									   class="relative block px-3 py-1.5 text-base text-gray-700 transition-all duration-300 dark:text-gray-400 dark:hover:bg-gray-700 hover:bg-blue-100 rounded-md mr-3 ">3--}}
						{{--									</a>--}}
						{{--								</li>--}}
						{{--								<li class="page-item ">--}}
						{{--									<a href="#"--}}
						{{--									   class="relative block px-3 py-1.5 text-base text-gray-700 transition-all duration-300 dark:text-gray-400 dark:hover:bg-gray-700 hover:bg-blue-100 rounded-md ">Next--}}
						{{--									</a>--}}
						{{--								</li>--}}
						{{--							</ul>--}}
						{{--						</nav>--}}
					</div>
					<!-- pagination end -->
				</div>
			</div>
		</div>
	</section>

</div>
