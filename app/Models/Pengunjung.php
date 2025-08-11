<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Gunakan alias untuk Parser agar lebih mudah dibaca
use hisorange\BrowserDetect\Parser as Browser;
use Stevebauman\Location\Facades\Location;

class Pengunjung extends Model
{
    protected $table = 'pengunjung';
    protected $fillable = [
        'ip_address',
        'user_agent',
        'browser',
        'browser_version',
        'platform',
        'device',
        'device_type',
        'is_mobile',
        'is_tablet',
        'is_desktop',
        'is_robot',
        'halaman_dikunjungi',
        'referrer',
        'negara',
        'kota',
        'data_lokasi',
        'waktu_kunjungan',
        'durasi',
    ];

    protected $casts = [
        'data_lokasi' => 'array',
        'waktu_kunjungan' => 'datetime',
        'is_mobile' => 'boolean',
        'is_tablet' => 'boolean',
        'is_desktop' => 'boolean',
        'is_robot' => 'boolean',
    ];

    // ✅ Dinonaktifkan karena sudah ada 'waktu_kunjungan' yang dikelola manual.
    public $timestamps = false;

    // Boot method untuk auto-fill data
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->waktu_kunjungan) {
                $model->waktu_kunjungan = now();
            }

            // Parse user agent jika ada dan browser info belum diisi
            if ($model->user_agent && !$model->browser) {
                $model->fillBrowserInfo($model->user_agent);
            }
        });
    }

    // Method untuk mengisi informasi browser
    public function fillBrowserInfo($userAgent = null)
    {
        // ✅ PERBAIKAN: Dapatkan instance dari service container, lalu panggil parse().
        $result = app(Browser::class)->parse($userAgent);

        $this->browser = $result->browserName();
        $this->browser_version = $result->browserVersion();
        $this->platform = $result->platformName();
        $this->device = $result->deviceModel() ?: $result->deviceFamily();
        // ✅ Menggunakan method helper yang sudah direfaktor
        $this->device_type = self::determineDeviceType($result);
        $this->is_mobile = $result->isMobile();
        $this->is_tablet = $result->isTablet();
        $this->is_desktop = $result->isDesktop();
        $this->is_robot = $result->isBot();
    }

    // Helper untuk menentukan tipe device (sudah digabung)
    private static function determineDeviceType($result)
    {
        if ($result->isMobile()) return 'Mobile';
        if ($result->isTablet()) return 'Tablet';
        if ($result->isDesktop()) return 'Desktop';
        if ($result->isBot()) return 'Bot/Robot';
        return 'Unknown';
    }

    // Scopes
    public function scopeHariIni($query)
    {
        return $query->whereDate('waktu_kunjungan', today());
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('waktu_kunjungan', now()->month)
            ->whereYear('waktu_kunjungan', now()->year);
    }

    public function scopeTahunIni($query)
    {
        return $query->whereYear('waktu_kunjungan', now()->year);
    }

    public function scopeHalaman($query, $halaman)
    {
        return $query->where('halaman_dikunjungi', $halaman);
    }

    public function scopePeriode($query, $mulai, $selesai)
    {
        return $query->whereBetween('waktu_kunjungan', [$mulai, $selesai]);
    }

    public function scopeManusia($query)
    {
        return $query->where('is_robot', false);
    }

    public function scopeRobot($query)
    {
        return $query->where('is_robot', true);
    }

    public function scopeMobile($query)
    {
        return $query->where('is_mobile', true);
    }

    public function scopeDesktop($query)
    {
        return $query->where('is_desktop', true);
    }

    // Helper methods
    public static function trackVisit($request, $halamanDikunjungi = null)
    {
        // Ambil informasi lokasi dari IP Address
        // 'false' sebagai parameter kedua agar tidak error jika IP tidak ditemukan (misal: localhost)
        $position = Location::get($request->ip());
        // Ambil informasi browser
        $browserResult = app(Browser::class)->parse($request->userAgent());

        // Siapkan data untuk disimpan
        $data = [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $browserResult->browserName(),
            'browser_version' => $browserResult->browserVersion(),
            'platform' => $browserResult->platformName(),
            'device' => $browserResult->deviceModel() ?: $browserResult->deviceFamily(),
            'device_type' => self::determineDeviceType($browserResult),
            'is_mobile' => $browserResult->isMobile(),
            'is_tablet' => $browserResult->isTablet(),
            'is_desktop' => $browserResult->isDesktop(),
            'is_robot' => $browserResult->isBot(),
            'halaman_dikunjungi' => $halamanDikunjungi ?? $request->path(),
            'referrer' => $request->header('referer'),
            'waktu_kunjungan' => now(),
            // Tambahkan data lokasi jika berhasil didapatkan
            'negara' => $position ? $position->countryName : null,
            'kota' => $position ? $position->cityName : null,
            // Simpan semua data mentah dari API untuk referensi
            'data_lokasi' => $position ? $position->toArray() : null,
        ];

        return self::create($data);
    }

    public static function getStatistik($periode = 'hari')
    {
        $query = self::query()->manusia();

        switch ($periode) {
            case 'hari':
                $query->hariIni();
                break;
            case 'bulan':
                $query->bulanIni();
                break;
            case 'tahun':
                $query->tahunIni();
                break;
        }

        // Clone query untuk digunakan di beberapa agregat tanpa saling mempengaruhi
        $baseQuery = clone $query;

        return [
            'total_pengunjung' => $baseQuery->count(),
            'pengunjung_unik' => (clone $baseQuery)->distinct('ip_address')->count('ip_address'),
            'halaman_terpopuler' => (clone $baseQuery)->groupBy('halaman_dikunjungi')
                ->selectRaw('halaman_dikunjungi, COUNT(*) as jumlah')
                ->orderBy('jumlah', 'desc')
                ->limit(10)
                ->get(),
            'browser_stats' => (clone $baseQuery)->groupBy('browser')
                ->selectRaw('browser, COUNT(*) as jumlah')
                ->orderBy('jumlah', 'desc')
                ->get(),
            'platform_stats' => (clone $baseQuery)->groupBy('platform')
                ->selectRaw('platform, COUNT(*) as jumlah')
                ->orderBy('jumlah', 'desc')
                ->get(),
            'device_stats' => (clone $baseQuery)->groupBy('device')
                ->selectRaw('device, COUNT(*) as jumlah')
                ->orderBy('jumlah', 'desc')
                ->get(),
        ];
    }

    public static function getGrafikKunjungan($periode = 30, $excludeRobots = true)
    {
        $query = self::selectRaw('DATE(waktu_kunjungan) as tanggal, COUNT(*) as jumlah')
            ->where('waktu_kunjungan', '>=', now()->subDays($periode));

        if ($excludeRobots) {
            $query->manusia();
        }

        return $query->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    }

    public static function getPengunjungBerulang($periode = 30)
    {
        return self::select('ip_address')
            ->manusia()
            ->where('waktu_kunjungan', '>=', now()->subDays($periode))
            ->groupBy('ip_address')
            ->havingRaw('COUNT(*) > 1')
            ->count();
    }

    public function getDurasiFormatted()
    {
        if (!$this->durasi) {
            return '-';
        }

        $menit = floor($this->durasi / 60);
        $detik = $this->durasi % 60;

        if ($menit > 0) {
            return "{$menit} menit {$detik} detik";
        }

        return "{$detik} detik";
    }

    public function getDeviceInfo()
    {
        return [
            'browser' => $this->browser,
            'browser_version' => $this->browser_version,
            'platform' => $this->platform,
            'device' => $this->device,
            'device_type' => $this->device_type,
            'is_mobile' => $this->is_mobile,
            'is_tablet' => $this->is_tablet,
            'is_desktop' => $this->is_desktop,
            'is_robot' => $this->is_robot,
        ];
    }

    public function updateLokasi($dataLokasi)
    {
        $this->update([
            'negara' => $dataLokasi['country'] ?? null,
            'kota' => $dataLokasi['city'] ?? null,
            'data_lokasi' => $dataLokasi,
        ]);
    }

    public static function getBrowserCompatibility()
    {
        return self::manusia()
            ->selectRaw('browser, browser_version, COUNT(*) as jumlah')
            ->groupBy('browser', 'browser_version')
            ->orderBy('jumlah', 'desc')
            ->get();
    }

    public static function getPlatformUsage($periode = 30)
    {
        return self::manusia()
            ->where('waktu_kunjungan', '>=', now()->subDays($periode))
            ->selectRaw('platform, device_type, COUNT(*) as jumlah')
            ->groupBy('platform', 'device_type')
            ->orderBy('jumlah', 'desc')
            ->get();
    }
}
