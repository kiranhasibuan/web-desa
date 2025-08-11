<?php

return [

    'title' => 'Masuk',

    'heading' => 'Masuk ke akun Anda',

    'actions' => [

        'register' => [
            'before' => 'atau',
            'label' => 'tambah akun baru',
        ],

        'request_password_reset' => [
            'label' => 'Lupa kata sandi?',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Alamat email',
        ],

        'password' => [
            'label' => 'Kata sandi',
        ],

        'remember' => [
            'label' => 'Ingat saya',
        ],

        'actions' => [

            'authenticate' => [
                'label' => 'Masuk',
            ],

        ],

    ],

    'messages' => [

        'failed' => 'Akun yang diberikan tidak dapat ditemukan.',

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Terlalu banyak permintaan',
            'body' => 'Silakan coba lagi dalam :seconds detik.',
        ],

    ],

];
