<?php
	
	namespace App\Enums;
	
	use Filament\Support\Contracts\HasLabel;
	
	enum PaymentMethod implements HasLabel
	{
		case CASH;
		case BANK_TRANSFER;
		
		public function getLabel() : ?string
		{
			return match ($this) {
				self::CASH          => 'Cash',
				self::BANK_TRANSFER => 'Bank Transfer',
			};
		}
	}
