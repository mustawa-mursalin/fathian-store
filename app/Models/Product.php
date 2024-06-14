<?php
	
	namespace App\Models;
	
	use Attribute;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Support\Facades\Storage;
	
	class Product extends Model
	{
		use HasFactory;
		
		protected $fillable = [
			'category_id',
			'brand_id',
			'name',
			'slug',
			'sku',
			'images',
			'description',
			'cost_price',
			'price',
			'is_active',
			'is_featured',
			'in_stock',
			'on_sale',
		];
		
		public function category() : BelongsTo
		{
			return $this->belongsTo(Category::class);
		}
		
		public function brand() : BelongsTo
		{
			return $this->belongsTo(Brand::class);
		}
		
		protected function casts() : array
		{
			return [
				'images' => 'array',
			
			];
		}
		
		public function orderDetails() : HasMany
		{
			return $this->hasMany(OrderDetail::class);
		}
		
		public function cost_price() : Attribute
		{
			return Attribute::make(
				set : fn($value) => str($value)->replace(',', '')
			);
		}
		
		public function price() : Attribute
		{
			return Attribute::make(
				set : fn($value) => str($value)->replace(',', '')
			);
		}
		
		protected static function booted() : void
		{
			static::deleted(function (Product $product) {
				// Pastikan images diubah menjadi array jika berupa JSON
				$images = $product->images;
				
				if (is_string($images)) {
					$images = json_decode($images, true);
				}
				
				// Periksa apakah images adalah array dan bukan null
				if (is_array($images)) {
					foreach ($images as $image) {
						// Hapus gambar dari storage
						Storage::delete('public/' . $image);
					}
				}
			});
			
			static::updating(function (Product $product) {
				$product->cost_price = str_replace(',', '', $product->cost_price);
				$product->price      = str_replace(',', '', $product->price);
				// Ensure that the original images and the new images are arrays
				$originalImages = $product->getOriginal('images') ?? [];
				$newImages      = $product->images ?? [];
				
				if (is_string($originalImages)) {
					$originalImages = json_decode($originalImages, true);
				}
				
				if (is_string($newImages)) {
					$newImages = json_decode($newImages, true);
				}
				
				if (is_array($originalImages) && is_array($newImages)) {
					$imagesToDelete = array_diff($originalImages, $newImages);
					
					foreach ($imagesToDelete as $image) {
						Storage::delete('public/' . $image);
					}
				}
			});
		}
	}
