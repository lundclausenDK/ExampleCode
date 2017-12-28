<?php

class Specs {

    private $user_id;
    private $user_name;
    private $gender;
    private $age;
    private $height;
    private $body_type;
    private $has_kids;
    private $region;
    private $job;
    private $education;

    function __construct($user_id, $user_name, $gender, $age, $height, $body_type, $has_kids, $region, $job, $education) {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->gender = $gender;
        $this->age = $age;
        $this->height = $height;
        $this->body_type = $body_type;
        $this->has_kids = $has_kids;
        $this->region = $region;
        $this->job = $job;
        $this->education = $education;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function setUserName($user_name) {
        $this->user_name = $user_name;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getBodyType() {
        return $this->body_type;
    }

    public function setBodyType($body_type) {
        $this->body_type = $body_type;
    }

    public function getHasKids() {
        return $this->has_kids;
    }

    public function setHasKids($has_kids) {
        $this->has_kids = $has_kids;
    }

    public function getRegion() {
        return $this->region;
    }

    public function setRegion($region) {
        $this->region = $region;
    }

    public function getJob() {
        return $this->job;
    }

    public function setJob($job) {
        $this->job = $job;
    }

    public function getEducation() {
        return $this->education;
    }

    public function setEducation($education) {
        $this->education = $education;
    }



}