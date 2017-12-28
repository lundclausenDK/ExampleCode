<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/db/DB_Connector.php");
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/Yogi/model/mappers/iMapper.php");

class SpecsMapper implements iMapper {
    function getConnection() {
        $dbc = new DB_Connector();
        return $dbc->newConnection();
    }

    function add($Object) {
        // Get session
        session_start();

        // Get connection
        $con = $this->getConnection();

        // Get logged-in user id
        $user_id = $_SESSION["user_id"];

        // Get object data
        $user_name = $Object->getUserName();
        $gender = $Object->getGender();
        $age = $Object->getAge();
        $height = $Object->getHeight();
        $body_type = $Object->getBodyType();
        $has_kids = $Object->getHasKids();
        $region = $Object->getRegion();
        $job = $Object->getJob();
        $education = $Object->getEducation();

        // Prepare and execute
        $stmt = $con->prepare("INSERT INTO profile (user_id, user_name, gender, age, height, body_type, has_kids, region, job, education) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issiisssss", $user_id, $user_name, $gender, $age, $height, $body_type, $has_kids, $region, $job, $education);
        $stmt->execute();

        //echo "New records created successfully";

        $stmt->close();
        $con->close();

        header("location: ../profilepage.php?id=$user_id");
    }

    function load($id) {
        // Get connection
        $con = $this->getConnection();

        // Prepare and get data
        $stmt = $con->prepare("SELECT * FROM profile WHERE user_id = ?");

        // Bind and execute query
        $stmt->bind_param("s", $id);
        $stmt->execute();

        // Get result as array
        $result = $stmt->get_result();
        $new_row = $result->fetch_assoc();

        // Map data to variables
        $user_id = $new_row["user_id"];
        $user_name = $new_row["user_name"];
        $gender = $new_row["gender"];
        $age = $new_row["age"];
        $height = $new_row["height"];
        $body_type = $new_row["body_type"];
        $has_kids = $new_row["has_kids"];
        $region = $new_row["region"];
        $job = $new_row["job"];
        $education = $new_row["education"];

        // Pass variables to Specs object
        $specs = new Specs($user_id, $user_name, $gender, $age, $height, $body_type, $has_kids, $region, $job, $education);

        $stmt->close();
        $con->close();

        return $specs;
    }

}