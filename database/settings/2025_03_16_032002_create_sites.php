<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('sites.is_maintenance', false);
        $this->migrator->add('sites.name', 'Desa Karangguli');
        $this->migrator->add('sites.logo', 'sites/logo.png');
        $this->migrator->add('sites.tagline', 'Membangun Desa Karangguli dengan Data');
        $this->migrator->add('sites.description', "Website Desa Karangguli , Pulau-Pulau Aru, Kepulauan Aru, Maluku");
        $this->migrator->add('sites.default_language', 'id');
        $this->migrator->add('sites.timezone', 'Asia/Jayapura');
        $this->migrator->add('sites.copyright_text', '© ' . date('Y') . 'Powered by Siboaten');
        $this->migrator->add('sites.terms_url', '/terms');
        $this->migrator->add('sites.privacy_url', '/privacy');
        $this->migrator->add('sites.cookie_policy_url', '/cookie-policy');
        $this->migrator->add('sites.custom_404_message', 'Ups, halaman tidak ditemukan. Ayo kembali ke halaman utama.');
        $this->migrator->add('sites.custom_500_message', 'Telah terjadi gangguan teknis yang tidak terduga. Tim kami telah diberitahu dan sedang berupaya memulihkan layanan.');
        $this->migrator->add('sites.company_name', 'Desa Karangguli');
        $this->migrator->add('sites.company_email', 'karangguli@desa.com');
        $this->migrator->add('sites.company_phone', '+628123456789');
        $this->migrator->add('sites.company_address', 'Desa Karangguli, Pulau-Pulau Aru, Kepulauan Aru, Maluku');
    }
};
