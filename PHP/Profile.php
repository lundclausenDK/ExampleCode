<?php

class Profile {

    private $id;
    private $username;
    private $password;
    private $fullname;
    private $address;
    private $zip;
    private $city;
    private $phone;
    private $gender;
    private $birthyear;
    private $title;
    private $geo;
    private $contract;

    public function __construct($id, $username, $password, $fullname, $address, $zip, $city, $phone, $gender, $birthyear, $title, $geo, $contract) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->address = $address;
        $this->zip = $zip;
        $this->city = $city;
        $this->phone = $phone;
        $this->gender = $gender;
        $this->birthyear = $birthyear;
        $this->title = $title;
        $this->geo = $geo;
        $this->contract = $contract;
    }

    // Getters and setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

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

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getBirthyear() {
        return $this->birthyear;
    }

    public function setBirthyear($birthyear) {
        $this->birthyear = $birthyear;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getGeo() {
        return $this->geo;
    }

    public function setGeo($geo) {
        $this->geo = $geo;
    }

    public function getContract() {
        return $this->contract;
    }

    public function setContract($contract) {
        $this->contract = $contract;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }
}