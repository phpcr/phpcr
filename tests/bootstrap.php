<?php
/**
 * This is a bootstrap for phpUnit unit tests
 *
 * @author Nacho Martín <nitram.ohcan@gmail.com>
 */
if (!class_exists('PHPUnit_Framework_TestCase') ||
    version_compare(PHPUnit_Runner_Version::id(), '3.5') < 0
) {
    die('PHPUnit framework is required, at least 3.5 version');
}

if (!class_exists('PHPUnit_Framework_MockObject_MockBuilder')) {
    die('PHPUnit MockObject plugin is required, at least 1.0.8 version');
}

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
