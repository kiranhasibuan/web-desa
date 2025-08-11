<?php

namespace App\Filament\Pages;

use App\Models\ProfilDesa as ProfilDesaModel;
use App\Models\StrukturPemerintahan;
use App\Models\PetaWilayah;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;

class ProfilDesa extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Profil Desa';
    protected static ?string $title = 'Profil Desa';
    protected static string $view = 'filament.pages.profil-desa';

    public ?array $data = [];
    public $record;
    public $activeTab = 'profil';

    public function mount(): void
    {
        $this->record = ProfilDesaModel::first();

        if ($this->record) {
            $this->form->fill($this->record->toArray());
        } else {
            $this->form->fill([]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('ProfilDesaTabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informasi Dasar')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('Data Administratif')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_desa')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Nama Desa'),
                                        Forms\Components\TextInput::make('nama_kecamatan')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Nama Kecamatan'),
                                        Forms\Components\TextInput::make('nama_kabupaten')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Nama Kabupaten'),
                                        Forms\Components\TextInput::make('nama_provinsi')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Nama Provinsi'),
                                        Forms\Components\TextInput::make('kode_pos')
                                            ->maxLength(10)
                                            ->numeric()
                                            ->label('Kode Pos'),
                                    ])->columns(2),

                                Forms\Components\Section::make('Profil Desa')
                                    ->schema([
                                        Forms\Components\RichEditor::make('tentang_desa')
                                            ->required()
                                            ->label('Tentang Desa')
                                            ->toolbarButtons([
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'codeBlock',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->columnSpanFull(),
                                        Forms\Components\RichEditor::make('visi')
                                            ->required()
                                            ->label('Visi Desa')
                                            ->toolbarButtons([
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->columnSpanFull(),
                                        Forms\Components\RichEditor::make('misi')
                                            ->required()
                                            ->label('Misi Desa')
                                            ->toolbarButtons([
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Kepala Desa')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                Forms\Components\Section::make('Informasi Kepala Desa')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_kepdes')
                                            // ->required()
                                            ->maxLength(255)
                                            ->label('Nama Kepala Desa')
                                            ->placeholder('Masukkan nama lengkap kepala desa'),

                                        Forms\Components\SpatieMediaLibraryFileUpload::make('foto_kepdes')
                                            ->collection('foto_kepdes')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '1:1',
                                                '4:3',
                                                '16:9',
                                            ])
                                            ->maxSize(2048)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                                            ->label('Foto Kepala Desa')
                                            ->helperText('Maksimal 2MB, format: JPG, PNG, WEBP')
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('sambutan_kepdes')
                                            // ->required()
                                            ->label('Sambutan Kepala Desa')
                                            ->rows(6)
                                            ->placeholder('Masukkan sambutan dari kepala desa...')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Data Geografis')
                            ->icon('heroicon-o-map')
                            ->schema([
                                Forms\Components\Section::make('Luas dan Jarak')
                                    ->schema([
                                        Forms\Components\TextInput::make('luas_wilayah')
                                            ->numeric()
                                            ->step(0.01)
                                            ->suffix('km²')
                                            ->label('Luas Wilayah')
                                            ->placeholder('0.00'),
                                        Forms\Components\TextInput::make('persen_luas_kec')
                                            ->numeric()
                                            ->step(0.01)
                                            ->suffix('%')
                                            ->label('Persentase Terhadap Luas Kecamatan')
                                            ->placeholder('0.00'),
                                        Forms\Components\TextInput::make('jarak_kec')
                                            ->numeric()
                                            ->suffix('km')
                                            ->label('Jarak ke Ibukota Kecamatan')
                                            ->placeholder('0'),
                                        Forms\Components\TextInput::make('jarak_kab')
                                            ->numeric()
                                            ->suffix('km')
                                            ->label('Jarak ke Ibukota Kabupaten')
                                            ->placeholder('0'),
                                    ])->columns(2),

                                Forms\Components\Section::make('Batas Wilayah')
                                    ->schema([
                                        Forms\Components\TextInput::make('batas_utara')
                                            ->maxLength(255)
                                            ->label('Batas Utara')
                                            ->placeholder('Sebelah utara berbatasan dengan...'),
                                        Forms\Components\TextInput::make('batas_selatan')
                                            ->maxLength(255)
                                            ->label('Batas Selatan')
                                            ->placeholder('Sebelah selatan berbatasan dengan...'),
                                        Forms\Components\TextInput::make('batas_timur')
                                            ->maxLength(255)
                                            ->label('Batas Timur')
                                            ->placeholder('Sebelah timur berbatasan dengan...'),
                                        Forms\Components\TextInput::make('batas_barat')
                                            ->maxLength(255)
                                            ->label('Batas Barat')
                                            ->placeholder('Sebelah barat berbatasan dengan...'),
                                    ])->columns(2),

                                Forms\Components\Section::make('Koordinat')
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->numeric()
                                            ->step(0.00000001)
                                            ->label('Latitude')
                                            ->placeholder('Contoh: -5.12345678')
                                            ->helperText('Koordinat latitude titik pusat desa'),
                                        Forms\Components\TextInput::make('longitude')
                                            ->numeric()
                                            ->step(0.00000001)
                                            ->label('Longitude')
                                            ->placeholder('Contoh: 131.12345678')
                                            ->helperText('Koordinat longitude titik pusat desa'),
                                    ])->columns(2),

                                Forms\Components\Section::make('Polygon Wilayah')
                                    ->schema([
                                        Forms\Components\Textarea::make('koordinat_polygon')
                                            ->label('Koordinat Polygon (JSON)')
                                            ->placeholder('Contoh: [{"lat": -5.1234, "lng": 131.1234}, {"lat": -5.1235, "lng": 131.1235}]')
                                            ->helperText('Masukkan koordinat dalam format JSON untuk membuat polygon batas wilayah desa')
                                            ->rows(8)
                                            ->columnSpanFull()
                                            // ->rules(['json'])
                                            // ->validationMessages([
                                            //     'json' => 'Format koordinat harus berupa JSON yang valid',
                                            // ])
                                            ->disabled(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString()
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Profil Desa')
                ->submit('save')
                ->size('lg')
                ->color('primary')
                ->icon('heroicon-o-check')
                ->keyBindings(['mod+s'])
                ->extraAttributes([
                    'class' => 'ml-auto',
                ]),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            // Validasi dan format koordinat_polygon jika ada
            if (!empty($data['koordinat_polygon'])) {
                $koordinat = json_decode($data['koordinat_polygon'], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Format koordinat polygon tidak valid. Pastikan format JSON benar.');
                }
                $data['koordinat_polygon'] = json_encode($koordinat);
            }

            if ($this->record) {
                $this->record->update($data);
                $message = 'Profil Desa berhasil diperbarui.';
            } else {
                $this->record = ProfilDesaModel::create($data);
                $message = 'Profil Desa berhasil disimpan.';
            }

            Notification::make()
                ->title('Berhasil!')
                ->body($message)
                ->success()
                ->duration(5000)
                ->send();

            // Refresh form dengan data terbaru
            $this->form->fill($this->record->toArray());
        } catch (\Exception $e) {
            Notification::make()
                ->title('Terjadi Kesalahan!')
                ->body('Gagal menyimpan data: ' . $e->getMessage())
                ->danger()
                ->duration(8000)
                ->send();
        }
    }

    public function getTitle(): string
    {
        return $this->record ? "Profil Desa {$this->record->nama_desa}" : 'Profil Desa';
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    // Method untuk mendapatkan data statistik
    public function getStatistics(): array
    {
        if (!$this->record) {
            return [];
        }

        return [
            'Luas Wilayah' => $this->record->luas_wilayah ? number_format($this->record->luas_wilayah, 2) . ' km²' : 'Belum diisi',
            'Persentase Kecamatan' => $this->record->persen_luas_kec ? number_format($this->record->persen_luas_kec, 2) . '%' : 'Belum diisi',
            'Jarak ke Kecamatan' => $this->record->jarak_kec ? $this->record->jarak_kec . ' km' : 'Belum diisi',
            'Jarak ke Kabupaten' => $this->record->jarak_kab ? $this->record->jarak_kab . ' km' : 'Belum diisi',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Preview Website')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn() => url('/'))
                ->openUrlInNewTab()
                ->visible(fn() => $this->record !== null),
        ];
    }
}
