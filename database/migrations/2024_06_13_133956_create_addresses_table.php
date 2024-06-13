<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	return new class extends Migration {
		public function up()
		{
			Schema::create('addresses', function (Blueprint $table) {
				$table->id();
				$table->foreignId('order_id')->constrained()->cascadeOnDelete();
				$table->string('first_name')->nullable();
				$table->string('last_name')->nullable();
				$table->string('phone')->nullable();
				$table->text('street_address')->nullable();
				$table->string('province')->nullable();
				$table->string('city')->nullable();
				$table->string('district')->nullable();
				$table->string('village')->nullable();
				$table->string('zip_code')->nullable();
				$table->timestamps();
			});
		}
		
		public function down()
		{
			Schema::dropIfExists('addresses');
		}
	};
