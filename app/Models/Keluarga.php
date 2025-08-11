<?php

namespace App\Models;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Unique;
use Sushi\Sushi;

class Keluarga extends Model
{
    use Sushi;

    protected $guarded = ['id', 'id_desa'];
    protected $sushiShouldCache = true;
    protected $sushiCacheReapAfter = 3600;

    public const LABELS = [
        'status_tempat' => [
            1 => 'Milik sendiri',
            2 => 'Kontrak/sewa',
            3 => 'Bebas sewa',
            4 => 'Dinas',
            5 => 'Lainnya'
        ],
        'jenis_lantai' => [
            1 => 'Marmer/granit',
            2 => 'Keramik',
            3 => 'Parket/vinil/permadani',
            4 => 'Ubin/tegel/teraso',
            5 => 'Kayu/papan kualitas tinggi',
            6 => 'Semen/batu merah',
            7 => 'Bambu',
            8 => 'Kayu/papan kualitas rendah',
            9 => 'Tanah',
            10 => 'Lainnya'
        ],
        'jenis_dinding' => [
            1 => 'Tembok',
            2 => 'Plesteran anyaman bambu/kawat',
            3 => 'Kayu',
            4 => 'Anyaman bambu',
            5 => 'Batang kayu',
            6 => 'Bambu',
            7 => 'Lainnya'
        ],
        'jenis_atap' => [
            1 => 'Beton/genteng beton',
            2 => 'Genteng keramik',
            3 => 'Genteng metal',
            4 => 'Genteng tanah liat',
            5 => 'Asbes',
            6 => 'Seng',
            7 => 'Sirap',
            8 => 'Bambu',
            9 => 'Rumbia/ijuk/daun daunan',
            10 => 'Lainnya'
        ]
    ];

