<?php

/**
 * This is a bootstrap for phpUnit unit tests
 *
 * @author Nacho Martín <nitram.ohcan@gmail.com>
 */
function phpcr_autoloader($class)
{
    if (false !== ($pos = strripos($class, '\\'))) {
        $relpath = false;
        $phpcrPos = strpos($class, 'PHPCR');
        if ($phpcrPos === 1 || $phpcrPos === 0) {
            $relpath = '/../src/';
            $class = substr($class, $phpcrPos);
            $pos = $pos - $phpcrPos;
        }

        if ($relpath) {
            // namespaced class name
            $namespace = substr($class, 0, $pos);
            $class = substr($class, $pos + 1);
            $file = __DIR__.$relpath.str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR.$class.'.php';
            if (file_exists($file)) {
                require $file;
            }

            return;
        }
    }

    return false;
}

spl_autoload_register('phpcr_autoloader');
