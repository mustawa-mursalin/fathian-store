<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	return new class extends Migration {
		public function up()
		{
			Schema::create('order_details', function (Blueprint $table) {
				$table->id();
				$table->foreignId('order_id')->constrained()->cascadeOnDelete();
				$table->foreignId('product_id')->constrained()->cascadeOnDelete();
				$table->integer('quantity')->default(1);
				$table->decimal('unit_amount', 8, 2)->nullable();
				$table->decimal('total_amount', 8, 2)->nullable();
				$table->timestamps();
			});
		}
		
		public function down()
		{
			Schema::dropIfExists('order_details');
		}
	};
