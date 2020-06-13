<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit89fe739ff62c3bc16d4cf4e36e0f3e54
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Teknomavi\\Tcmb\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Teknomavi\\Tcmb\\' => 
        array (
            0 => __DIR__ . '/..' . '/teknomavi/tcmb/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit89fe739ff62c3bc16d4cf4e36e0f3e54::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit89fe739ff62c3bc16d4cf4e36e0f3e54::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}