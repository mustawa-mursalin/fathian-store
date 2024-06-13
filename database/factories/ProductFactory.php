<?php
	
	namespace Database\Factories;
	
	use App\Models\Product;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Carbon;
	use Illuminate\Support\Str;
	
	class ProductFactory extends Factory
	{
		protected $model = Product::class;
		
		public function definition()
		{
			$name = $this->faker->sentence();
			return [
				'name'        => $name,
				'slug'        => Str::slug($name),
				'sku'         => $this->faker->unique()->bothify('SKU########'),
				'description' => $this->faker->text(),
				'cost_price'  => $costPrice = $this->faker->numberBetween(10000, 100000),
				'price'       => $costPrice + ($costPrice * (20 / 100)),
				'is_active'   => rand(true, false),
				'is_featured' => rand(true, false),
				'in_stock'    => rand(true, false),
				'on_sale'     => rand(true, false),
				'created_at'  => Carbon::now(),
				'updated_at'  => Carbon::now(),
				
				'category_id' => rand(1, 8),
				'brand_id'    => rand(1, 8),
			];
		}
	}
