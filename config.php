<?php

class Config
{
    public static function getDatabaseConfig(): array
    {
        return [
            'host'     => 'localhost',
            'dbname'   => 'url_compression',
            'charset'  => 'utf8mb4',
            'username' => 'root',
            'password' => '',
            'port'     => 3306,
        ];
    }

    public static function getBaseUrl(): string
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . '/';
    }
}
