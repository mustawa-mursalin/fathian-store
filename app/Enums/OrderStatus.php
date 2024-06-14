<?php
	
	namespace App\Enums;
	
	use Filament\Support\Contracts\HasColor;
	use Filament\Support\Contracts\HasIcon;
	use Filament\Support\Contracts\HasLabel;
	
	enum OrderStatus implements HasLabel, HasColor, HasIcon
	{
		case NEW;
		case PROCESSING;
		case COMPLETE;
		case CANCELED;
		
		public function getLabel() : string
		{
			return match ($this) {
				self::NEW        => 'New',
				self::PROCESSING => 'Processing',
				self::COMPLETE   => 'Complete',
				self::CANCELED   => 'Canceled',
			};
		}
		
		public function getColor() : string
		{
			return match ($this) {
				self::NEW        => 'info',
				self::PROCESSING => 'warning',
				self::COMPLETE   => 'success',
				self::CANCELED   => 'danger',
			};
		}
		
		public function getIcon() : string
		{
			return match ($this) {
				self::NEW        => 'heroicon-m-sparkles',
				self::PROCESSING => 'heroicon-m-arrow-path',
				self::COMPLETE   => 'heroicon-m-check-badge',
				self::CANCELED   => 'heroicon-m-x',
			};
		}
	}
