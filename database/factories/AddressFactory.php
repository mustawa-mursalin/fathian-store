<?php
	
	namespace Database\Factories;
	
	use App\Models\Address;
	use App\Models\Order;
	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Carbon;
	
	class AddressFactory extends Factory
	{
		protected $model = Address::class;
		
		public function definition()
		{
			return [
				'created_at'     => Carbon::now(),
				'updated_at'     => Carbon::now(),
				'first_name'     => $this->faker->firstName(),
				'last_name'      => $this->faker->lastName(),
				'phone'          => $this->faker->phoneNumber(),
				'street_address' => $this->faker->address(),
				'province'       => $this->faker->word(),
				'city'           => $this->faker->city(),
				'district'       => $this->faker->word(),
				'village'        => $this->faker->word(),
				'zip_code'       => $this->faker->postcode(),
				
				'order_id' => Order::factory(),
			];
		}
	}
