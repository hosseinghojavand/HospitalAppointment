<?php

    class DataBaseConnector{
        
        private $serverName = "localhost";
        private $connectionOptions = array(
            "Database" => "Hospital",
            "Uid" => "sa",
            "PWD" => "YourPassword"
        );
        private $conn = null ;   // using SINGELTON design pattern
        
        public function __construct(){
            $this->conn = sqlsrv_connect($this->serverName, $this->connectionOptions);
            /*if( $this->conn)
               echo "Connected!";*/
        }
        public function get_connection() {
            return $this->conn ;
        }

    }



?>
