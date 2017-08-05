<?php

$finder = PhpCsFixer\Finder::create()
    ->in('module')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@PSR1' => true,
        'ordered_imports' => true,
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
;