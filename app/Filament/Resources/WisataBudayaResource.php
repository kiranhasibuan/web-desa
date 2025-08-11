<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WisataBudayaResource\Pages;
use App\Models\WisataBudaya;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class WisataBudayaResource extends Resource
{
    protected static ?string $model = WisataBudaya::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Wisata Budaya';

    protected static ?string $pluralModelLabel = 'Wisata Budaya';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\TextInput::make('nama_wisata')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('deskripsi')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('kategori')
                            ->options([
                                'wisata_alam' => 'Wisata Alam',
                                'wisata_budaya' => 'Wisata Budaya',
                                'wisata_sejarah' => 'Wisata Sejarah',
                                'wisata_kuliner' => 'Wisata Kuliner',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('lokasi')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detail Operasional')
                    ->schema([
                        Forms\Components\TextInput::make('jam_operasional')
                            ->placeholder('Contoh: 08:00 - 17:00'),

                        Forms\Components\TextInput::make('harga_tiket')
                            ->numeric()
                            ->prefix('Rp'),

                        Forms\Components\TextInput::make('kontak_person')
                            ->tel()
                            ->placeholder('Nomor telepon atau WhatsApp'),

                        Forms\Components\Toggle::make('status_aktif')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('foto_utama')
                            ->collection('foto_utama')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9')
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('galeri')
                            ->collection('galeri')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('foto_utama')
                    ->collection('foto_utama')
                    ->conversion('thumb')
                    ->size(60),

                Tables\Columns\TextColumn::make('nama_wisata')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->colors([
                        'success' => 'wisata_alam',
                        'warning' => 'wisata_budaya',
                        'danger' => 'wisata_sejarah',
                        'primary' => 'wisata_kuliner',
                    ]),

                Tables\Columns\TextColumn::make('harga_tiket')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\IconColumn::make('status_aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'wisata_alam' => 'Wisata Alam',
                        'wisata_budaya' => 'Wisata Budaya',
                        'wisata_sejarah' => 'Wisata Sejarah',
                        'wisata_kuliner' => 'Wisata Kuliner',
                    ]),

                Tables\Filters\TernaryFilter::make('status_aktif')
                    ->label('Status Aktif'),
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
            'index' => Pages\ListWisataBudayas::route('/'),
            'create' => Pages\CreateWisataBudaya::route('/create'),
            'edit' => Pages\EditWisataBudaya::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
