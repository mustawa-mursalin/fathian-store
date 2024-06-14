<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Support\Facades\Storage;
	
	class Category extends Model
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
		
		public function products() : HasMany
		{
			return $this->hasMany(Product::class);
		}
		
		protected static function booted() : void
		{
			static::deleting(function (Category $category) {
				if (!empty($category->image)) {
					Storage::delete('public/' . $category->image);
				}
			});
			
			static::updating(function (Category $category) {
				$originalImage = $category->getOriginal('image');
				
				if ($originalImage && $originalImage != $category->image) {
					Storage::delete('public/' . $originalImage);
				}
			});
		}
	}
