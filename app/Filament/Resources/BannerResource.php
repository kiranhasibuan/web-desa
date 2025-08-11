<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Banner';

    protected static ?string $pluralLabel = 'Banner';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Banner')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('kategori')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Hero, Promo, Event')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('urutan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(1)
                            ->columnSpan(1),

                        Forms\Components\RichEditor::make('deskripsi')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('aktif')
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media Banner')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('banner')
                            ->collection('banner')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '2:1',
                            ])
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(10240) // 5MB
                            ->helperText('Upload gambar banner. Format yang diterima: JPEG, PNG, WebP. Maksimal 5MB.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('banner')
                    ->collection('banner')
                    ->conversion('thumb')
                    ->size(80)
                    ->circular(false)
                    ->label('Gambar'),

                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('kategori')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'hero' => 'success',
                        'promo' => 'warning',
                        'event' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('urutan')
                    ->sortable()
                    ->alignCenter()
                    ->label('Urutan'),

                Tables\Columns\ToggleColumn::make('aktif')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diupdate'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options(fn() => Banner::distinct('kategori')->pluck('kategori', 'kategori')->toArray())
                    ->searchable(),

                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('aktivasi')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each->update(['aktif' => true]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('nonaktivasi')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn($records) => $records->each->update(['aktif' => false]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('urutan', 'asc')
            ->reorderable('urutan')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['media']);
    }
}
