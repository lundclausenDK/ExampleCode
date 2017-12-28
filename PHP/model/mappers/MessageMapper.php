<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/db/DB_Connector.php");
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/iMapper.php");

class MessageMapper implements iMapper {

    function getConnection() {
        $dbc = new DB_Connector();
        return $dbc->newConnection();
    }

    function add($Object) {
        // Get connection
        $con = $this->getConnection();

        // Get data
        $from_id = $Object->getFromId();
        $to_id = $Object->getToId();
        $message = $Object->getMessage();

        // Prepare and execute
        $stmt = $con->prepare("INSERT INTO messages (from_id, to_id, msg) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $from_id, $to_id, $message);
        $stmt->execute();

        // Close
        $stmt->close();
        $con->close();

        header("location: ../messages.php");
    }

    function load($id) {
        // Get connection
        $con = $this->getConnection();

        // Prepare and get data
        $stmt = $con->prepare("SELECT * FROM messages WHERE to_id = ?");

        // Bind and execute query
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Get result as array
        $result = $stmt->get_result();
        $new_row = $result->fetch_all();

        // Map data to variables
        //$msg_id = $new_row["msg_id"];

        //$from_id = $new_row["from_id"];
        //$to_id = $new_row["to_id"];
        //$msg = $new_row["msg"];

        //$timestamp = $new_row["timestamp"];

        //$message = new Message($from_id, $to_id, $msg);

        $stmt->close();
        $con->close();

        return $new_row;
    }

}