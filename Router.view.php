<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$routes = [
    '/' => './controllers/handlers/GetdataController.php',
    '/Store' => './controllers/handlers/StoreDataControllers.php',
    '/Edit' => './controllers/handlers/EditHandlerControllers.php',
    '/Delete' => './controllers/handlers/DeleteHandlersController.php',
];
if(array_key_exists($uri, $routes)){
 require_once $routes[$uri];
}
else{
    echo 'error 404';
};
?>