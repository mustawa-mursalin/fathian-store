<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Support\Facades\Storage;
	
	class Brand extends Model
	{
		protected $fillable = [
			'name',
			'slug',
			'image',
			'is_active',
		];
		
		protected function casts() : array
		{
			return [
				'is_active' => 'boolean',
			];
		}
		
		protected static function booted() : void
		{
			static::deleting(function (Brand $brand) {
				if (!empty($brand->image)) {
					Storage::delete('public/' . $brand->image);
				}
			});
			
			static::updating(function (Brand $brand) {
				$originalImage = $brand->getOriginal('image');
				
				if ($originalImage && $originalImage != $brand->image) {
					Storage::delete('public/' . $originalImage);
				}
			});
		}
		
		public function products() : HasMany
		{
			return $this->hasMany(Product::class);
		}
	}
