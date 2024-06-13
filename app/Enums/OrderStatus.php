<?php
	
	namespace App\Enums;
	
	use Filament\Support\Contracts\HasColor;
	use Filament\Support\Contracts\HasLabel;
	
	enum OrderStatus implements HasLabel, HasColor
	{
		case PENDING;
		case CONFIRMED;
		case SHIPPED;
		case DELIVERED;
		case CANCELED;
		
		public function getLabel() : string
		{
			return match ($this) {
				self::PENDING   => 'Pending',
				self::CONFIRMED => 'Confirmed',
				self::SHIPPED   => 'Shipped',
				self::DELIVERED => 'Delivered',
				self::CANCELED  => 'Canceled',
			};
		}
		
		public function getColor() : string
		{
			return match ($this) {
				self::PENDING   => 'warning',
				self::CONFIRMED => 'success',
				self::SHIPPED   => 'success',
				self::DELIVERED => 'success',
				self::CANCELED  => 'danger',
			};
		}
	}
