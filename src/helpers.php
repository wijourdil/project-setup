<?php

function setup_package_stub_path(string $path = ''): string
{
    $path = ltrim($path, '/');
    return __DIR__ . "/../stubs/$path";
}
