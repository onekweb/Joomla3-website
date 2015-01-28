<?php

// autoload_real.php generated by Composer

class ComposerAutoloaderInit58e664fa734e460c727d16549856fe8c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('ComposerClassLoader' === $class) {
            require dirname(__FILE__) . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit58e664fa734e460c727d16549856fe8c', 'loadClassLoader'), true);
        self::$loader = $loader = new ComposerClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInit58e664fa734e460c727d16549856fe8c', 'loadClassLoader'));

        $vendorDir = dirname(dirname(__FILE__));
        $baseDir = dirname($vendorDir);

        $map = require dirname(__FILE__) . '/autoload_namespaces.php';
        foreach ($map as $namespace => $path) {
            $loader->add($namespace, $path);
        }

        $classMap = require dirname(__FILE__) . '/autoload_classmap.php';
        if ($classMap) {
            $loader->addClassMap($classMap);
        }

        $loader->register(false);

        return $loader;
    }
}