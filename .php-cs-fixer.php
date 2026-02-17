<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/tests'])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'declare_strict_types' => true,
        'phpdoc_align' => false,
        'phpdoc_to_comment' => false,
        'single_quote' => true,
        'strict_param' => true,
    ])
    ->setFinder($finder);
