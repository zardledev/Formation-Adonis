<?php
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($base === '/') {
    $base = '';
}
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($base !== '') {
    $path = preg_replace('#^' . preg_quote($base, '#') . '#', '', $path, 1);
}
$path = '/' . trim($path, '/');
if ($path === '/') {
    $path = '/produits';
}
$route = [
    'path' => $path,
    'method' => $_SERVER['REQUEST_METHOD'],
    'base' => $base,
];
require __DIR__ . '/produit/index.php';
