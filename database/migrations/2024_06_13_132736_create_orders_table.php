<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	return new class extends Migration {
		public function up()
		{
			Schema::create('orders', function (Blueprint $table) {
				$table->id();
				$table->foreignId('user_id')->constrained()->cascadeOnDelete();
				$table->string('order_number')->unique();
				$table->decimal('grand_total', 8, 2)->nullable();
				$table->decimal('discount', 8, 2)->nullable();
				$table->decimal('profit', 8, 2)->nullable();
				$table->string('payment_method')->nullable();
				$table->string('payment_status')->nullable();
				$table->string('status');
				$table->decimal('shipping_amount', 8, 2)->nullable();
				$table->string('shipping_method')->nullable();
				$table->text('notes')->nullable();
				$table->timestamps();
			});
		}
		
		public function down()
		{
			Schema::dropIfExists('orders');
		}
	};
