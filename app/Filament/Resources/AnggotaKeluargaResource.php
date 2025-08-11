<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaKeluargaResource\Pages;
use App\Models\AnggotaKeluarga;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class AnggotaKeluargaResource extends Resource
{
    protected static ?string $model = AnggotaKeluarga::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Data Bakukele';
    protected static ?string $navigationLabel = 'Data Anggota Keluarga';
    protected static ?string $modelLabel = 'Data Anggota Keluarga';
    protected static ?string $pluralModelLabel = 'Data Anggota Keluarga';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->copyable()
                    ->tooltip('Klik untuk copy')
                    ->formatStateUsing(function ($state) {
                        if (in_array($state, ['9998', '9999'])) {
                            return $state === '9998' ? 'NIK tidak diketahui' : 'NIK tidak ada';
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('hubungan_label')
                    ->label('Hubungan')
                    ->badge()
                    ->colors([
                        'primary' => 'Kepala keluarga',
                        'success' => 'Istri/Suami',
                        'warning' => 'Anak',
                        'info' => 'Cucu',
                        'secondary' => fn($state) => !in_array($state, ['Kepala keluarga', 'Istri/Suami', 'Anak', 'Cucu'])
                    ]),
                Tables\Columns\IconColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->boolean()
                    ->trueIcon('heroicon-o-user')
                    ->falseIcon('heroicon-o-user')
                    ->trueColor('info')
                    ->falseColor('danger')
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d M Y')
                    ->sortable()
                    ->description(function ($record) {
                        if ($record->tanggal_lahir) {
                            $umur = $record->tanggal_lahir->age;
                            return "{$umur} tahun";
                        }
                        return null;
                    }),
                Tables\Columns\TextColumn::make('ijazah_label')
                    ->label('Pendidikan')
                    ->badge()
                    ->colors([
                        'danger' => 'Tidak punya ijazah',
                        'warning' => ['SD/sederajat', 'SMP/sederajat'],
                        'info' => 'SMA/sederajat',
                        'success' => ['Diploma(D1/D2/D3)', 'D4/S1', 'S2/S3'],
                    ]),
                Tables\Columns\BooleanColumn::make('bekerja')
                    ->label('Bekerja')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('secondary'),
                Tables\Columns\BadgeColumn::make('keberadaan')
                    ->label('Status')
                    ->colors([
                        'primary' => 'ada',
                        'warning' => 'pindah_kk',
                        'danger' => 'meninggal',
                        'secondary' => 'pindah',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst(str_replace('_', ' ', $state))),
                Tables\Columns\TextColumn::make('nama_kk')
                    ->label('Kepala Keluarga')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('agama_label')
                    ->label('Agama')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status_kawin_label')
                    ->label('Status Kawin')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('hubungan')
                    ->label('Hubungan Keluarga')
                    ->options([
                        '1' => 'Kepala keluarga',
                        '2' => 'Istri/Suami',
                        '3' => 'Anak',
                        '4' => 'Menantu',
                        '5' => 'Cucu',
                        '6' => 'Orang tua/mertua',
                        '7' => 'Pembantu',
                        '8' => 'Famili lain',
                        '9' => 'Lainnya'
                    ]),
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        true => 'Laki-laki',
                        false => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('keberadaan')
                    ->label('Status Keberadaan')
                    ->options([
                        'ada' => 'Ada',
                        'pindah_kk' => 'Pindah KK',
                        'meninggal' => 'Meninggal',
                        'pindah' => 'Pindah',
                    ]),
                Tables\Filters\TernaryFilter::make('bekerja')
                    ->label('Status Bekerja')
                    ->placeholder('Semua status')
                    ->trueLabel('Bekerja')
                    ->falseLabel('Tidak bekerja'),
                Tables\Filters\SelectFilter::make('ijazah')
                    ->label('Pendidikan')
                    ->options([
                        0 => 'Tidak punya ijazah',
                        1 => 'SD/sederajat',
                        2 => 'SMP/sederajat',
                        3 => 'SMA/sederajat',
                        4 => 'Diploma(D1/D2/D3)',
                        5 => 'D4/S1',
                        6 => 'S2/S3'
                    ]),
                Tables\Filters\Filter::make('umur')
                    ->form([
                        TextInput::make('min_umur')
                            ->label('Umur Minimum')
                            ->numeric(),
                        TextInput::make('max_umur')
                            ->label('Umur Maksimum')
                            ->numeric(),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['min_umur'], function ($q) use ($data) {
                                $q->whereDate('tanggal_lahir', '<=', now()->subYears($data['min_umur']));
                            })
                            ->when($data['max_umur'], function ($q) use ($data) {
                                $q->whereDate('tanggal_lahir', '>=', now()->subYears($data['max_umur'] + 1));
                            });
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('refresh')
                    ->label('Refresh Data')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->action(function () {
                        // Clear all related caches
                        Cache::forget('anggota_keluarga_api_data');
                        cache()->forget('sushi.App\Models\AnggotaKeluarga.rows');

                        Notification::make()
                            ->title('Data berhasil diperbarui')
                            ->body('Data anggota keluarga telah dimuat ulang dari bakukele.site')
                            ->success()
                            ->duration(3000)
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Refresh Data Anggota Keluarga')
                    ->modalDescription('Apakah Anda yakin ingin memuat ulang data dari bakukele.site? Proses ini mungkin memakan waktu beberapa detik.')
                    ->modalSubmitActionLabel('Ya, Refresh'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Detail'),
            ])
            ->defaultSort('nama')
            ->striped()
            ->emptyStateHeading('Tidak ada data anggota keluarga')
            ->emptyStateDescription('Data anggota keluarga akan muncul di sini setelah berhasil diambil dari bakukele.site. Pastikan koneksi internet stabil dan API token valid.')
            ->emptyStateIcon('heroicon-o-users')
            ->emptyStateActions([
                Tables\Actions\Action::make('refresh')
                    ->label('Coba Lagi')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->action(function () {
                        Cache::forget('anggota_keluarga_api_data');
                        cache()->forget('sushi.App\Models\AnggotaKeluarga.rows');

                        Notification::make()
                            ->title('Mencoba memuat data...')
                            ->info()
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAnggotaKeluargas::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
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
