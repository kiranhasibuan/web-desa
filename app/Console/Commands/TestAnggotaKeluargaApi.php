<?php

namespace App\Console\Commands;

use App\Models\AnggotaKeluarga;
use Illuminate\Console\Command;

class TestAnggotaKeluargaApi extends Command
{
    protected $signature = 'test:anggota-keluarga-api';
    protected $description = 'Test AnggotaKeluarga API connection';

    public function handle()
    {
        $this->info('Testing AnggotaKeluarga API connection...');

        $result = AnggotaKeluarga::testApiConnection();

        if ($result['success']) {
            $this->info('✅ API connection successful!');
            $this->table(['Key', 'Value'], [
                ['Status', $result['status']],
                ['URL', $result['url']],
                ['Data Count', isset($result['response']['data']) ? count($result['response']['data']) : 'N/A']
            ]);
        } else {
            $this->error('❌ API connection failed!');
            $this->error('Error: ' . ($result['error'] ?? 'Unknown error'));
            $this->line('URL: ' . $result['url']);
            return;
        }

        $this->info('Testing data fetch...');

        try {
            AnggotaKeluarga::clearApiCache();
            $data = (new AnggotaKeluarga)->getRows();

            $recordCount = is_array($data) ? count($data) : 0;
            $this->info("✅ Fetched {$recordCount} records");

            if ($recordCount > 0) {
                $sample = $data[0];
                $this->line('Sample data fields:');
                $this->table(['Field', 'Value'], collect($sample)->take(10)->map(function ($value, $key) {
                    if (is_array($value)) {
                        return [$key, json_encode($value)];
                    } else {
                        return [$key, (string) $value];
                    }
                })->toArray());

                // Test model queries
                $this->info('Testing model queries:');
                $totalCount = AnggotaKeluarga::count();
                $adaCount = AnggotaKeluarga::ada()->count();
                $lakiCount = AnggotaKeluarga::lakiLaki()->count();
                $perempuanCount = AnggotaKeluarga::perempuan()->count();

                $this->table(['Query', 'Count'], [
                    ['Total AnggotaKeluarga', $totalCount],
                    ['Status Ada', $adaCount],
                    ['Laki-laki', $lakiCount],
                    ['Perempuan', $perempuanCount],
                ]);
            } else {
                $this->warn('No data fetched from API');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error during data fetch:');
            $this->error($e->getMessage());
            $this->line('File: ' . $e->getFile() . ':' . $e->getLine());
        }
    }
}
