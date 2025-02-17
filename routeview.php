<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
// print_r ($uri);
$routes = [
    '/' => './controllers/handlers/StoreController.php',
    '/Store' => './controllers/handlers/HomeHandlerControllers.php',
    '/Edit' => './controllers/handlers/EditHandlerControllers.php',
    '/Delete' => './controllers/handlers/DeleteHandlersController.php',
];
if(array_key_exists($uri, $routes)){
 require_once ($routes[$uri]);
}
else{
    echo 'error 404';
};
?>