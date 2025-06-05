<?php 

namespace Src\Controller;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Src\Model\Transation;
use Src\DAO\TransationDAO;

class TransationController {
    
    public function insert(Request $request, Response $response) {

        $trsn = $request->getParsedBody();

        if (empty($trsn) || !is_array($trsn)) {
            return $response->withStatus(400);
        }

        if (!isset($trsn['id'], $trsn['valor'], $trsn['dataHora'])) {
            return $response->withStatus(422);
        }

        if (is_string(value: $trsn['valor']))
        {
            return $response->withStatus(code: 422);
        }

        if (!preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $trsn['id'])) {
            return $response->withStatus(422);
        }

        $timezone = new \DateTimeZone('America/Fortaleza');

        $data = \DateTime::createFromFormat('Y-m-d H:i:s', $trsn['dataHora'], $timezone);
        if (!$data || $data->format('Y-m-d H:i:s') !== $trsn['dataHora']) {
            return $response->withStatus(415); 
        }

        $agora = new \DateTime('now', $timezone);

        if ($data > $agora) {
            return $response->withStatus(422);
        }

        $dao = new TransationDAO();
        $transation = new Transation($trsn['id'],$trsn['valor'],$trsn['dataHora']);

        if ($dao->exist($trsn['id'])) {
            return $response->withStatus(422); 
        }

        if ((floatval($trsn['valor']) < 0)) {
            return $response->withStatus(422);
        }

        $dao->insert($transation);

        return $response->withStatus(201);     
    }

    public function DataReturnById(Request $request, Response $response, array $args) {

        $dao = new TransationDAO;

        $id = $args['id'] ?? null;

        if ($id === null || empty($id)) {
            return $response->withStatus(404);
        }

        $result = $dao->dataReturnById($args['id']);

        if ($result) {
            $response->getBody()->write(json_encode($result));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            return $response->withStatus(404);
        }
    }

    public function dataDeleteById(Request $request, Response $response, array $args) {

        $dao = new TransationDAO;

        $id = $args['id'] ?? null;

    
        if ($id === null || empty($id)) {
            return $response->withStatus(404);
        }

        $verify = $dao->exist($id);

        if($verify)
        {
            $dao->dataDeleteById($id);
            return $response->withStatus(200);
        }else
        {
            return $response->withStatus(404);
        }
        
    }

    public function dataDelete(Request $request, Response $response) {

        $dao = new TransationDAO;
        
        $dao->allDataDelete();

        return $response->withStatus(200);
    }

    public function calculateStatistics(Request $request, Response $response) {
        $dao = new TransationDAO();
        $transactions = $dao->getTransactionsInLast60Seconds();

        $count = count($transactions);
        $sum = 0.0;
        $avg = 0.0;
        $min = 0.0;
        $max = 0.0;

        if ($count > 0) {
            $values = array_column($transactions, 'VALOR'); 
            
            $values = array_map('floatval', $values);

            $sum = array_sum($values);
            $avg = $sum / $count;
            $min = min($values);
            $max = max($values);
        }

        $statistics = [
            'count' => $count,
            'sum' => round($sum, 2),
            'avg' => round($avg, 2),
            'min' => round($min, 2),
            'max' => round($max, 2),
        ];

        $response->getBody()->write(json_encode($statistics));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}