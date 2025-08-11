<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukUnggulanResource\Pages;
use App\Models\ProdukUnggulan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use TomatoPHP\FilamentMediaManager\Form\MediaManagerInput;

class ProdukUnggulanResource extends Resource
{
    protected static ?string $model = ProdukUnggulan::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationLabel = 'Produk Unggulan';

    protected static ?string $pluralModelLabel = 'Produk Unggulan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('nama_produk')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('deskripsi')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('kategori')
                            ->options([
                                'pertanian' => 'Pertanian',
                                'peternakan' => 'Peternakan',
                                'kerajinan' => 'Kerajinan',
                                'makanan' => 'Makanan',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Harga & Ketersediaan')
                    ->schema([
                        Forms\Components\TextInput::make('harga_min')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Harga Minimum'),

                        Forms\Components\TextInput::make('harga_max')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Harga Maksimum'),

                        Forms\Components\TextInput::make('satuan')
                            ->placeholder('kg, pcs, liter, dll'),

                        Forms\Components\Toggle::make('status_tersedia')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Produsen')
                    ->schema([
                        Forms\Components\TextInput::make('produsen')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('kontak_produsen')
                            ->tel()
                            ->placeholder('Nomor telepon atau WhatsApp'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('foto_produk')
                            ->collection('foto_produk')
                            ->image()
                            ->imageEditor()
                            ->acceptedFileTypes(['image/*'])
                            ->imageCropAspectRatio('1:1')
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('galeri_produk')
                            ->collection('galeri_produk')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->acceptedFileTypes(['image/*'])
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('foto_produk')
                    ->collection('foto_produk')
                    ->conversion('thumb')
                    ->size(60),

                Tables\Columns\TextColumn::make('nama_produk')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->colors([
                        'success' => 'pertanian',
                        'warning' => 'peternakan',
                        'info' => 'kerajinan',
                        'danger' => 'makanan',
                        'secondary' => 'lainnya',
                    ]),

                Tables\Columns\TextColumn::make('harga_range')
                    ->label('Rentang Harga')
                    ->getStateUsing(function ($record) {
                        if ($record->harga_min && $record->harga_max) {
                            return 'Rp ' . number_format($record->harga_min, 0, ',', '.') .
                                ' - Rp ' . number_format($record->harga_max, 0, ',', '.');
                        }
                        return $record->harga_min ? 'Rp ' . number_format($record->harga_min, 0, ',', '.') : '-';
                    }),

                Tables\Columns\TextColumn::make('produsen')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('status_tersedia')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'pertanian' => 'Pertanian',
                        'peternakan' => 'Peternakan',
                        'kerajinan' => 'Kerajinan',
                        'makanan' => 'Makanan',
                        'lainnya' => 'Lainnya',
                    ]),

                Tables\Filters\TernaryFilter::make('status_tersedia')
                    ->label('Status Tersedia'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdukUnggulans::route('/'),
            'create' => Pages\CreateProdukUnggulan::route('/create'),
            'edit' => Pages\EditProdukUnggulan::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
