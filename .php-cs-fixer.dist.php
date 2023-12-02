<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
    ->name('*.php')
;

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'single_line_throw' => false,
        'visibility_required' => ['elements' => ['method', 'property']], // const only possible once we drop PHP 5.6 support
    ])
    ->setFinder($finder)
;
