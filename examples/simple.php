<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/pbj-schema-stores.php';

use Gdbots\Pbjc\Compiler;
use Gdbots\Pbjc\CompileOptions;
use Gdbots\Pbjc\SchemaStore;
use Gdbots\Pbjc\Util\OutputFile;

SchemaStore::addDir(__DIR__.'/schemas');

$compiler = new Compiler();

$namespaces = ['acme:blog', 'acme:core'];

// generate PHP files
$compiler->run('php', new CompileOptions([
    'namespaces' => $namespaces,
    'output' => __DIR__.'/src',
    'manifest' => __DIR__.'/pbj-schemas.php',
    'callback' => function (OutputFile $file) {
        echo highlight_string($file->getContents(), true).'<hr />';
    },
]));
