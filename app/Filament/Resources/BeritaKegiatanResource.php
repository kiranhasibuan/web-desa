<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaKegiatanResource\Pages;
use App\Models\BeritaKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Str;

class BeritaKegiatanResource extends Resource
{
    protected static ?string $model = BeritaKegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Berita & Kegiatan';

    protected static ?string $pluralModelLabel = 'Berita & Kegiatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konten Utama')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(string $context, $state, Forms\Set $set) =>
                                $context === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(BeritaKegiatan::class, 'slug', ignoreRecord: true),

                        Forms\Components\RichEditor::make('konten')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('kategori')
                            ->options([
                                'berita' => 'Berita',
                                'kegiatan' => 'Kegiatan',
                                'pengumuman' => 'Pengumuman',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Publikasi')
                    ->schema([
                        Forms\Components\TextInput::make('penulis')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DateTimePicker::make('tanggal_publikasi')
                            ->required()
                            ->default(now()),

                        Forms\Components\Select::make('status_publikasi')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required(),

                        Forms\Components\TextInput::make('jumlah_views')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
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

                        SpatieMediaLibraryFileUpload::make('galeri_berita')
                            ->collection('galeri_berita')
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

                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\BadgeColumn::make('kategori')
                    ->colors([
                        'primary' => 'berita',
                        'success' => 'kegiatan',
                        'warning' => 'pengumuman',
                    ]),

                Tables\Columns\BadgeColumn::make('status_publikasi')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('penulis')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_publikasi')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_views')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'berita' => 'Berita',
                        'kegiatan' => 'Kegiatan',
                        'pengumuman' => 'Pengumuman',
                    ]),

                Tables\Filters\SelectFilter::make('status_publikasi')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal_publikasi', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeritaKegiatans::route('/'),
            'create' => Pages\CreateBeritaKegiatan::route('/create'),
            'edit' => Pages\EditBeritaKegiatan::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
