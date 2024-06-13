<?php
	
	namespace App\Models;
	
	use App\Enums\OrderStatus;
	use App\Enums\PaymentMethod;
	use App\Enums\PaymentStatus;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	
	class Order extends Model
	{
		use HasFactory;
		
		protected $fillable = [
			'user_id',
			'order_number',
			'grand_total',
			'discount',
			'profit',
			'payment_method',
			'payment_status',
			'status',
			'shipping_amount',
			'shipping_method',
			'notes',
		];
		
		protected function casts() : array
		{
			return [
				'payment_method' => PaymentMethod::class,
				'payment_status' => PaymentStatus::class,
				'status'         => OrderStatus::class,
			];
		}
		
		public function user() : BelongsTo
		{
			return $this->belongsTo(User::class);
		}
		
		public function items() : HasMany
		{
			return $this->hasMany(OrderDetail::class);
		}
		
		public function address() : HasOne
		{
			return $this->hasOne(Address::class);
		}
	}
