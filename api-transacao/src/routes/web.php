<?php 

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Src\Controller\TransationController;

return function(App $app) {

    
    $app->post('/transacao', [TransationController::class, 'insert']);

    

};