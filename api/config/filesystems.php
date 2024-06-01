<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'sftp' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST'),

            // Settings for basic authentication...
            'username' => env('SFTP_USERNAME'),
            'password' => env('SFTP_PASSWORD'),

            // Settings for SSH key based authentication with encryption password...
            'privateKey' => env('SFTP_PRIVATE_KEY'),
            'passphrase' => env('SFTP_PASSPHRASE'),

            // Settings for file / directory permissions...
            'visibility' => 'private', // `private` = 0600, `public` = 0644
            'directory_visibility' => 'private', // `private` = 0700, `public` = 0755

            // Optional SFTP Settings...
            // 'hostFingerprint' => env('SFTP_HOST_FINGERPRINT'),
            // 'maxTries' => 4,
            // 'passphrase' => env('SFTP_PASSPHRASE'),
            // 'port' => env('SFTP_PORT', 22),
            // 'root' => env('SFTP_ROOT', ''),
            // 'timeout' => 30,
            // 'useAgent' => true,
        ],

        'sftp_to_new_flask_2cpu' => [
            'driver' => 'sftp',
            'host' => 'https://3.65.27.242',

            // Settings for basic authentication...
            'username' => 'ubuntu',
            // 'password' => env('SFTP_PASSWORD'),

            // Settings for SSH key based authentication with encryption password...
            'privateKey' => '-----BEGIN RSA PRIVATE KEY-----
            MIIEowIBAAKCAQEAjQeAVewi/WghLT1QLIzouyo99qNbPifqdwTunr4t2X6qK/fg
            bSxukMRzUQr6MspNsXrk029uX6tNDIXKwJLfYeQlKf6/Yy5eA6rBukhq7H8rGaLI
            GesQbBOiExRxVD7VCZMxA4mQXV5CxMg/mmHcGUjkpyHBmvLrqi8ep8//V8bMoPiq
            EPBKeZa0uZ4bGbHpOgmkNxDg6D+6FCQn66hoSJ0hk+3w3mxJyYjfOl2/bUGlBurp
            bEFR8EjI0Z4xo64ZL971JBcb226KBCAB0xtvVsFPel5UxbgxPwFVpHGvuMgSjQkQ
            Sh6kdEU6EpwatDi0vKE5PRXb96faGdz7Z/MJnQIDAQABAoIBAE5UTENs1EJLA6JM
            26ri2KCb5a6HLLZpFSDl7GLe3jhe0cV593yroP1nH2Vz42MyWdSpnU6SJYudaT37
            UZGEAe4s+TdJ9qLvref7f34nmrugJiAm+Vzr4kMk5HAUep2ACHM4/ZApZ7V0FUGW
            tzzX/ZdNlTH+3bliEuKDKVOrgvcM7aU3Dftbk+Z6iUF12KNeD+vHa19DKwquLd/a
            eeKunoz+3iATE1EX/FGEPZgse2sbL2GWO2jp8AkIcYzrDI/3YtgvR2KeXChQ4ma6
            82Dhva2x0y24M1BAaGA3iIA8ZbUx0Jx6rrS1GjIH6tifs3TJDnKdRibmYbJ4/qtY
            7Qbzr0ECgYEA4PLt4vK039dMyVQK71ZaqEI3fz9CKASXlPHUawX2s4n0Q2RYci9Y
            mp7RamVZJkoN3xJn9a2C4gN6qhiI4NX3XHrZhEO7lOgqdveyDpgX/MIO5NsF4SEI
            mYK/RsArrPQ24tzem1zN0NKlau3kzDtBD5nKhuknyW0ESjJ0zo2Nja8CgYEAoH8V
            yHOSvjo2OqTvJbv6u6qTTcS69RtLBlC6AgJUL+Fy45g536c7plKo8lNQwQgJY6D6
            Bv5IyHaXeEHT+6fDqHSHMCjluDC6ClSUBp1Tk8fJtBsogfzEzLs+9Wfla6HbE3Ss
            An2pZL3akgmF0m+KIhJwkpDU6xg8Xcx1np6G3HMCgYBe3VQBH4Wz2GIjjXPHF03I
            I5Sv7weBRN6AC7QfJjax5H3EZe7+yIS/QDbkfbUo9pX++w4oh3HoyrrSPOKMnu9g
            ataMdtwGoho2baMDkJSdHWGWld9W3812n7L2rVg96geziJ3AO1T4ubzU6VpR3rND
            VwIX/v+ubHEgsUKdUQjfNQKBgFe3/cTX/e0ATeFRge+CxTBKs0W+71vFdgTWnEM6
            2J5uvudLrN3jPgPSi8od5TYLWW5dbiniUw9VWcX9XInfkF2City0jZFU+Glq/ph6
            5lIP0NsiOMqKx1kKQgfIqChihyUkEFswKSQJa+uDTuPL2Jh0sZg5llWDooK1m9d8
            10KnAoGBAK5MKyQcgzASKopcUVFUO4s83r6IvTlLBwq5rG0OKkhk/XCuDWLpPdfa
            ZKukoQw3u3L9Agr1o8wqySmdKu/7JZ/xMCD++Ef4DTF/LA2IqjH+zuh2TCr3gSWJ
            mK2pKzYLqaqasZSHE/Rlc1ob0xzKHhO13s21sz2T2NGFGNVO+ytZ
            -----END RSA PRIVATE KEY-----',
            // 'passphrase' => env('SFTP_PASSPHRASE'),

            // Settings for file / directory permissions...
            'visibility' => 'private', // `private` = 0600, `public` = 0644
            'directory_visibility' => 'private', // `private` = 0700, `public` = 0755

            // Optional SFTP Settings...
            // 'hostFingerprint' => env('SFTP_HOST_FINGERPRINT'),
            // 'maxTries' => 4,
            // 'passphrase' => env('SFTP_PASSPHRASE'),
            'port' => '22',
            // 'root' => env('SFTP_ROOT', ''),
            // 'timeout' => 30,
            // 'useAgent' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
