<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit837a8a9076dd72d3916c6f925997cee2
{
    public static $files = array (
        '4099d3ebc9a468a66acc157637c57f2b' => __DIR__ . '/../..' . '/helper/const.php',
        '6fe1c13751107260e38306489dd370a0' => __DIR__ . '/../..' . '/helper/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'EWVA\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'EWVA\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit837a8a9076dd72d3916c6f925997cee2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit837a8a9076dd72d3916c6f925997cee2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit837a8a9076dd72d3916c6f925997cee2::$classMap;

        }, null, ClassLoader::class);
    }
}
