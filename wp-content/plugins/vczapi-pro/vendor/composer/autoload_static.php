<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit710e436d40e271ffebaa69b1f4cfa5df
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Codemanas\\ZoomPro\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Codemanas\\ZoomPro\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit710e436d40e271ffebaa69b1f4cfa5df::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit710e436d40e271ffebaa69b1f4cfa5df::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}