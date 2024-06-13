<?php
	
	namespace Database\Factories;
	
	use App\Models\Order;
	use App\Models\User;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Carbon;
	
	class OrderFactory extends Factory
	{
		protected $model = Order::class;
		
		public function definition()
		{
			return [
				'created_at'      => Carbon::now(),
				'updated_at'      => Carbon::now(),
				'order_number'    => $this->faker->word(),
				'grand_total'     => $this->faker->randomFloat(),
				'discount'        => $this->faker->randomFloat(),
				'profit'          => $this->faker->randomFloat(),
				'payment_method'  => $this->faker->word(),
				'payment_status'  => $this->faker->word(),
				'status'          => $this->faker->word(),
				'shipping_amount' => $this->faker->randomFloat(),
				'shipping_method' => $this->faker->word(),
				'notes'           => $this->faker->word(),
				
				'user_id' => User::factory(),
			];
		}
	}
