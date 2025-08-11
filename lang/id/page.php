<?php

return [
    'general_settings' => [
        'title' => 'Pengaturan Umum',
        'heading' => 'Pengaturan Umum',
        'subheading' => 'Kelola pengaturan situs umum di sini.',
        'navigationLabel' => 'Umum',
        'sections' => [
            'site' => [
                'title' => 'Lokasi',
                'description' => 'Kelola Pengaturan Dasar.',
            ],
            'theme' => [
                'title' => 'Tema',
                'description' => 'Ubah tema default.',
            ],
        ],
        'fields' => [
            'brand_name' => 'Nama merek',
            'site_active' => 'Status situs',
            'brand_logoHeight' => 'Tinggi logo merek',
            'brand_logo' => 'Logo Merek',
            'site_favicon' => 'Situs Favicon',
            'primary' => 'Utama',
            'secondary' => 'Sekunder',
            'gray' => 'Abu-abu',
            'success' => 'Kesuksesan',
            'danger' => 'Bahaya',
            'info' => 'Info',
            'warning' => 'Peringatan',
        ],
    ],
    'mail_settings' => [
        'title' => 'Pengaturan Email',
        'heading' => 'Pengaturan Email',
        'subheading' => 'Kelola Konfigurasi Email.',
        'navigationLabel' => 'Email',
        'sections' => [
            'config' => [
                'title' => 'Konfigurasi',
                'description' => 'keterangan',
            ],
            'sender' => [
                'title' => 'Dari (pengirim)',
                'description' => 'keterangan',
            ],
            'mail_to' => [
                'title' => 'Email ke',
                'description' => 'keterangan',
            ],
        ],
        'fields' => [
            'placeholder' => [
                'receiver_email' => 'Email Penerima ..',
            ],
            'driver' => 'Driver',
            'host' => 'Host',
            'port' => 'Port',
            'encryption' => 'Enkripsi',
            'timeout' => 'Batas waktu',
            'username' => 'Username',
            'password' => 'Kata sandi',
            'email' => 'E-mail',
            'name' => 'Nama',
            'mail_to' => 'Email ke',
        ],
        'actions' => [
            'send_test_mail' => 'Kirim email tes',
        ],
    ]
];
