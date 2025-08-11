<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;
use Illuminate\Support\Arr;

class AnggotaKeluarga extends Model
{
    use Sushi;

    protected $table = 'anggota_keluargas';

    protected $fillable = [
        'id',
        'id_keluarga',
        'nama',
        'nik',
        'hubungan',
        'hubungan_label',
        'jenis_kelamin',
        'jenis_kelamin_label',
        'tanggal_lahir',
        'kartu_identitas',
        'gol_darah',
        'agama',
        'status_kawin',
        'status_sekolah',
        'ijazah',
        'bekerja',
        'id_lapus',
        'status_kerja',
        'status_gizi',
        'kontrasepsi',
        'jenis_kontrasepsi',
        'keberadaan',
        'nama_kk',
        'alamat_keluarga',
        'lapangan_usaha',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'jenis_kelamin' => 'boolean',
        'bekerja' => 'boolean',
        'kontrasepsi' => 'boolean',
        'kartu_identitas' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'gol_darah' => 'integer',
        'agama' => 'integer',
        'status_kawin' => 'integer',
        'status_sekolah' => 'integer',
        'ijazah' => 'integer',
        'status_kerja' => 'integer',
        'status_gizi' => 'integer',
        'jenis_kontrasepsi' => 'integer',
    ];

    protected $sushiShouldCache = true;
    protected $sushiCacheReapAfter = 3600;

    public const LABELS = [
        'agama' => [
            1 => 'Islam',
            2 => 'Protestan',
            3 => 'Katolik',
            4 => 'Hindu',
            5 => 'Budha',
            6 => 'Konghucu',
            7 => 'Pengahayat kepercayaan',
            8 => 'Lainnya'
        ],
        'hubungan' => [
            1 => 'Kepala keluarga',
            2 => 'Istri/Suami',
            3 => 'Anak',
            4 => 'Menantu',
            5 => 'Cucu',
            6 => 'Orang tua/mertua',
            7 => 'Pembantu',
            8 => 'Famili lain',
            9 => 'Lainnya'
        ],
        'ijazah' => [
            0 => 'Tidak punya ijazah',
            1 => 'SD/sederajat',
            2 => 'SMP/sederajat',
            3 => 'SMA/sederajat',
            4 => 'Diploma(D1/D2/D3)',
            5 => 'D4/S1',
            6 => 'S2/S3'
        ],
        'status_kawin' => [
            1 => 'Belum kawin',
            2 => 'Kawin/nikah',
            3 => 'Cerai hidup',
            4 => 'Cerai mati'
        ],
        'gol_darah' => [
            1 => 'A',
            2 => 'B',
            3 => 'AB',
            4 => 'O',
            5 => 'Tidak tahu'
        ],
        'status_sekolah' => [
            1 => 'Tidak/belum pernah sekolah',
            2 => 'Masih sekolah',
            3 => 'Tidak bersekolah lagi'
        ],
        'status_kerja' => [
            1 => 'Berusaha sendiri',
            2 => 'Berusaha dibantu buruh tidak tetap/tidak dibayar',
            3 => 'Berusaha dibantu buruh tetap/dibayar',
            4 => 'Buruh/karyawan/pegawai swasta',
            5 => 'ASN/TNI/Polri/BUMN/BUMD',
            6 => 'Pekerja bebas pertanian',
            7 => 'Pekerja bebas non-pertanian',
            8 => 'Pekerja keluarga/tidak dibayar'
        ],
        'status_gizi' => [
            1 => 'Kurang Gizi (wasting)',
            2 => 'Kerding (stunting)',
            3 => 'Tidak ada isian',
            4 => 'Tidak tahu'
        ],
        'jenis_kontrasepsi' => [
            1 => 'MOW/Tubektomi/Sterilisasi Wanita',
            2 => 'MOP/Vasektomi/Sterilisasi Pria',
            3 => 'AKDR/IUD/Spiral',
            4 => 'Suntikan KB',
            5 => 'Pil KB',
            6 => 'Kondom Pria/Karet KB',
            7 => 'Metode menyusui alami',
            8 => 'Pantang/Metode kalender',
            9 => 'Lainnya'
        ],
        'keberadaan' => [
            'ada' => 'Ada',
            'pindah_kk' => 'Pindah KK',
            'meninggal' => 'Meninggal',
            'pindah' => 'Pindah'
        ]
    ];

    public function getRows(): array
    {
        $perPage = 100;
        $maxPages = 100;
        $url = env('BAKUKELE_API_URL') . '/anggota-keluargas';
        $allData = [];
        $retryCount = 0;
        $maxRetries = 3;

        for ($page = 1; $page <= $maxPages; $page++) {
            $params = [
                'filter[id_desa]' => env('DESA_ID', '8105030093'),
                'per_page' => $perPage,
                'page' => $page,
            ];

            $response = $this->makeApiRequest($url, $params);

            if (!$response) {
                if ($retryCount < $maxRetries) {
                    $retryCount++;
                    $page--; // Retry the same page
                    sleep(1); // Wait before retry
                    continue;
                }
                break;
            }

            $responseData = $response->json();
            $data = $this->transformData($responseData['data'] ?? []);

            if (empty($data)) {
                break; // No more data
            }

            $allData = array_merge($allData, $data);
            $retryCount = 0; // Reset retry count on successful request
        }

        return $allData;
    }

