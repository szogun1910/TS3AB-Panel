<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd89abcc3f20b07c978e65fe6b4b07c18
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'Yosymfony\\Toml\\' => 15,
            'Yosymfony\\ParserUtils\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Yosymfony\\Toml\\' => 
        array (
            0 => __DIR__ . '/..' . '/yosymfony/toml/src',
        ),
        'Yosymfony\\ParserUtils\\' => 
        array (
            0 => __DIR__ . '/..' . '/yosymfony/parser-utils/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd89abcc3f20b07c978e65fe6b4b07c18::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd89abcc3f20b07c978e65fe6b4b07c18::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}