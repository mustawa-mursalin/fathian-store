<?php
	
	namespace App\Filament\Resources;
	
	use App\Filament\Resources\ProductResource\Pages;
	use App\Filament\Resources\ProductResource\RelationManagers;
	use App\Models\Product;
	use Filament\Forms;
	use Filament\Forms\Form;
	use Filament\Forms\Set;
	use Filament\Resources\Resource;
	use Filament\Support\RawJs;
	use Filament\Tables;
	use Filament\Tables\Table;
	
	class ProductResource extends Resource
	{
		protected static ?string $model = Product::class;
		
		protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
		
		public static function form(Form $form) : Form
		{
			return $form
				->schema([
					Forms\Components\Group::make()->schema([
						Forms\Components\Fieldset::make('Product Information')->schema([
							Forms\Components\TextInput::make('name')
								->label('Product Name')
								->required()
								->maxLength(255)
								->live(500)
								->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', str($state)->slug()->toString()) : null)
								->columnSpanFull(),
							Forms\Components\TextInput::make('slug')
								->required()
								->readOnly()
								->dehydrated()
								->unique(Product::class, 'slug', ignoreRecord : true)
								->maxLength(255),
							Forms\Components\TextInput::make('sku')
								->label('SKU')
								->unique(Product::class, 'sku', ignoreRecord : true)
								->default(generateSequentialNumber(Product::class, 'SKU-', 'sku'))
								->required()
								->readOnly(),
							Forms\Components\MarkdownEditor::make('description')
								->columnSpanFull()
								->fileAttachmentsDirectory('products'),
						]),
						Forms\Components\Fieldset::make('Product Images')->schema([
							Forms\Components\FileUpload::make('images')
								->label('')
								->multiple()
								->directory('products')
								->maxFiles(5)
								->reorderable()->columnSpanFull(),
						])
					])->columnSpan(2),
					Forms\Components\Group::make()->schema([
						Forms\Components\Fieldset::make('Product Price')->schema([
							Forms\Components\TextInput::make('cost_price')
								->mask(RawJs::make('$money($input)'))
								->prefix('Rp')
								->required()->columnSpanFull(),
							Forms\Components\TextInput::make('price')
								->mask(RawJs::make('$money($input)'))
								->prefix('Rp')
								->live(500)
								->required()->columnSpanFull(),
						]),
						Forms\Components\Fieldset::make('Product Associations')->schema([
							Forms\Components\Select::make('category_id')
								->relationship('category', 'name')
								->searchable()
								->preload()
								->required()
								->native(false)->columnSpanFull(),
							Forms\Components\Select::make('brand_id')
								->relationship('brand', 'name')
								->searchable()
								->preload()
								->required()
								->native(false)->columnSpanFull(),
						]),
						Forms\Components\Fieldset::make('Product Status')->schema([
							Forms\Components\Toggle::make('is_active')
								->default(true)
								->required(),
							Forms\Components\Toggle::make('is_featured')
								->default(false)
								->required(),
							Forms\Components\Toggle::make('in_stock')
								->default(true)
								->required(),
							Forms\Components\Toggle::make('on_sale')
								->default(false)
								->required(),
						])
					])->columnSpan(1),
				])->columns(3);
		}
		
		public static function table(Table $table) : Table
		{
			return $table
				->defaultSort('created_at', 'desc')
				->columns([
					Tables\Columns\ImageColumn::make('images')->circular(),
					Tables\Columns\TextColumn::make('name')->limit(25)->searchable(),
					Tables\Columns\TextColumn::make('category.name'),
					Tables\Columns\TextColumn::make('brand.name'),
					
					Tables\Columns\TextColumn::make('price')
						->numeric()
						->prefix('Rp ')
						->sortable(),
					Tables\Columns\IconColumn::make('is_active')
						->boolean(),
					Tables\Columns\IconColumn::make('is_featured')
						->boolean(),
					Tables\Columns\IconColumn::make('in_stock')
						->boolean(),
					Tables\Columns\IconColumn::make('on_sale')
						->boolean(),
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
					Tables\Filters\SelectFilter::make('category')
						->relationship('category', 'name')
						->native(false),
					Tables\Filters\SelectFilter::make('brand')
						->relationship('brand', 'name')
						->native(false),
				])
				->actions([
					Tables\Actions\ActionGroup::make([
						Tables\Actions\ViewAction::make(),
						Tables\Actions\EditAction::make(),
						Tables\Actions\DeleteAction::make(),
					])
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
		
		public static function getPages() : array
		{
			return [
				'index'  => Pages\ListProducts::route('/'),
				'create' => Pages\CreateProduct::route('/create'),
				'edit'   => Pages\EditProduct::route('/{record}/edit'),
			];
		}
	}