    public function getRows()
    {

        $page = 1;
        $perPage = 100;
        $url = env('BAKUKELE_API_URL') . '/keluargas';
        $params = [
            'filter[id_desa]' => env('DESA_ID', '8105030093'),
            'per_page' => $perPage,
            'page' => $page,
        ];

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('BAKUKELE_API_TOKEN'),
                'Accept' => 'application/json',
            ])
            ->get($url, $params);

        $responseData = $response->json();

        return $responseData['data'] ?? [];
    }
    // public function getRows()
    // {
    //     return Cache::remember('keluarga_api_data_' . env('DESA_ID'), 3600, function () {
    //         try {
    //             Log::info('Fetching Keluarga data from API', [
    //                 'url' => env('BAKUKELE_API_URL') . '/keluargas',
    //                 'desa_id' => env('DESA_ID')
    //             ]);

    //             $allData = [];
    //             $page = 1;
    //             $perPage = 100;
    //             $maxPages = 50; // Safety limit untuk prevent infinite loop

    //             do {
    //                 $url = env('BAKUKELE_API_URL') . '/keluargas';
    //                 $params = [
    //                     'filter[id_desa]' => env('DESA_ID', '8105030093'),
    //                     'per_page' => $perPage,
    //                     'page' => $page,
    //                 ];

    //                 Log::info("API Request Page {$page}", [
    //                     'url' => $url,
    //                     'params' => $params
    //                 ]);

    //                 $response = Http::timeout(30)
    //                     ->withHeaders([
    //                         'Authorization' => 'Bearer ' . env('BAKUKELE_API_TOKEN'),
    //                         'Accept' => 'application/json',
    //                     ])
    //                     ->get($url, $params);

    //                 // Log response status
    //                 Log::info("API Response Page {$page}", [
    //                     'status' => $response->status(),
    //                     'success' => $response->successful()
    //                 ]);

    //                 if (!$response->successful()) {
    //                     Log::error('Failed to fetch Keluarga data from API', [
    //                         'status' => $response->status(),
    //                         'headers' => $response->headers(),
    //                         'body' => $response->body(),
    //                         'url' => $url,
    //                         'params' => $params
    //                     ]);
    //                     break;
    //                 }

    //                 $responseData = $response->json();

    //                 // Log structure response untuk debug
    //                 if ($page === 1) {
    //                     Log::info('API Response Structure', [
    //                         'keys' => array_keys($responseData),
    //                         'data_count' => isset($responseData['data']) ? count($responseData['data']) : 0,
    //                         'sample_item' => isset($responseData['data'][0]) ? array_keys($responseData['data'][0]) : []
    //                     ]);
    //                 }

    //                 // Handle different response structures
    //                 $currentPageData = [];
    //                 if (isset($responseData['data'])) {
    //                     $currentPageData = $responseData['data'];
    //                 } elseif (is_array($responseData)) {
    //                     $currentPageData = $responseData;
    //                 }

    //                 $allData = array_merge($allData, $currentPageData);

    //                 $page++;

    //                 // Safety check
    //                 if ($page > $maxPages) {
    //                     Log::warning('Max pages limit reached', ['max_pages' => $maxPages]);
    //                     break;
    //                 }
    //             } while (count($currentPageData) == $perPage);

    //             Log::info('Successfully fetched Keluarga data', [
    //                 'total_records' => count($allData),
    //                 'total_pages' => $page - 1
    //             ]);

    //             return $allData;
    //         } catch (\Exception $e) {
    //             Log::error('Error fetching Keluarga data from API', [
    //                 'message' => $e->getMessage(),
    //                 'file' => $e->getFile(),
    //                 'line' => $e->getLine(),
    //                 'trace' => $e->getTraceAsString()
    //             ]);

    //             // Return empty array instead of dd() untuk production
    //             return [];
    //         }
    //     });
    // }

    private function getLabel(string $type, $value): string
    {
        return self::LABELS[$type][$value] ?? 'Tidak diketahui';
    }

    // Label attributes using helper method
    public function getStatusTempatLabelAttribute(): string
    {
        return $this->getLabel('status_tempat', $this->status_tempat);
    }
    public function getJenisLantaiLabelAttribute(): string
    {
        return $this->getLabel('jenis_lantai', $this->jenis_lantai);
    }
    public function getJenisDindingLabelAttribute(): string
    {
        return $this->getLabel('jenis_dinding', $this->jenis_dinding);
    }
    public function getJenisAtapLabelAttribute(): string
    {
        return $this->getLabel('jenis_atap', $this->jenis_atap);
    }

    // Relationships
    public function angKel()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'id_keluarga', 'id');
    }

    /**
     * Method untuk clear cache manual
     */
    public static function clearApiCache(): void
    {
        $cacheKey = 'keluarga_api_data_' . env('DESA_ID');
        Cache::forget($cacheKey);
        cache()->forget('sushi.App\Models\Keluarga.rows');

        Log::info('Keluarga API cache cleared', ['cache_key' => $cacheKey]);
    }

    /**
     * Method untuk test API connection
     */
    public static function testApiConnection(): array
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('BAKUKELE_API_TOKEN'),
                    'Accept' => 'application/json',
                ])
                ->get(env('BAKUKELE_API_URL') . '/keluargas', [
                    'per_page' => 1
                ]);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'response' => $response->json(),
                'url' => env('BAKUKELE_API_URL') . '/keluargas'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'url' => env('BAKUKELE_API_URL') . '/keluargas'
            ];
        }
    }

    public static function getForm()
    {
        return [
            Wizard::make([
                self::getIdentificationStep(),
                self::getHouseStep(),
                self::getAssetStep(),
            ])->skippable()->columnSpanFull(),
        ];
    }

    private static function getIdentificationStep()
    {
        return Wizard\Step::make('PENGENALAN TEMPAT')
            ->description('Jika Keluarga tidak punya Kartu Keluarga')
            ->icon('heroicon-m-map-pin')
            ->schema([
                TextInput::make('id_desa')
                    ->label('Desa')
                    ->default(fn(): string => ucwords(strtolower(auth()->user()->desa->nama)))
                    ->live()->dehydrated(false)->readOnly(),
                TextInput::make('nama_kk')
                    ->label('Nama Kepala Keluarga')
                    ->afterStateUpdated(fn($component, $state) => $component->state(ucwords($state)))
                    ->required(),
                TextInput::make('nama_krt')
                    ->label('Nama Kepala Rumah Tangga')
                    ->afterStateUpdated(fn($component, $state) => $component->state(ucwords($state))),
                TextInput::make('nomor_kk')
                    ->label('Nomor Kartu Keluarga')
                    ->helperText('Ketik 9998 jika KK Hilang, atau 9999 jika tidak memiliki KK.')
                    ->numeric()
                    ->mask(RawJs::make("$input.startsWith('999') ? '9999' : '9999999999999999'"))
                    ->unique(modifyRuleUsing: fn(Unique $rule) => $rule->whereNot('nomor_kk', [9998, 9999]), ignoreRecord: true)
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->live(),
            ])->columns(['sm' => 1, 'md' => 2, 'lg' => 3]);
    }

    private static function getHouseStep()
    {
        return Wizard\Step::make('KETERANGAN RUMAH')
            ->icon('heroicon-m-home')
            ->schema([
                Section::make('RUMAH')->schema([
                    Select::make('status_tempat')
                        ->label('Status Kepemilikan Tempat Tinggal')
                        ->native(false)->required()->live()
                        ->options(array_map(fn($v, $k) => "$k. $v", self::LABELS['status_tempat'], array_keys(self::LABELS['status_tempat']))),

                    Select::make('status_bangunan')
                        ->label('Status Lahan Bangunan')
                        ->native(false)
                        ->visible(fn(Get $get): bool => $get('status_tempat') == 1)
                        ->required(fn(Get $get): bool => $get('status_tempat') == 1)
                        ->options([
                            1 => '1. Milik sendiri',
                            2 => '2. Milik orang lain',
                            3 => '3. Tanah negara',
                            4 => '4. Lainnya',
                        ]),

                    Select::make('jenis_lantai')
                        ->label('Jenis Lantai')->native(false)->required()
                        ->options(array_map(fn($v, $k) => "$k. $v", self::LABELS['jenis_lantai'], array_keys(self::LABELS['jenis_lantai']))),

                    TextInput::make('luas_lantai')
                        ->label('Luas lantai (m²)')->numeric()->required()
                        ->minValue(10)->maxValue(10000),

                    TextInput::make('jlh_kamar')
                        ->label('Jumlah Kamar Tidur')->numeric()->required()
                        ->minValue(0)->maxValue(20),
                ])->columns(3),

                self::getUtilitiesSection(),
                self::getWaterSanitationSection(),

                ToggleButtons::make('kumuh')
                    ->label('Pemukiman Kumuh?')
                    ->boolean()->grouped()->required()->columnSpanFull(),
            ]);
    }

    private static function getUtilitiesSection()
    {
        return Section::make('UTILITAS')->schema([
            Select::make('listrik')
                ->label('Sumber Penerangan')
                ->native(false)->live()->required()->columnSpanFull()
                ->options([
                    1 => '1. Listrik PLN dengan meteran',
                    2 => '2. Listrik PLN tanpa meteran',
                    3 => '3. Listrik Non-PLN',
                    4 => '4. Bukan listrik',
                ]),

            ...collect(['daya1', 'daya2', 'daya3'])->map(
                fn($field) =>
                Select::make($field)
                    ->label(ucfirst($field))
                    ->native(false)
                    ->visible(fn(Get $get): bool => $get('listrik') == 1)
                    ->required(fn(Get $get): bool => $get('listrik') == 1 && $field === 'daya1')
                    ->options([
                        1 => '1. 450 watt',
                        2 => '2. 900 watt',
                        3 => '3. 1.300 watt',
                        4 => '4. 2.200 watt',
                        5 => '5. ≥2.200 watt',
                    ])
            )->toArray(),

            Select::make('bahan_bakar')
                ->label('Bahan Bakar untuk Memasak')
                ->native(false)->live()->required()->columnSpanFull()
                ->afterStateUpdated(fn(Set $set, ?string $state) =>
                in_array($state, ['2', '3']) ? $set('aset_tabungGas', true) : null)
                ->options([
                    1 => '1. Listrik',
                    2 => '2. Gas 5,5kg/blue gaz',
                    3 => '3. Gas 12 kg',
                    4 => '4. Gas 3kg',
                    5 => '5. Gas kota/meteran PGN',
                    6 => '6. Biogas',
                    7 => '7. Minyak tanah',
                    8 => '8. Briket',
                    9 => '9. Arang',
                    10 => '10. Kayu bakar',
                    11 => '11. Lainnya',
                ]),
        ])->columns(3);
    }

    private static function getWaterSanitationSection()
    {
        $waterOptions = [
            1 => '1. Air kemasan bermerk',
            2 => '2. Air isi ulang',
            3 => '3. Leding',
            4 => '4. Leding tanpa meteran',
            5 => '5. Sumur bor/pompa',
            6 => '6. Sumur terlindung',
            7 => '7. Sumur tak terlindung',
            8 => '8. Mata air terlindung',
            9 => '9. Mata air tak terlindung',
            10 => '10. Air Permukaan',
            11 => '11. Air hujan',
            12 => '12. Lainnya',
        ];

        return Section::make('AIR BERSIH DAN SANITASI')->schema([
            Select::make('sumber_airMinum')
                ->label('Sumber Air Minum')->native(false)->live()->required()
                ->options($waterOptions),

            Select::make('sumber_airCuci')
                ->label('Sumber Air Mandi/Cuci')->native(false)->required()
                ->options($waterOptions),

            Select::make('kepemilikan_sanitasi')
                ->label('Kepemilikan Tempat BAB')->native(false)->live()->required()
                ->options([
                    1 => '1. Ada, keluarga sendiri',
                    2 => '2. Ada, keluarga tertentu',
                    3 => '3. Ada, MCK komunal',
                    4 => '4. Ada, MCK umum',
                    5 => '5. Ada, tidak digunakan',
                ]),

            Select::make('tempat_sampah')
                ->label('Tempat Membuang Sampah')->native(false)->required()->columnSpanFull()
                ->options([
                    1 => '1. Tempat sampah, diangkut',
                    2 => '2. Lubang/dibakar',
                    3 => '3. Sungai/laut',
                    4 => '4. Drainase',
                    5 => '5. Lainnya',
                ]),
        ])->columns(3);
    }

    private static function getAssetStep()
    {
        return Wizard\Step::make('KEPEMILIKAN ASET')
            ->icon('heroicon-m-currency-dollar')
            ->schema([
                Section::make('ASET BERGERAK')->schema([
                    ...collect([
                        'aset_tabungGas' => 'Tabung gas 5,5 kg+',
                        'aset_kulkas' => 'Lemari es/kulkas',
                        'aset_ac' => 'AC',
                        'aset_televisi' => 'Televisi',
                        'aset_smartphone' => 'Smartphone',
                        'aset_sepedaMotor' => 'Sepeda Motor',
                        'aset_mobil' => 'Mobil',
                    ])->map(
                        fn($label, $field) =>
                        ToggleButtons::make($field)
                            ->label($label)->boolean()->grouped()->required()
                            ->live($field === 'aset_televisi')
                    )->toArray(),

                    TextInput::make('jlh_noHp')
                        ->label('Jumlah HP Aktif')->numeric()->required()
                        ->minValue(0)->maxValue(20),
                ])->columns(3),

                Section::make('ASET TIDAK BERGERAK')->schema([
                    ToggleButtons::make('aset_lahan')
                        ->label('Lahan')->boolean()->grouped()->live()->required(),

                    TextInput::make('luas_lahan')
                        ->label('Luas Lahan (m²)')->numeric()
                        ->visible(fn(Get $get): bool => $get('aset_lahan'))
                        ->required(fn(Get $get): bool => $get('aset_lahan'))
                        ->minValue(1)->maxValue(10000),
                ])->columns(3),

                Section::make('HEWAN TERNAK')->schema([
                    ...collect(['sapi', 'kerbau', 'kambing', 'babi'])->map(
                        fn($animal) =>
                        TextInput::make("ternak_{$animal}")
                            ->label("Jumlah " . ucfirst($animal))
                            ->numeric()->minValue(0)->maxValue(100)
                    )->toArray(),
                ])->columns(3),
            ]);
    }
}
