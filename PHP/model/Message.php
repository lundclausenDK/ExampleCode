<?php

class Message {

    private $from_id;
    private $to_id;
    private $message;

    function __construct($from_id, $to_id, $message) {
        $this->from_id = $from_id;
        $this->to_id = $to_id;
        $this->message = $message;
    }

    // Getters and setters
    public function getFromId() {
        return $this->from_id;
    }

    public function setFromId($from_id) {
        $this->from_id = $from_id;
    }

    public function getToId() {
        return $this->to_id;
    }

    public function setToId($to_id) {
        $this->to_id = $to_id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    /*
    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
    */


}