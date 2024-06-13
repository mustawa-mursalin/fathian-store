<?php
	
	namespace App\Filament\Resources;
	
	use App\Filament\Resources\CategoryResource\Pages;
	use App\Filament\Resources\CategoryResource\RelationManagers;
	use App\Models\Category;
	use Filament\Forms;
	use Filament\Forms\Form;
	use Filament\Forms\Set;
	use Filament\Resources\Resource;
	use Filament\Tables;
	use Filament\Tables\Table;
	
	class CategoryResource extends Resource
	{
		protected static ?string $model = Category::class;
		
		protected static ?string $navigationIcon = 'heroicon-o-tag';
		
		public static function form(Form $form) : Form
		{
			return $form
				->schema([
					Forms\Components\Section::make([
						Forms\Components\Grid::make()
							->schema([
								Forms\Components\TextInput::make('name')
									->required()
									->maxLength(255)
									->live(onBlur : true)
									->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', str($state)->slug()->toString()) : null),
								Forms\Components\TextInput::make('slug')
									->required()
									->dehydrated()
									->maxLength(255),
							]),
						Forms\Components\FileUpload::make('image')
							->image()
							->directory('categories'),
						Forms\Components\Toggle::make('is_active')
							->default(true)
							->required(),
					])
				]);
		}
		
		public static function table(Table $table) : Table
		{
			return $table
				->columns([
					Tables\Columns\TextColumn::make('name')
						->searchable(),
					Tables\Columns\TextColumn::make('slug')
						->searchable(),
					Tables\Columns\ImageColumn::make('image'),
					Tables\Columns\IconColumn::make('is_active')
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
					//
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
		
		public static function getPages() : array
		{
			return [
				'index' => Pages\ManageCategories::route('/'),
			];
		}
	}
