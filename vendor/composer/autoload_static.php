<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitded4d7f208057e39a57b36a2b1e40b37
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
            'GraphQL\\' => 8,
        ),
        'A' => 
        array (
            'Administrate\\PhpSdk\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
            1 => __DIR__ . '/..' . '/psr/http-factory/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'GraphQL\\' => 
        array (
            0 => __DIR__ . '/..' . '/gmostafa/php-graphql-client/src',
        ),
        'Administrate\\PhpSdk\\' => 
        array (
            0 => __DIR__ . '/..' . '/administrate/phpsdk/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitded4d7f208057e39a57b36a2b1e40b37::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitded4d7f208057e39a57b36a2b1e40b37::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitded4d7f208057e39a57b36a2b1e40b37::$classMap;

        }, null, ClassLoader::class);
    }
}
