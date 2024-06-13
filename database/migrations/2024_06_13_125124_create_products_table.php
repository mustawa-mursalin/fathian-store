<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	return new class extends Migration {
		public function up()
		{
			Schema::create('products', function (Blueprint $table) {
				$table->id();
				$table->foreignId('category_id')->constrained()->cascadeOnDelete();
				$table->foreignId('brand_id')->constrained()->cascadeOnDelete();
				$table->string('name');
				$table->string('slug')->unique();
				$table->string('sku')->unique();
				$table->json('images')->nullable();
				$table->longText('description')->nullable();
				$table->decimal('cost_price', 8, 2);
				$table->decimal('price', 8, 2);
				$table->boolean('is_active')->default(true);
				$table->boolean('is_featured')->default(false);
				$table->boolean('in_stock')->default(true);
				$table->boolean('on_sale')->default(false);
				$table->timestamps();
			});
		}
		
		public function down()
		{
			Schema::dropIfExists('products');
		}
	};
