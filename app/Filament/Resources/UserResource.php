<?php
	
	namespace App\Filament\Resources;
	
	use App\Filament\Resources\UserResource\Pages;
	use App\Filament\Resources\UserResource\RelationManagers;
	use App\Models\User;
	use Filament\Forms;
	use Filament\Forms\Form;
	use Filament\Pages\Page;
	use Filament\Resources\Pages\CreateRecord;
	use Filament\Resources\Resource;
	use Filament\Tables;
	use Filament\Tables\Table;
	
	class UserResource extends Resource
	{
		protected static ?string $model = User::class;
		
		protected static ?string $navigationIcon = 'heroicon-o-user-group';
		
		public static function form(Form $form) : Form
		{
			return $form
				->schema([
					Forms\Components\TextInput::make('name')
						->label('Nama User')
						->required()
						->maxLength(255),
					Forms\Components\TextInput::make('email')
						->label('Alamat Email')
						->email()
						->required()
						->maxLength(255)
						->unique(ignoreRecord : true),
					Forms\Components\DateTimePicker::make('email_verified_at')
						->label('Tanggal Verifikasi Email')
						->default(now()),
					Forms\Components\TextInput::make('password')
						->password()
						->dehydrated(fn($state) => filled($state))
						->required(fn(Page $livewire) : bool => $livewire instanceof CreateRecord)
						->maxLength(255),
				]);
		}
		
		public static function table(Table $table) : Table
		{
			return $table
				->columns([
					Tables\Columns\TextColumn::make('name')
						->label('Nama Lengkap')
						->searchable(),
					Tables\Columns\TextColumn::make('email')
						->label('Alamat E-Mail')
						->searchable(),
					Tables\Columns\TextColumn::make('email_verified_at')
						->dateTime()
						->sortable(),
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
					]),
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
				'index'  => Pages\ListUsers::route('/'),
				'create' => Pages\CreateUser::route('/create'),
				'edit'   => Pages\EditUser::route('/{record}/edit'),
			];
		}
	}
