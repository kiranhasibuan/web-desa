<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StrukturPemerintahanResource\Pages;
use App\Models\StrukturPemerintahan;
use App\Models\ProfilDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StrukturPemerintahanResource extends Resource
{
    protected static ?string $model = StrukturPemerintahan::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Struktur Pemerintahan';

    protected static ?string $pluralLabel = 'Struktur Pemerintahan';

    protected static ?string $slug = 'struktur-pemerintahan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\Select::make('profil_desa_id')
                            ->label('Profil Desa')
                            ->options(ProfilDesa::all()->pluck('nama_desa', 'id'))
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Lengkap'),
                        Forms\Components\TextInput::make('jabatan')
                            ->required()
                            ->maxLength(255)
                            ->label('Jabatan'),
                        Forms\Components\TextInput::make('nip')
                            ->maxLength(255)
                            ->label('NIP')
                            ->placeholder('Opsional'),
                    ])->columns(2),

                Forms\Components\Section::make('Data Personal')
                    ->schema([
                        Forms\Components\Select::make('pendidikan_terakhir')
                            ->options([
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA' => 'SMA',
                                'D3' => 'D3',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                            ])
                            ->label('Pendidikan Terakhir'),
                        Forms\Components\TextInput::make('no_telepon')
                            ->tel()
                            ->maxLength(255)
                            ->label('No. Telepon'),
                        Forms\Components\Textarea::make('alamat')
                            ->maxLength(500)
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('struktur-pemerintahan')
                            ->label('Foto')
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper(),
                        Forms\Components\Toggle::make('status_aktif')
                            ->default(true)
                            ->label('Status Aktif'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular()
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('profilDesa.nama_desa')
                    ->label('Desa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable()
                    ->sortable()
                    ->label('Jabatan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Kepala Desa' => 'success',
                        'Sekretaris Desa' => 'warning',
                        'Kepala Urusan' => 'info',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable()
                    ->label('NIP')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir')
                    ->badge()
                    ->label('Pendidikan')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('no_telepon')
                    ->label('No. Telepon')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('status_aktif')
                    ->boolean()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('profil_desa_id')
                    ->label('Desa')
                    ->options(ProfilDesa::all()->pluck('nama_desa', 'id')),
                Tables\Filters\SelectFilter::make('jabatan')
                    ->options([
                        'Kepala Desa' => 'Kepala Desa',
                        'Sekretaris Desa' => 'Sekretaris Desa',
                        'Kepala Urusan' => 'Kepala Urusan',
                        'Staf' => 'Staf',
                    ]),
                Tables\Filters\SelectFilter::make('pendidikan_terakhir')
                    ->options([
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'D3' => 'D3',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                    ]),
                Tables\Filters\TernaryFilter::make('status_aktif')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStrukturPemerintahans::route('/'),
            'create' => Pages\CreateStrukturPemerintahan::route('/create'),
            // 'view' => Pages\ViewStrukturPemerintahan::route('/{record}'),
            'edit' => Pages\EditStrukturPemerintahan::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
