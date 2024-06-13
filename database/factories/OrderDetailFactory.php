<?php
	
	namespace Database\Factories;
	
	use App\Models\Order;
	use App\Models\OrderDetail;
	use App\Models\Product;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Carbon;
	
	class OrderDetailFactory extends Factory
	{
		protected $model = OrderDetail::class;
		
		public function definition()
		{
			return [
				'created_at'   => Carbon::now(),
				'updated_at'   => Carbon::now(),
				'quantity'     => $this->faker->randomNumber(),
				'unit_amount'  => $this->faker->randomFloat(),
				'total_amount' => $this->faker->randomFloat(),
				
				'order_id'   => Order::factory(),
				'product_id' => Product::factory(),
			];
		}
	}
