<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/routes',
        __DIR__ . '/config',
        __DIR__ . '/database',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
