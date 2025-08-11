<?php

namespace App\Filament\Pages\Setting;

use App\Settings\SiteSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;

use function Filament\Support\is_app_url;

class ManageSite extends SettingsPage
{
    use HasPageShield;
    protected static string $settings = SiteSettings::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $settings = app(static::getSettings());

        $data = $this->mutateFormDataBeforeFill($settings->toArray());

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->description('Konfigurasi umum website')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\Toggle::make('is_maintenance')
                                ->label('Mode Pemeliharaan')
                                ->helperText('Ketika diaktifkan, situs Anda akan menampilkan halaman pemeliharaan kepada pengunjung')
                                ->required(),
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Situs')
                                ->required()
                                ->maxLength(100),
                            Forms\Components\TextInput::make('tagline')
                                ->label('Tagline Situs')
                                ->helperText('Frasa singkat yang menggambarkan situs Anda')
                                ->maxLength(150),
                            Forms\Components\Textarea::make('description')
                                ->label('Deskripsi Situs')
                                ->helperText('Deskripsi lengkap tentang website Anda')
                                ->rows(3)
                                ->maxLength(500),
                        ])->columns(2),
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Situs')
                            ->image()
                            ->directory('sites')
                            ->visibility('public')
                            ->imagePreviewHeight('100')
                            ->maxSize(1024)
                            ->helperText('Ukuran yang direkomendasikan: 200x50 piksel'),
                    ]),

                Forms\Components\Section::make('Informasi Desa')
                    ->description('Detail kontak dan informasi lokasi')
                    ->icon('heroicon-o-building-office')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('company_name')
                                ->label('Nama Desa')
                                ->required()
                                ->maxLength(100),
                            Forms\Components\TextInput::make('company_email')
                                ->label('Email Desa')
                                ->email()
                                ->required()
                                ->maxLength(100),
                            Forms\Components\TextInput::make('company_phone')
                                ->label('Telepon Desa')
                                ->tel()
                                ->maxLength(20),
                            Forms\Components\Textarea::make('company_address')
                                ->label('Alamat Desa')
                                ->rows(2)
                                ->maxLength(200),
                        ])->columns(2),
                    ]),

                Forms\Components\Section::make('Pengaturan Regional')
                    ->description('Pengaturan bahasa dan waktu')
                    ->icon('heroicon-o-globe-alt')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\Select::make('default_language')
                                ->label('Bahasa Default')
                                ->options([
                                    'id' => 'Bahasa Indonesia',
                                    'en' => 'English',
                                    'fr' => 'French',
                                    'es' => 'Spanish',
                                    'de' => 'German',
                                    'it' => 'Italian',
                                    'pt' => 'Portuguese',
                                    'ru' => 'Russian',
                                    'zh' => 'Chinese',
                                    'ja' => 'Japanese',
                                    'ar' => 'Arabic',
                                ])
                                // ->searchable()
                                // ->native(false)
                                ->required(),
                            Forms\Components\Select::make('timezone')
                                ->label('Zona Waktu')
                                ->options(function () {
                                    $timezones = [];
                                    foreach (timezone_identifiers_list() as $timezone) {
                                        $timezones[$timezone] = $timezone;
                                    }
                                    return $timezones;
                                })
                                ->searchable()
                                ->required(),
                        ])->columns(2),
                    ]),

                Forms\Components\Section::make('Informasi Legal')
                    ->description('Hak cipta dan URL halaman legal')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('copyright_text')
                                ->label('Teks Hak Cipta')
                                ->maxLength(200),
                            Forms\Components\TextInput::make('terms_url')
                                ->label('URL Syarat & Ketentuan')
                                ->maxLength(100)
                                ->prefix(function (Forms\Get $get) {
                                    return url('/');
                                }),
                            Forms\Components\TextInput::make('privacy_url')
                                ->label('URL Kebijakan Privasi')
                                ->maxLength(100)
                                ->prefix(function (Forms\Get $get) {
                                    return url('/');
                                }),
                            Forms\Components\TextInput::make('cookie_policy_url')
                                ->label('URL Kebijakan Cookie')
                                ->maxLength(100)
                                ->prefix(function (Forms\Get $get) {
                                    return url('/');
                                }),
                        ])->columns(2),
                    ]),

                Forms\Components\Section::make('Pesan Error')
                    ->description('Pesan error khusus untuk website Anda')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\Textarea::make('custom_404_message')
                                ->label('Pesan 404 Tidak Ditemukan')
                                ->rows(2)
                                ->maxLength(500),
                            Forms\Components\Textarea::make('custom_500_message')
                                ->label('Pesan 500 Server Error')
                                ->rows(2)
                                ->maxLength(500),
                        ])->columns(2),
                    ]),
            ])
            ->columns(3)
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->mutateFormDataBeforeSave($this->form->getState());

            $settings = app(static::getSettings());

            $settings->fill($data);
            $settings->save();

            Notification::make()
                ->title('Pengaturan berhasil disimpan!')
                ->body('Pengaturan umum situs Anda telah diperbarui.')
                ->success()
                ->send();

            $this->redirect(static::getUrl(), navigate: FilamentView::hasSpaMode() && is_app_url(static::getUrl()));
        } catch (\Throwable $th) {
            Notification::make()
                ->title('Error menyimpan pengaturan')
                ->body($th->getMessage())
                ->danger()
                ->send();

            throw $th;
        }
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.sites");
    }

    public static function getNavigationLabel(): string
    {
        return 'Pengaturan';
    }

    public function getTitle(): string|Htmlable
    {
        return 'Pengaturan Situs';
    }

    public function getHeading(): string|Htmlable
    {
        return 'Pengaturan Situs';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Kelola konfigurasi umum website Anda';
    }
}
