<?php

/**
 * Autoloader na automatické načítávanie tried
 * 
 * Namespace: App
 * Táto funkcia automaticky načítava triedy na základe ich namespace
 */

namespace App;

/**
 * Funkcia na automatické načítávanie tried
 * 
 * @param string $class Úplný názov triedy s namespace
 */
function autoload($class): void
{
    // Nahradíme namespace separátor lomítkom
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Odstraníme 'App\' z cesty
    $path = str_replace('App' . DIRECTORY_SEPARATOR, '', $path);

    // Vytvoríme plnú cestu k súboru
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $path . '.php';

    // Ak súbor existuje, načítame ho
    if (file_exists($file)) {
        require $file;
    }
}

// Registrujeme autoloader
spl_autoload_register(__NAMESPACE__ . '\\autoload');
?>