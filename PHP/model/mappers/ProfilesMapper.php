<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/db/DB_Connector.php");
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/iMapper.php");

class ProfilesMapper implements iMapper {
    function getConnection() {
        $dbc = new DB_Connector();
        return $dbc->newConnection();
    }

    function add($Object) {
        // TODO: Implement add() method.
    }

    function load($id) {
        // Get connection
        $con = $this->getConnection();

        // Prepare and get data
        $stmt = $con->prepare("SELECT * FROM profile WHERE gender = ?");

        // Bind and execute query
        $stmt->bind_param("s", $id);
        $stmt->execute();

        // Get result as array
        $result = $stmt->get_result();
        $new_array = $result->fetch_all();

        $stmt->close();
        $con->close();

        return $new_array;
    }

}