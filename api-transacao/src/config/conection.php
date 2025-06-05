<?php 

namespace Src\config;

use PDO;

class conection
{
    private static $instance;

    public static function getConn(){

        if (!isset(self::$instance)){
            self::$instance = new PDO('mysql:host=localhost;dbname=avp_back', 'root', '');
        }
        return self::$instance;
    }
}

?>