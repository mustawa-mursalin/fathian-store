<?php
	
	namespace App\Enums;
	
	enum PaymentStatus
	{
		case PENDING;
		case CONFIRMED;
		case SHIPPED;
		case DELIVERED;
		case CANCELED;
		
		public function label() : string
		{
			return match ($this) {
				self::PENDING   => 'Pending',
				self::CONFIRMED => 'Confirmed',
				self::SHIPPED   => 'Shipped',
				self::DELIVERED => 'Delivered',
				self::CANCELED  => 'Canceled',
			};
		}
	}
