<?php

namespace src;

class Autoloader
{
    public static function autoload($className): void
    {
        $map = [
            'src\\'   => 'src/',
            'tests\\' => 'tests/',
        ];

        foreach ($map as $prefix => $baseDir) {
            if (str_starts_with($className, $prefix)) {
                $relativeClass = substr($className, strlen($prefix));

                $file = __DIR__ . '/../' . $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        }
    }
}