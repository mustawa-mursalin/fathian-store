<?php
	
	namespace App\Filament\Resources;
	
	use App\Enums\OrderStatus;
	use App\Filament\Resources\OrderResource\Pages;
	use App\Filament\Resources\OrderResource\RelationManagers;
	use App\Models\Order;
	use Filament\Forms;
	use Filament\Forms\Form;
	use Filament\Resources\Resource;
	use Filament\Tables;
	use Filament\Tables\Table;
	
	class OrderResource extends Resource
	{
		protected static ?string $model = Order::class;
		
		protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
		
		public static function form(Form $form) : Form
		{
			return $form
				->schema([
					Forms\Components\Select::make('user_id')
						->relationship('user', 'name')
						->required(),
					Forms\Components\TextInput::make('order_number')
						->required()
						->maxLength(255),
					Forms\Components\TextInput::make('grand_total')
						->numeric(),
					Forms\Components\TextInput::make('discount')
						->numeric(),
					Forms\Components\TextInput::make('profit')
						->numeric(),
					Forms\Components\TextInput::make('payment_method')
						->maxLength(255),
					Forms\Components\TextInput::make('payment_status')
						->maxLength(255),
					Forms\Components\TextInput::make('status')
						->required()
						->maxLength(255),
					Forms\Components\TextInput::make('shipping_amount')
						->numeric(),
					Forms\Components\TextInput::make('shipping_method')
						->maxLength(255),
					Forms\Components\Textarea::make('notes')
						->columnSpanFull(),
				]);
		}
		
		public static function table(Table $table) : Table
		{
			return $table
				->columns([
					Tables\Columns\TextColumn::make('user.name')
						->numeric()
						->sortable(),
					Tables\Columns\TextColumn::make('order_number')
						->searchable(),
					Tables\Columns\TextColumn::make('grand_total')
						->numeric()
						->sortable(),
					Tables\Columns\TextColumn::make('discount')
						->numeric()
						->sortable(),
					Tables\Columns\TextColumn::make('profit')
						->numeric()
						->sortable(),
					Tables\Columns\TextColumn::make('payment_method')
						->searchable(),
					Tables\Columns\TextColumn::make('payment_status')
						->searchable(),
					Tables\Columns\TextColumn::make('status')
						->searchable(),
					Tables\Columns\TextColumn::make('shipping_amount')
						->numeric()
						->sortable(),
					Tables\Columns\TextColumn::make('shipping_method')
						->searchable(),
					Tables\Columns\TextColumn::make('created_at')
						->dateTime()
						->sortable()
						->toggleable(isToggledHiddenByDefault : true),
					Tables\Columns\TextColumn::make('updated_at')
						->dateTime()
						->sortable()
						->toggleable(isToggledHiddenByDefault : true),
				])
				->filters([
					//
				])
				->actions([
					Tables\Actions\EditAction::make(),
				])
				->bulkActions([
					Tables\Actions\BulkActionGroup::make([
						Tables\Actions\DeleteBulkAction::make(),
					]),
				]);
		}
		
		public static function getRelations() : array
		{
			return [
				//
			];
		}
		
		public static function getNavigationBadge() : ?string
		{
			$count = static::getModel()::where('status', OrderStatus::NEW)->count();
			return $count ? (string)$count : null;
		}
		
		public static function getPages() : array
		{
			return [
				'index'  => Pages\ListOrders::route('/'),
				'create' => Pages\CreateOrder::route('/create'),
				'edit'   => Pages\EditOrder::route('/{record}/edit'),
			];
		}
	}
