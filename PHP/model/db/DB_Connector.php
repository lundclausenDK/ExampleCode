<?php

class DB_Connector {

    private $servername = "127.0.0.1";
    private $username = "root";
    private $password = ""; // remember to correct this going live
    private $dbname = "yogi_db";

    // Create connection
    public function newConnection() {

        $con = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check connection
        if ($con->connect_error) {
            die("Error msg: " . $con->connect_error);
        }

        //echo "Connection successfully!";

        return $con;
    }


}
