<?php

require_once 'config.php';
require_once 'Database.php';
require_once 'UrlRepository.php';
require_once 'UrlService.php';
require_once 'UrlController.php';
require_once 'Response.php';

$config  = Config::getDatabaseConfig();
$baseUrl = Config::getBaseUrl();

try {
    $database     = new Database($config);
    $dbConnection = $database->getConnection();

    $urlRepository = new UrlRepository($dbConnection);
    $urlService    = new UrlService($urlRepository, $baseUrl);
    $response      = new Response();
    $controller    = new UrlController($urlService, $response);

    if (isset($_GET['code'])) {
        $controller->redirectToOriginalUrl($_GET['code']);
    }

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'compress':
                $controller->compressUrl();

                break;
            case 'api_compress':
                $controller->compressUrlApi();

                break;
            default:
                $controller->showForm();
        }
    } else {
        $controller->showForm();
    }

} catch (Exception $e) {
    http_response_code(500);

    echo 'Internal Server Error: ' . htmlspecialchars($e->getMessage());
}
