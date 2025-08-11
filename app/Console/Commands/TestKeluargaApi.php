<?php
// app/Console/Commands/TestKeluargaApi.php

namespace App\Console\Commands;

use App\Models\Keluarga;
use Illuminate\Console\Command;

class TestKeluargaApi extends Command
{
    protected $signature = 'test:keluarga-api';
    protected $description = 'Test Keluarga API connection';

    public function handle()
    {
        $this->info('Testing API connection...');

        $result = Keluarga::testApiConnection();

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
            Keluarga::clearApiCache();
            $data = (new Keluarga)->getRows();

            // Fix: Separate count from string interpolation
            $recordCount = is_array($data) ? count($data) : 0;
            $this->info("✅ Fetched {$recordCount} records");

            if ($recordCount > 0) {
                $sample = $data[0];

                // Debug: Show data structure
                $this->line('Sample data structure:');
                $this->table(['Field', 'Value'], collect($sample)->take(10)->map(function ($value, $key) {
                    if (is_array($value)) {
                        return [$key, json_encode($value)];
                    } elseif (is_object($value)) {
                        return [$key, get_class($value)];
                    } else {
                        return [$key, (string) $value];
                    }
                })->toArray());

                // Show all available fields
                $this->line("\nAll available fields:");
                $this->line(implode(', ', array_keys($sample)));
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
