<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/Message.php");
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/MessageMapper.php");

class MessageHandling {

    function createMessage() {
        session_start();

        $from_id = $_SESSION["user_id"];
        $to_id = $_POST["to_id"];
        $message = $_POST["message"];

        // Create new message object
        $newMessage = new Message($from_id, $to_id, $message);

        // Send to mapper
        $mapper = new MessageMapper();
        $mapper->add($newMessage);

    }

}