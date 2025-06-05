<?php 

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Src\Controller\TransationController;

return function(App $app) {

    $app->post('/transacao', [TransationController::class, 'insert']);
    $app->get('/transacao/{id}', [TransationController::class, 'DataReturnById']);
    $app->delete('/transacao/{id}', [TransationController::class, 'dataDeleteById']);
    $app->delete('/transacao', [TransationController::class, 'dataDelete']);
    $app->get('/estatistica', [TransationController::class, 'calculateStatistics']);
    $app->map(['GET', 'POST','DELETE',], '/{routes:.+}', function ($request, $response) { 
        return $response->withStatus(404);
    });     

};