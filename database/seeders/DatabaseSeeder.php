<?php
	
	namespace Database\Seeders;
	
	use App\Models\Brand;
	use App\Models\Category;
	use App\Models\Product;
	use App\Models\User;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Str;
	
	// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
	
	class DatabaseSeeder extends Seeder
	{
		/**
		 * Seed the application's database.
		 */
		public function run() : void
		{
			
			// User::factory(10)->create();
			
			collect([
				'Perlengkapan Rumah Tangga',
				'Handphone & Aksesoris',
				'Peralatan Masak',
				'Perawatan & Kecantikan',
				'Aksesoris Fashion',
				'Jam Tangan',
				'Buku & Alat Tulis',
				'Komputer & Aksesoris',
			])->each(fn($category) => Category::query()->create(['name' => $category, 'slug' => Str::slug($category), 'is_active' => true]));
			
			collect([
				'Tidak Ada Merek',
				'Apple',
				'Samsung',
				'Xiaomi',
				'Vivo',
				'Oppo',
				'Realme',
				'OnePlus',
			])->each(fn($brand) => Brand::query()->create(['name' => $brand, 'slug' => Str::slug($brand), 'is_active' => true]));
			
			
			User::factory()->create([
				'name'              => 'Administrator',
				'email'             => 'admin@fs.com',
				'email_verified_at' => now(),
				'password'          => bcrypt('password'),
				'remember_token'    => Str::random(10),
			]);
			
			Product::factory(50)->create();
		}
	}
