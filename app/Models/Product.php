<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	
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
	}
