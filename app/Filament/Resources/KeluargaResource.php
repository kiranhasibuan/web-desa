<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeluargaResource\Pages;
use App\Models\Keluarga;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Cache;

class KeluargaResource extends Resource
{
    protected static ?string $model = Keluarga::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Data Keluarga';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Data Bakukele';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Keluarga::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('nama_kk')
                    ->label('Kepala Keluarga')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nomor_kk')
                    ->label('Nomor Kartu Keluarga')
                    ->badge()
                    ->alignment('center'),
                // TextColumn::make('ang_kel_count')
                //     ->label('Jumlah Anggota Keluarga')
                //     ->counts('angKel')
                //     ->badge()
                //     ->sortable()
                //     ->alignment('center'),
                TextColumn::make('alamat')
                    ->label('Alamat'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->button()->outlined(),
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
            'index' => Pages\ListKeluargas::route('/'),
            'create' => Pages\CreateKeluarga::route('/create'),
            'edit' => Pages\EditKeluarga::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return true;
    }
    public static function canDelete($record): bool
    {
        return false;
    }
    public static function canDeleteAny(): bool
    {
        return false;
    }
}
