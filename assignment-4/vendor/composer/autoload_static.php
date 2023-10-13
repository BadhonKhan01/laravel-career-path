<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit473fb6e9e14a3550e0f655b566a5f438
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit473fb6e9e14a3550e0f655b566a5f438::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit473fb6e9e14a3550e0f655b566a5f438::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit473fb6e9e14a3550e0f655b566a5f438::$classMap;

        }, null, ClassLoader::class);
    }
}
