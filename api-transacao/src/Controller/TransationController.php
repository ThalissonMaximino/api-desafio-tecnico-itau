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
}