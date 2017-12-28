<?php

class User {

    // Variables
    private $username;
    private $password;
    //private $contract;

    // constructor
    function __construct($name, $pass) {
        $this->username = $name;
        $this->password = $pass;
        //$this->contract = $contract;
    }

    // Getters and setters
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /*
    public function getContract() {
        return $this->contract;
    }

    public function setContract($contract) {
        $this->contract = $contract;
    }
    */

}