    private function makeApiRequest(string $url, array $params)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('BAKUKELE_API_TOKEN'),
                    'Accept' => 'application/json',
                ])
                ->get($url, $params);

            if ($response->successful()) {
                return $response;
            }

            Log::error('API request failed', [
                'url' => $url,
                'params' => $params,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API request exception', [
                'url' => $url,
                'params' => $params,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    private function transformData(array $items): array
    {
        $allowedFields = [
            'id',
            'id_keluarga',
            'nama',
            'nik',
            'hubungan',
            'jenis_kelamin',
            'tanggal_lahir',
            'kartu_identitas',
            'gol_darah',
            'agama',
            'status_kawin',
            'status_sekolah',
            'ijazah',
            'bekerja',
            'id_lapus',
            'status_kerja',
            'status_gizi',
            'kontrasepsi',
            'jenis_kontrasepsi',
            'keberadaan',
            'lapangan_usaha',
            'created_at',
            'updated_at'
        ];

        return Arr::map($items, function ($item) use ($allowedFields) {
            // Transform array fields to JSON
            $item['kartu_identitas'] = isset($item['kartu_identitas']) ? json_encode($item['kartu_identitas']) : null;
            $item['lapangan_usaha'] = isset($item['lapangan_usaha']) ? json_encode($item['lapangan_usaha']) : null;

            return Arr::only($item, $allowedFields);
        });
    }

    private function getLabel(string $type, $value): string
    {
        return self::LABELS[$type][$value] ?? 'Tidak diketahui';
    }

    // Label attributes using helper method
    public function getAgamaLabelAttribute(): string
    {
        return $this->getLabel('agama', $this->agama);
    }
    public function getHubunganLabelAttribute(): string
    {
        return $this->getLabel('hubungan', $this->hubungan);
    }
    public function getIjazahLabelAttribute(): string
    {
        return $this->getLabel('ijazah', $this->ijazah);
    }
    public function getStatusKawinLabelAttribute(): string
    {
        return $this->getLabel('status_kawin', $this->status_kawin);
    }
    public function getGolDarahLabelAttribute(): string
    {
        return $this->getLabel('gol_darah', $this->gol_darah);
    }
    public function getStatusSekolahLabelAttribute(): string
    {
        return $this->getLabel('status_sekolah', $this->status_sekolah);
    }
    public function getStatusKerjaLabelAttribute(): string
    {
        return $this->getLabel('status_kerja', $this->status_kerja);
    }
    public function getStatusGiziLabelAttribute(): string
    {
        return $this->getLabel('status_gizi', $this->status_gizi);
    }
    public function getJenisKontrasepsiLabelAttribute(): string
    {
        return $this->getLabel('jenis_kontrasepsi', $this->jenis_kontrasepsi);
    }
    public function getKeberadaanLabelAttribute(): string
    {
        return $this->getLabel('keberadaan', $this->keberadaan);
    }

    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir?->age;
    }

    public function getKartuIdentitasLabelAttribute(): string
    {
        if (!is_array($this->kartu_identitas)) return 'Tidak ada';

        $kartuLabels = [
            'akta_kelahiran' => 'Akta Kelahiran',
            'kia' => 'Kartu Identitas Anak (KIA)',
            'ktp' => 'Kartu Tanda Penduduk (KTP)'
        ];

        $kartuTersedia = array_map(fn($kartu) => $kartuLabels[$kartu] ?? null, $this->kartu_identitas);
        $kartuTersedia = array_filter($kartuTersedia);

        return empty($kartuTersedia) ? 'Tidak ada' : implode(', ', $kartuTersedia);
    }

    // Relationships
    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'id_keluarga');
    }

    /**
     * Method untuk clear cache manual
     */
    public static function clearApiCache(): void
    {
        $cacheKey = 'anggota_keluarga_api_data_' . env('DESA_ID');
        Cache::forget($cacheKey);
        cache()->forget('sushi.App\Models\AnggotaKeluarga.rows');

        Log::info('AnggotaKeluarga API cache cleared', ['cache_key' => $cacheKey]);
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
                ->get(env('BAKUKELE_API_URL') . '/anggota-keluargas', [
                    'per_page' => 1
                ]);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'response' => $response->json(),
                'url' => env('BAKUKELE_API_URL') . '/anggota-keluargas'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'url' => env('BAKUKELE_API_URL') . '/anggota-keluargas'
            ];
        }
    }

    // Scopes
    public function scopeAda($query)
    {
        return $query->where('keberadaan', 'ada');
    }
    public function scopeLakiLaki($query)
    {
        return $query->where('jenis_kelamin', true);
    }
    public function scopePerempuan($query)
    {
        return $query->where('jenis_kelamin', false);
    }

    public function scopeUsia($query, $min = null, $max = null)
    {
        if ($min !== null) $query->whereDate('tanggal_lahir', '<=', now()->subYears($min));
        if ($max !== null) $query->whereDate('tanggal_lahir', '>=', now()->subYears($max + 1));
        return $query;
    }
}
