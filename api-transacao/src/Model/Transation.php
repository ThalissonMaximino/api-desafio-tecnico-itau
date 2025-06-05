<?php 

namespace Src\Model;

class Transation
{
    private $id;
    private $value;
    private $date_op;


    public function __construct($id,$value,$date_op)
    {
        $this->id = $id;
        $this->value = $value;
        $this->date_op = $date_op;
    }

    public function getID(){return $this->id;}
    public function getValue(){return $this->value;}
    public function getDate_op(){return $this->date_op;}
    public function setID($id){$this->id = $id;}
    public function setValue($value){$this->value = $value;}
    public function setDate_op($date_op){$this->date_op = $date_op;}
}