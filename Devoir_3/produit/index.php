<?php
$path = $route['path'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $route['method'] ?? $_SERVER['REQUEST_METHOD'];
$baseUrl = $route['base'] ?? '';

require __DIR__ . '/controllers/ProduitController.php';

$controller = new ProduitController(__DIR__, $baseUrl);

if ($path === '/produits') {
    if ($method === 'GET') {
        $controller->index();
        exit;
    }
}

if ($path === '/produits/ajouter') {
    if ($method === 'POST') {
        $controller->store();
        exit;
    }
    $controller->create();
    exit;
}

if (preg_match('#^/produits/([0-9]+)$#', $path, $matches)) {
    $controller->show((int)$matches[1]);
    exit;
}

if (preg_match('#^/produits/([0-9]+)/editer$#', $path, $matches)) {
    if ($method === 'POST') {
        $controller->update((int)$matches[1]);
        exit;
    }
    $controller->edit((int)$matches[1]);
    exit;
}

if (preg_match('#^/produits/([0-9]+)/supprimer$#', $path, $matches)) {
    $controller->destroy((int)$matches[1]);
    exit;
}

http_response_code(404);
echo '404';
