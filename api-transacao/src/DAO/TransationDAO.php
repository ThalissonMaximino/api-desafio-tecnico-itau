<?php 

namespace Src\DAO;

use Src\config\conection;
use Src\Model\Transation;
use PDO;


class TransationDAO
{
    private $data_base;

    public function __construct(){
        $this->data_base = conection::getConn();
    }

    public function insert(Transation $transation)
    {
        $stmt = $this->data_base->prepare(
            "INSERT INTO transacao (ID,VALOR,DATE_OP) VALUES (?,?,?)");
        $stmt->execute([$transation->getID(),$transation->getValue(),$transation->getDate_op()]);
    }

    public function exist($id)
    {
        $stmt = $this->data_base->prepare("SELECT COUNT(*) FROM transacao WHERE ID = ?");
        $stmt->execute([$id]);

        return $stmt->fetchColumn() > 0;
    }

    public function dataReturnById($id) {
        $stmt = $this->data_base->prepare("SELECT * FROM transacao WHERE ID = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return [
                'id' => $result['ID'],
                'valor' => (float)$result['VALOR'],
                'dataHora' => $result['DATE_OP']
            ];
        } 
        else
        {
            return null;
        }
    }

    public function dataDeleteById($id) {
        $stmt = $this->data_base->prepare("DELETE FROM transacao WHERE ID = ?");
        return $stmt->execute([$id]);
    }
}