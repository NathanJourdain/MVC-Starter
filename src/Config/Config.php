<?php
namespace App\Config;

class Config
{
    private const DEBUG = true;

    public static function getRoutes(): array
    {
        return [
            ["name" => "index", "slug" => "/", "action" => "App\Controller\HomeController::index", "methods" => ["GET"]],
        ];
    }

    public static function isDebug(): bool
    {
        return self::DEBUG;
    }
}