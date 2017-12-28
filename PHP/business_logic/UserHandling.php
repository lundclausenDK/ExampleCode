<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/User.php");
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/UserMapper.php");

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/profile/Specs.php");
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/SpecsMapper.php");

class UserHandling {

    function createUser() {
        // Get form input
        $user_name = $_POST["email"];
        $user_pass = hash("sha256", $_POST["password"]);

        // Create User object
        $newUser = new User($user_name, $user_pass);

        // Send to mapper
        $mapper = new UserMapper();
        $mapper->add($newUser);
    }

    function deleteUser() {

    }

    function changeUserPassword() {

    }

    function updateSpecs() {
        // Get form input, if submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user_name = $_POST['user_name'];
            $gender = $_POST['gender'];
            $age = $_POST['age'];
            $height = $_POST['height'];
            $body_type = $_POST['body_type'];
            $has_kids = $_POST['has_kids'];
            $region = $_POST['region'];
            $job = $_POST['job'];
            $education = $_POST['education'];

            // Create Specs object
            $newSpecs = new Specs($user_name, $gender, $age, $height, $body_type, $has_kids, $region, $job, $education);

            // Send Specs object to SpecsMapper
            $mapper = new SpecsMapper();
            $mapper->add($newSpecs);

        }
    }


}